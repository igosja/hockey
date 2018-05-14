<?php

/**
 * @var $auth_country_id integer
 * @var $auth_national_id integer
 * @var $auth_nationalvice_id integer
 * @var $auth_team_id integer
 * @var $auth_user_id integer
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    if (!isset($auth_national_id))
    {
        redirect('/wrong_page.php');
    }

    if (0 == $auth_national_id && 0 == $auth_nationalvice_id)
    {
        redirect('/wrong_page.php');
    }

    if (!$num_get = $auth_national_id)
    {
        $num_get = $auth_nationalvice_id;
    }
}

include(__DIR__ . '/include/sql/national_view_left.php');
include(__DIR__ . '/include/sql/national_view_right.php');

$sql = "SELECT `city_name`,
               `country_name`,
               `name_name`,
               `phisical_id`,
               `phisical_name`,
               `player_age`,
               `player_game_row`,
               `player_id`,
               `player_power_nominal`,
               `player_power_old`,
               `player_power_real`,
               `player_price`,
               `player_tire`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `player`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `phisical`
        ON `player_phisical_id`=`phisical_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `player_national_id`=$num_get
        ORDER BY `player_position_id` ASC";
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

$notification_array = array();

if (isset($auth_national_id) && $auth_national_id == $num_get)
{
    $sql = "SELECT `game_guest_mood_id`,
                   `game_guest_national_id`,
                   `game_home_mood_id`,
                   `game_home_national_id`,
                   `game_id`
            FROM `game`
            LEFT JOIN `schedule`
            ON `game_schedule_id`=`schedule_id`
            WHERE (`game_home_national_id`=$num_get
            OR `game_guest_national_id`=$num_get)
            AND `game_played`=0
            ORDER BY `schedule_id` ASC
            LIMIT 1";
    $check_game_send_sql = f_igosja_mysqli_query($sql);

    if ($check_game_send_sql->num_rows)
    {
        $check_game_send_array = $check_game_send_sql->fetch_all(MYSQLI_ASSOC);

        if (($num_get == $check_game_send_array[0]['game_guest_national_id'] && 0 == $check_game_send_array[0]['game_guest_mood_id']) ||
            ($num_get == $check_game_send_array[0]['game_home_national_id'] && 0 == $check_game_send_array[0]['game_home_mood_id']))
        {
            $notification_array[] = 'Вы не отправили состав на ближайший <a href="/game_send_national.php?num=' . $check_game_send_array[0]['game_id'] . '">матч</a> своей команды.';
        }
    }

    $sql = "SELECT `game_guest_mood_id`,
                   `game_guest_national_id`,
                   `game_home_mood_id`,
                   `game_home_national_id`,
                   `game_id`
            FROM `game`
            LEFT JOIN `schedule`
            ON `game_schedule_id`=`schedule_id`
            WHERE (`game_home_national_id`=$num_get
            OR `game_guest_national_id`=$num_get)
            AND `game_played`=0
            ORDER BY `schedule_id` ASC
            LIMIT 1";
    $check_mood_sql = f_igosja_mysqli_query($sql);

    if ($check_mood_sql->num_rows)
    {
        $check_mood_array = $check_mood_sql->fetch_all(MYSQLI_ASSOC);

        if (($num_get == $check_mood_array[0]['game_guest_national_id'] && MOOD_SUPER == $check_mood_array[0]['game_guest_mood_id']) ||
            ($num_get == $check_mood_array[0]['game_home_national_id'] && MOOD_SUPER == $check_mood_array[0]['game_home_mood_id']))
        {
            $notification_array[] = 'В ближайшем <a href="/game_send.php?num=' . $check_mood_array[0]['game_id'] . '">матче</a> ваша команда будет использовать супер.';
        }
        elseif (($num_get == $check_mood_array[0]['game_guest_national_id'] && MOOD_REST == $check_mood_array[0]['game_guest_mood_id']) ||
            ($num_get == $check_mood_array[0]['game_home_national_id'] && MOOD_REST == $check_mood_array[0]['game_home_mood_id']))
        {
            $notification_array[] = 'В ближайшем <a href="/game_send.php?num=' . $check_mood_array[0]['game_id'] . '">матче</a> ваша команда будет использовать отдых.';
        }
    }
}

if (isset($auth_country_id) && $auth_country_id == $national_array[0]['country_id'])
{
    if ($data = f_igosja_request_post('data'))
    {
        if (isset($data['vote_national']))
        {
            $vote = (int) $data['vote_national'];

            $sql = "SELECT COUNT(`relation_id`) AS `check`
                    FROM `relation`
                    WHERE `relation_id`=$vote";
            $check_sql = f_igosja_mysqli_query($sql);

            $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

            if (0 == $check_array[0]['check'])
            {
                f_igosja_session_front_flash_set('error', 'Отношение к тренеру выбрано неправильно.');

                refresh();
            }

            $sql = "UPDATE `team`
                    SET `team_vote_national`=$vote
                    WHERE `team_id`=$auth_team_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            f_igosja_session_front_flash_set('success', 'Отношение к тренеру успешно сохранено.');

            refresh();
        }
    }

    $sql = "SELECT `relation_id`,
                   `relation_name`
            FROM `team`
            LEFT JOIN `relation`
            ON `team_vote_national`=`relation_id`
            WHERE `team_id`=$auth_team_id
            LIMIT 1";
    $relation_sql = f_igosja_mysqli_query($sql);

    $relation_array = $relation_sql->fetch_all(MYSQLI_ASSOC);

    $auth_relation_id   = $relation_array[0]['relation_id'];
    $auth_relation_name = $relation_array[0]['relation_name'];

    $sql = "SELECT `relation_id`,
                   `relation_name`
            FROM `relation`
            ORDER BY `relation_order` ASC";
    $relation_sql = f_igosja_mysqli_query($sql);

    $relation_array = $relation_sql->fetch_all(MYSQLI_ASSOC);
}

$seo_title          = $national_array[0]['country_name'] . '. Профиль сборной';
$seo_description    = $national_array[0]['country_name'] . '. Профиль сборной на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $national_array[0]['country_name'] . ' профиль сборной';

include(__DIR__ . '/view/layout/main.php');