<?php

include (__DIR__ . '/include/include.php');

if (!isset($auth_team_id))
{
    redirect('/wrong_page.php');
}

$num_get = $auth_team_id;

include (__DIR__ . '/include/sql/team_view_left.php');

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

$basescout_array = $basescout_sql->fetch_all(1);

if ($data = f_igosja_request_post('data'))
{
    $confirm_data = array(
        'style' => array(),
        'price' => 0,
        'error' => '',
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
                        AND `scout_ready`=0";
                $check_sql = f_igosja_mysqli_query($sql);

                $check_array = $check_sql->fetch_all(1);
                $count_check = $check_array[0]['count'];

                if (0 == $count_check)
                {
                    $player_array = $player_sql->fetch_all(1);

                    $confirm_data['style'][] = array(
                        'id' => $item,
                        'name' => $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'],
                    );

                    $confirm_data['price'] = $confirm_data['price'] + $basescout_array[0]['basescout_my_style_price'];
                }
            }
        }
    }

    if (count($confirm_data['style']) > $basescout_array[0]['basescout_my_style_count'])
    {
        $confirm_data['error'] = 'У вас недостаточно стилей для изучения';
    }
    elseif ($confirm_data['price'] > $basescout_array[0]['team_finance'])
    {
        $confirm_data['error'] = 'У вас недостаточно денег для изучения';
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

            $team_array = $team_sql->fetch_all(1);

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

        $_SESSION['message']['class']   = 'success';
        $_SESSION['message']['text']    = 'Изучение успешно началось.';

        refresh();
    }
}

$sql = "SELECT `country_id`,
               `country_name`,
               `name_name`,
               `player_age`,
               `player_id`,
               `player_power_nominal`,
               `surname_name`,
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

$scout_array = $scout_sql->fetch_all(1);

$sql = "SELECT `country_id`,
               `country_name`,
               `name_name`,
               `player_age`,
               `player_id`,
               `player_power_nominal`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `country`
        ON `player_country_id`=`country_id`
        WHERE `player_team_id`=$num_get
        ORDER BY `player_id` ASC";
$player_sql = f_igosja_mysqli_query($sql);

$player_array = $player_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');