<?php

/**
 * @var $auth_team_id integer
 * @var $auth_user_id integer
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

$sql = "SELECT `user_shop_position`,
               `user_shop_special`,
               `user_shop_training`
        FROM `user`
        WHERE `user_id`=$auth_user_id
        LIMIT 1";
$user_sql = f_igosja_mysqli_query($sql);

$user_array = $user_sql->fetch_all(1);

if ($data = f_igosja_request_post('data'))
{
    $confirm_data = array(
        'power' => array(),
        'position' => array(),
        'special' => array(),
    );

    $player_id_array = array();

    if (isset($data['power']))
    {
        foreach ($data['power'] as $item)
        {
            $player_id = (int) $item;

            $player_id_array[] = $player_id;

            $sql = "SELECT `name_name`,
                           `surname_name`
                    FROM `player`
                    LEFT JOIN `name`
                    ON `player_name_id`=`name_id`
                    LEFT JOIN `surname`
                    ON `player_surname_id`=`surname_id`
                    WHERE `player_id`=$player_id
                    AND `player_noaction`<UNIX_TIMESTAMP()
                    AND `player_team_id`=$num_get
                    LIMIT 1";
            $player_sql = f_igosja_mysqli_query($sql);

            if ($player_sql->num_rows)
            {
                $sql = "SELECT COUNT(`training_id`) AS `count`
                        FROM `training`
                        WHERE `training_player_id`=$player_id
                        AND `training_ready`=0";
                $check_sql = f_igosja_mysqli_query($sql);

                $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);
                $count_check = $check_array[0]['count'];

                if (0 == $count_check)
                {
                    $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

                    $confirm_data['power'][] = array(
                        'id' => $item,
                        'name' => $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'],
                    );
                }
                else
                {
                    f_igosja_session_front_flash_set('error', 'Одному игроку нельзя назначить несколько тренировок одновременно.');

                    refresh();
                }
            }
        }
    }

    if (isset($data['position']))
    {
        foreach ($data['position'] as $item)
        {
            if ($item)
            {
                $item_array = explode(':', $item);
                $player_id  = (int) $item_array[0];

                $player_id_array[] = $player_id;

                $sql = "SELECT `name_name`,
                               `surname_name`
                        FROM `player`
                        LEFT JOIN `name`
                        ON `player_name_id`=`name_id`
                        LEFT JOIN `surname`
                        ON `player_surname_id`=`surname_id`
                        WHERE `player_id`=$player_id
                        AND `player_noaction`<UNIX_TIMESTAMP()
                        AND `player_team_id`=$num_get
                        LIMIT 1";
                $player_sql = f_igosja_mysqli_query($sql);

                if ($player_sql->num_rows)
                {
                    $sql = "SELECT COUNT(`training_id`) AS `count`
                            FROM `training`
                            WHERE `training_player_id`=$player_id
                            AND `training_ready`=0";
                    $check_sql = f_igosja_mysqli_query($sql);

                    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

                    if (0 == $check_array[0]['count'])
                    {
                        $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

                        $position_id = (int) $item_array[1];

                        $sql = "SELECT `position_short`
                                FROM `position`
                                WHERE `position_id`=$position_id
                                LIMIT 1";
                        $position_sql = f_igosja_mysqli_query($sql);

                        $position_array = $position_sql->fetch_all(MYSQLI_ASSOC);

                        $confirm_data['position'][] = array(
                            'id' => $player_id,
                            'name' => $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'],
                            'position' => array(
                                'id' => $position_id,
                                'name' => $position_array[0]['position_short'],
                            ),
                        );
                    }
                    else
                    {
                        f_igosja_session_front_flash_set('error', 'Одному игроку нельзя назначить несколько тренировок одновременно.');

                        refresh();
                    }
                }
            }
        }
    }

    if (isset($data['special']))
    {
        foreach ($data['special'] as $item)
        {
            if ($item)
            {
                $item_array = explode(':', $item);
                $player_id  = (int) $item_array[0];

                $player_id_array[] = $player_id;

                $sql = "SELECT `name_name`,
                               `surname_name`
                        FROM `player`
                        LEFT JOIN `name`
                        ON `player_name_id`=`name_id`
                        LEFT JOIN `surname`
                        ON `player_surname_id`=`surname_id`
                        WHERE `player_id`=$player_id
                        AND `player_noaction`<UNIX_TIMESTAMP()
                        AND `player_team_id`=$num_get
                        LIMIT 1";
                $player_sql = f_igosja_mysqli_query($sql);

                if ($player_sql->num_rows)
                {
                    $sql = "SELECT COUNT(`training_id`) AS `count`
                            FROM `training`
                            WHERE `training_player_id`=$player_id
                            AND `training_ready`=0";
                    $check_sql = f_igosja_mysqli_query($sql);

                    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

                    if (0 == $check_array[0]['count'])
                    {
                        $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

                        $special_id = (int) $item_array[1];

                        $sql = "SELECT `special_name`
                                FROM `special`
                                WHERE `special_id`=$special_id
                                LIMIT 1";
                        $special_sql = f_igosja_mysqli_query($sql);

                        $special_array = $special_sql->fetch_all(MYSQLI_ASSOC);

                        $confirm_data['special'][] = array(
                            'id' => $player_id,
                            'name' => $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'],
                            'special' => array(
                                'id' => $special_id,
                                'name' => $special_array[0]['special_name'],
                            ),
                        );
                    }
                    else
                    {
                        f_igosja_session_front_flash_set('error', 'Одному игроку нельзя назначить несколько тренировок одновременно.');

                        refresh();
                    }
                }
            }
        }
    }

    if (count($confirm_data['power']) > $user_array[0]['user_shop_training'])
    {
        f_igosja_session_front_flash_set('error', 'У вас недостаточно баллов для тренировки.');

        refresh();
    }
    elseif (count($confirm_data['position']) > $user_array[0]['user_shop_position'])
    {
        f_igosja_session_front_flash_set('error', 'У вас недостаточно совмещений для тренировки.');

        refresh();
    }
    elseif (count($confirm_data['special']) > $user_array[0]['user_shop_special'])
    {
        f_igosja_session_front_flash_set('error', 'У вас недостаточно спецвозможностей для тренировки.');

        refresh();
    }
    elseif (count($player_id_array) != count(array_unique($player_id_array)))
    {
        f_igosja_session_front_flash_set('error', 'Одному игроку нельзя назначить несколько тренировок одновременно.');

        refresh();
    }

    if (isset($data['ok']))
    {
        foreach($confirm_data['power'] as $item)
        {
            $player_id = $item['id'];

            $sql = "UPDATE `player`
                    SET `player_power_nominal`=`player_power_nominal`+1
                    WHERE `player_id`=$player_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $log = array(
                'history_historytext_id' => HISTORYTEXT_PLAYER_BONUS_POINT,
                'history_player_id' => $player_id,
            );
            f_igosja_history($log);

            $sql = "UPDATE `user`
                    SET `user_shop_training`=`user_shop_training`-1
                    WHERE `user_id`=$auth_user_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }

        foreach($confirm_data['position'] as $item)
        {
            $player_id      = $item['id'];
            $position_id    = $item['position']['id'];

            $sql = "INSERT INTO `playerposition`
                    SET `playerposition_player_id`=$player_id,
                        `playerposition_position_id`=$position_id";
            f_igosja_mysqli_query($sql);

            $log = array(
                'history_historytext_id' => HISTORYTEXT_PLAYER_BONUS_POSITION,
                'history_player_id' => $player_id,
                'history_position_id' => $position_id,
            );
            f_igosja_history($log);

            $sql = "UPDATE `user`
                    SET `user_shop_position`=`user_shop_position`-1
                    WHERE `user_id`=$auth_user_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }

        foreach($confirm_data['special'] as $item)
        {
            $player_id  = $item['id'];
            $special_id = $item['special']['id'];

            $sql = "SELECT COUNT(`playerspecial_special_id`) AS `count`
                    FROM `playerspecial`
                    WHERE `playerspecial_player_id`=$player_id
                    AND `playerspecial_special_id`=$special_id";
            $check_sql = f_igosja_mysqli_query($sql);

            $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

            if ($check_array[0]['count'])
            {
                $sql = "UPDATE `playerspecial`
                        SET `playerspecial_level`=`playerspecial_level`+1
                        WHERE `playerspecial_player_id`=$player_id
                        AND `playerspecial_special_id`=$special_id";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $sql = "INSERT INTO `playerspecial`
                        SET `playerspecial_player_id`=$player_id,
                            `playerspecial_special_id`=$special_id";
                f_igosja_mysqli_query($sql);
            }

            $log = array(
                'history_historytext_id' => HISTORYTEXT_PLAYER_BONUS_SPECIAL,
                'history_player_id' => $player_id,
                'history_special_id' => $special_id,
            );
            f_igosja_history($log);

            $sql = "UPDATE `user`
                    SET `user_shop_special`=`user_shop_special`-1
                    WHERE `user_id`=$auth_user_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }

        f_igosja_session_front_flash_set('success', 'Тренировка прошла успешно.');

        refresh();
    }
}

$sql = "SELECT `country_id`,
               `country_name`,
               `name_name`,
               `player_age`,
               `player_id`,
               `player_power_nominal`,
               `position_short`,
               `surname_name`,
               `special_name`,
               `training_percent`,
               `training_power`
        FROM `training`
        LEFT JOIN `player`
        ON `training_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `country`
        ON `player_country_id`=`country_id`
        LEFT JOIN `position`
        ON `training_position_id`=`position_id`
        LEFT JOIN `special`
        ON `training_special_id`=`special_id`
        WHERE `training_season_id`=$igosja_season_id
        AND `training_ready`=0
        AND `training_team_id`=$num_get
        ORDER BY `training_id` ASC";
$training_sql = f_igosja_mysqli_query($sql);

$count_training = $training_sql->num_rows;
$training_array = $training_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_id`,
               `country_name`,
               `line_color`,
               `name_name`,
               `player_age`,
               `player_id`,
               `player_noaction`,
               `player_power_nominal`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `country`
        ON `player_country_id`=`country_id`
        LEFT JOIN `line`
        ON `player_line_id`=`line_id`
        WHERE `player_team_id`=$num_get
        ORDER BY `player_position_id` ASC, `player_id` ASC";
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

$seo_title          = $team_array[0]['team_name'] . '. Тренировочный центр';
$seo_description    = $team_array[0]['team_name'] . '. Тренировочный центр на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $team_array[0]['team_name'] . ' тренировочный центр';

include(__DIR__ . '/view/layout/main.php');