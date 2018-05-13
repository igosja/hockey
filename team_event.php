<?php

/**
 * @var $auth_team_id integer
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    if (!isset($auth_team_id))
    {
        redirect('/wrong_page.php');
    }

    if (0 == $auth_team_id)
    {
        redirect('/team_ask.php');
    }

    $num_get = $auth_team_id;
}

include(__DIR__ . '/include/sql/team_view_left.php');
include(__DIR__ . '/include/sql/team_view_right.php');

if (!$season_id = (int) f_igosja_request_get('season_id'))
{
    $season_id = $igosja_season_id;
}

if ($season_id > $igosja_season_id)
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `season_id`
        FROM `season`
        ORDER BY `season_id` DESC";
$season_sql = f_igosja_mysqli_query($sql);

$season_array = $season_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `history_building_id`,
               `history_date`,
               `history_season_id`,
               `history_value`,
               `historytext_name`,
               `name_name`,
               `player_id`,
               `position_short`,
               `special_name`,
               `surname_name`,
               `history_team`.`team_id` AS `team_id`,
               `history_team`.`team_name` AS `team_name`,
               `history_team2`.`team_id` AS `team2_id`,
               `history_team2`.`team_name` AS `team2_name`,
               `user_id`,
               `user_login`
        FROM `history`
        LEFT JOIN `historytext`
        ON `history_historytext_id`=`historytext_id`
        LEFT JOIN `team` AS `history_team`
        ON `history_team_id`=`history_team`.`team_id`
        LEFT JOIN `team` AS `history_team2`
        ON `history_team_2_id`=`history_team2`.`team_id`
        LEFT JOIN `user`
        ON `history_user_id`=`user_id`
        LEFT JOIN `special`
        ON `history_special_id`=`special_id`
        LEFT JOIN `position`
        ON `history_position_id`=`position_id`
        LEFT JOIN `player`
        ON `history_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        WHERE (`history_team_id`=$num_get
        OR `history_team_2_id`=$num_get)
        AND `history_season_id`=$season_id
        ORDER BY `history_id` DESC";
$event_sql = f_igosja_mysqli_query($sql);

$count_event = $event_sql->num_rows;
$event_array = $event_sql->fetch_all(MYSQLI_ASSOC);

for ($i=0; $i<$count_event; $i++)
{
    $event_array[$i]['historytext_name'] = f_igosja_event_text($event_array[$i]);
}

$seo_title          = $team_array[0]['team_name'] . '. События команды';
$seo_description    = $team_array[0]['team_name'] . '. События команды на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $team_array[0]['team_name'] . ' события команды';

include(__DIR__ . '/view/layout/main.php');