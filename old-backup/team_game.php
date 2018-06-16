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

$sql = "SELECT `city_name`,
               `country_name`,
               `game_home_team_id`,
               IF(`game_guest_team_id`=$num_get, `game_guest_auto`, `game_home_auto`) AS `game_auto`,
               IF(`game_guest_team_id`=$num_get, `game_home_score`, `game_guest_score`) AS `game_guest_score`,
               IF(`game_guest_team_id`=$num_get, `game_guest_score`, `game_home_score`) AS `game_home_score`,
               `game_id`,
               `game_played`,
               IF(`game_guest_team_id`=$num_get, `game_guest_plus_minus`, `game_home_plus_minus`) AS `game_plus_minus`,
               IF(
                   `game_played`=1,
                   ROUND(`opponent`.`team_power_vs`/`my_team`.`team_power_vs`*100),
                   IF(
                       `game_guest_team_id`=$num_get,
                       ROUND(`game_home_power`/`game_guest_power`*100),
                       ROUND(`game_guest_power`/`game_home_power`*100)
                   )
               ) AS `power_percent`,
               `schedule_date`,
               `stage_name`,
               `opponent`.`team_id` AS `team_id`,
               `opponent`.`team_name` AS `team_name`,
               `tournamenttype_name`
        FROM `game`
        LEFT JOIN `schedule`
        ON `game_schedule_id`=`schedule_id`
        LEFT JOIN `tournamenttype`
        ON `schedule_tournamenttype_id`=`tournamenttype_id`
        LEFT JOIN `stage`
        ON `schedule_stage_id`=`stage_id`
        LEFT JOIN `team` AS `opponent`
        ON IF(`game_guest_team_id`=$num_get, `game_home_team_id`, `game_guest_team_id`)=`opponent`.`team_id`
        LEFT JOIN `team` AS `my_team`
        ON IF(`game_guest_team_id`=$num_get, `game_guest_team_id`, `game_home_team_id`)=`my_team`.`team_id`
        LEFT JOIN `stadium`
        ON `opponent`.`team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE (`game_guest_team_id`=$num_get
        OR `game_home_team_id`=$num_get)
        AND `schedule_season_id`=$season_id
        ORDER BY `schedule_id` ASC";
$game_sql = f_igosja_mysqli_query($sql);

$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = $team_array[0]['team_name'] . '. Матчи команды';
$seo_description    = $team_array[0]['team_name'] . '. Матчи команды на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $team_array[0]['team_name'] . ' матчи команды';

include(__DIR__ . '/view/layout/main.php');