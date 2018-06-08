<?php

/**
 * @var $auth_team_id integer
 * @var $igosja_season_id integer
 * @var $team_array array
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_team_id))
{
    redirect('/wrong_page.php');
}

$num_get = $auth_team_id;

include(__DIR__ . '/include/sql/team_view_left.php');

$sql = "SELECT COUNT(`buildingbase_id`) AS `count`
        FROM `buildingbase`
        WHERE `buildingbase_ready`=0
        AND `buildingbase_team_id`=$auth_team_id
        AND `buildingbase_building_id` IN (" . BUILDING_BASE . ", " . BUILDING_BASESCOUT . ")";
$building_sql = f_igosja_mysqli_query($sql);

$building_array = $building_sql->fetch_all(MYSQLI_ASSOC);

if ($building_array[0]['count'])
{
    $on_building = true;
}
else
{
    $on_building = false;
}

$sql = "SELECT `basescout_level`,
               `basescout_my_style_count`,
               `basescout_my_style_price`,
               `basescout_scout_speed_max`,
               `basescout_scout_speed_min`,
               `team_finance`
        FROM `team`
        LEFT JOIN `basescout`
        ON `team_basescout_id`=`basescout_id`
        WHERE `team_id`=$num_get
        LIMIT 1";
$basescout_sql = f_igosja_mysqli_query($sql);

$basescout_array = $basescout_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT COUNT(`scout_id`) AS `count`
        FROM `scout`
        WHERE `scout_team_id`=$num_get
        AND `scout_season_id`=$igosja_season_id";
$scout_used_sql = f_igosja_mysqli_query($sql);

$scout_used_array = $scout_used_sql->fetch_all(MYSQLI_ASSOC);

$scout_available = $basescout_array[0]['basescout_my_style_count'] - $scout_used_array[0]['count'];

if ($data = f_igosja_request_post('data'))
{
    $confirm_data = array(
        'style' => array(),
        'price' => 0,
    );

    if (isset($data['style']))
    {
        foreach ($data['style'] as $item)
        {
            $player_id = (int) $item;

            $sql = "SELECT `name_name`,
                           `surname_name`
                    FROM `player`
                    LEFT JOIN `name`
                    ON `player_name_id`=`name_id`
                    LEFT JOIN `surname`
                    ON `player_surname_id`=`surname_id`
                    WHERE `player_id`=$player_id
                    AND `player_team_id`=$num_get
                    LIMIT 1";
            $player_sql = f_igosja_mysqli_query($sql);

            if ($player_sql->num_rows)
            {
                $sql = "SELECT COUNT(`scout_id`) AS `count`
                        FROM `scout`
                        WHERE `scout_player_id`=$player_id
                        AND `scout_ready`=0
                        AND `scout_team_id`=$num_get";
                $check_sql = f_igosja_mysqli_query($sql);

                $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);
                $count_check = $check_array[0]['count'];

                if (0 == $count_check)
                {
                    $sql = "SELECT COUNT(`scout_id`) AS `count`
                            FROM `scout`
                            WHERE `scout_player_id`=$player_id
                            AND `scout_ready`=1
                            AND `scout_team_id`=$num_get";
                    $check_sql = f_igosja_mysqli_query($sql);

                    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);
                    $count_check = $check_array[0]['count'];

                    if ($count_check < 2)
                    {
                        $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

                        $confirm_data['style'][] = array(
                            'id'    => $item,
                            'name'  => $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'],
                        );

                        $confirm_data['price'] = $confirm_data['price'] + $basescout_array[0]['basescout_my_style_price'];
                    }
                    else
                    {
                        f_igosja_session_front_flash_set('error', 'Игрок уже полностью изучен.');

                        refresh();
                    }
                }
                else
                {
                    f_igosja_session_front_flash_set('error', 'Одного игрока нельзя одновременно изучать несколько раз.');

                    refresh();
                }
            }
        }
    }

    if ($on_building)
    {
        f_igosja_session_front_flash_set('error', 'На базе сейчас идет строительство.');

        refresh();
    }
    elseif (count($confirm_data['style']) > $scout_available)
    {
        f_igosja_session_front_flash_set('error', 'У вас недостаточно стилей для изучения.');

        refresh();
    }
    elseif ($confirm_data['price'] > $basescout_array[0]['team_finance'])
    {
        f_igosja_session_front_flash_set('error', 'У вас недостаточно денег для изучения.');

        refresh();
    }

    if (isset($data['ok']))
    {
        $price = $basescout_array[0]['basescout_my_style_price'];

        foreach($confirm_data['style'] as $item)
        {
            $player_id = $item['id'];

            $sql = "INSERT INTO `scout`
                    SET `scout_player_id`=$player_id,
                        `scout_style`=1,
                        `scout_season_id`=$igosja_season_id,
                        `scout_team_id`=$num_get";
            f_igosja_mysqli_query($sql);

            $sql = "SELECT `team_finance`
                    FROM `team`
                    WHERE `team_id`=$num_get
                    LIMIT 1";
            $team_sql = f_igosja_mysqli_query($sql);

            $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

            $sql = "UPDATE `team`
                    SET `team_finance`=`team_finance`-$price
                    WHERE `team_id`=$num_get
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_OUTCOME_SCOUT_STYLE,
                'finance_team_id' => $auth_team_id,
                'finance_value' => -$price,
                'finance_value_after' => $team_array[0]['team_finance'] - $price,
                'finance_value_before' => $team_array[0]['team_finance'],
            );
            f_igosja_finance($finance);
        }

        f_igosja_session_front_flash_set('success', 'Изучение успешно началось.');

        refresh();
    }
}

if ($cancel_get = (int) f_igosja_request_get('cancel'))
{
    $sql = "SELECT `name_name`,
                   `scout_style`,
                   `surname_name`
            FROM `scout`
            LEFT JOIN `player`
            ON `scout_player_id`=`player_id`
            LEFT JOIN `name`
            ON `player_name_id`=`name_id`
            LEFT JOIN `surname`
            ON `player_surname_id`=`surname_id`
            WHERE `scout_season_id`=$igosja_season_id
            AND `scout_ready`=0
            AND `scout_team_id`=$num_get
            AND `scout_id`=$cancel_get
            ORDER BY `scout_id` ASC";
    $cancel_sql = f_igosja_mysqli_query($sql);

    if (0 == $cancel_sql->num_rows)
    {
        f_igosja_session_front_flash_set('error', 'Игрок выбран неправильно.');

        refresh();
    }

    $cancel_array = $cancel_sql->fetch_all(MYSQLI_ASSOC);

    $cancel_price = $basescout_array[0]['basescout_my_style_price'];

    if (1 == f_igosja_request_get('ok'))
    {
        $sql = "SELECT `team_finance`
                FROM `team`
                WHERE `team_id`=$num_get
                LIMIT 1";
        $team_sql = f_igosja_mysqli_query($sql);

        $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

        $sql = "UPDATE `team`
                SET `team_finance`=`team_finance`+$cancel_price
                WHERE `team_id`=$num_get
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $finance = array(
            'finance_financetext_id' => FINANCETEXT_INCOME_SCOUT_STYLE,
            'finance_team_id' => $auth_team_id,
            'finance_value' => $cancel_price,
            'finance_value_after' => $team_array[0]['team_finance'] + $cancel_price,
            'finance_value_before' => $team_array[0]['team_finance'],
        );
        f_igosja_finance($finance);

        $sql = "DELETE FROM `scout`
                WHERE `scout_id`=$cancel_get
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        f_igosja_session_front_flash_set('success', 'Изменения успешно сохранены.');

        redirect('/scout.php');
    }
}

$sql = "SELECT `country_id`,
               `country_name`,
               `name_name`,
               `player_age`,
               `player_id`,
               `player_power_nominal`,
               `surname_name`,
               `scout_id`,
               `scout_percent`,
               `scout_style`
        FROM `scout`
        LEFT JOIN `player`
        ON `scout_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `country`
        ON `player_country_id`=`country_id`
        WHERE `scout_season_id`=$igosja_season_id
        AND `scout_ready`=0
        AND `scout_team_id`=$num_get
        ORDER BY `scout_id` ASC";
$scout_sql = f_igosja_mysqli_query($sql);

$scout_array = $scout_sql->fetch_all(MYSQLI_ASSOC);

$player_id = array();

foreach ($scout_array as $item)
{
    $player_id[] = $item['player_id'];
}

if (count($player_id))
{
    $player_id = implode(', ', $player_id);

    $sql = "SELECT `playerposition_player_id`,
                   `position_name`,
                   `position_short`
            FROM `playerposition`
            LEFT JOIN `position`
            ON `playerposition_position_id`=`position_id`
            WHERE `playerposition_player_id` IN ($player_id)";
    $playerposition_sql = f_igosja_mysqli_query($sql);

    $scoutplayerposition_array = $playerposition_sql->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT `playerspecial_level`,
                   `playerspecial_player_id`,
                   `special_name`,
                   `special_short`
            FROM `playerspecial`
            LEFT JOIN `special`
            ON `playerspecial_special_id`=`special_id`
            WHERE `playerspecial_player_id` IN ($player_id)
            ORDER BY `playerspecial_level` DESC, `playerspecial_special_id` ASC";
    $playerspecial_sql = f_igosja_mysqli_query($sql);

    $scoutplayerspecial_array = $playerspecial_sql->fetch_all(MYSQLI_ASSOC);
}
else
{
    $scoutplayerposition_array  = array();
    $scoutplayerspecial_array   = array();
}

$sql = "SELECT `count_scout`,
               `country_id`,
               `country_name`,
               `line_color`,
               `name_name`,
               `player_age`,
               `player_id`,
               `player_power_nominal`,
               `player_style_id`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `country`
        ON `player_country_id`=`country_id`
        LEFT JOIN
        (
            SELECT COUNT(`scout_id`) AS `count_scout`,
                   `scout_player_id`
            FROM `scout`
            WHERE `scout_team_id`=$auth_team_id
            AND `scout_ready`=1
            GROUP BY `scout_player_id`
        ) AS `t1`
        ON `player_id`=`scout_player_id`
        LEFT JOIN `line`
        ON `player_line_id`=`line_id`
        WHERE `player_team_id`=$num_get
        ORDER BY `player_order` ASC, `player_position_id` ASC, `player_id` ASC";
$player_sql = f_igosja_mysqli_query($sql);

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$player_id = array();

foreach ($player_array as $item)
{
    $player_id[] = $item['player_id'];
}

if (count($player_id))
{
    $player_id = implode(', ', $player_id);

    $sql = "SELECT `playerposition_player_id`,
                   `position_name`,
                   `position_short`
            FROM `playerposition`
            LEFT JOIN `position`
            ON `playerposition_position_id`=`position_id`
            WHERE `playerposition_player_id` IN ($player_id)";
    $playerposition_sql = f_igosja_mysqli_query($sql);

    $playerposition_array = $playerposition_sql->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT `playerspecial_level`,
                   `playerspecial_player_id`,
                   `special_name`,
                   `special_short`
            FROM `playerspecial`
            LEFT JOIN `special`
            ON `playerspecial_special_id`=`special_id`
            WHERE `playerspecial_player_id` IN ($player_id)
            ORDER BY `playerspecial_level` DESC, `playerspecial_special_id` ASC";
    $playerspecial_sql = f_igosja_mysqli_query($sql);

    $playerspecial_array = $playerspecial_sql->fetch_all(MYSQLI_ASSOC);
}
else
{
    $playerposition_array   = array();
    $playerspecial_array    = array();
}

$seo_title          = $team_array[0]['team_name'] . '. Скаут центр';
$seo_description    = $team_array[0]['team_name'] . '. Скаут центр на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $team_array[0]['team_name'] . ' скаут центр';

include(__DIR__ . '/view/layout/main.php');