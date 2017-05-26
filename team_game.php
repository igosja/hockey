<?php

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

$sql = "SELECT `city_name`,
               `country_name`,
               IF(`game_guest_team_id`=$num_get, `game_guest_auto`, `game_home_auto`) AS `game_auto`,
               `game_guest_score`,
               `game_home_score`,
               `game_id`,
               IF(`game_guest_team_id`=$num_get, `game_guest_minus`, `game_home_minus`) AS `game_minus`,
               `game_played`,
               IF(`game_guest_team_id`=$num_get, `game_guest_plus`, `game_home_plus`) AS `game_plus`,
               IF(
                   `game_played`=1,
                   ROUND(`opponent`.`team_power_vs`/`my_team`.`team_power_vs`*100),
                   IF(
                       `game_guest_team_id`=$num_get,
                       ROUND(`game_home_power`/`game_guest_power`*100),
                       ROUND(`game_guest_power`/`game_home_power`*100)
                   )
               ) AS `power_percent`,
               `shedule_date`,
               `stage_name`,
               `opponent`.`team_id` AS `team_id`,
               `opponent`.`team_name` AS `team_name`,
               `tournamenttype_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `game_shedule_id`=`shedule_id`
        LEFT JOIN `tournamenttype`
        ON `shedule_tournamenttype_id`=`tournamenttype_id`
        LEFT JOIN `stage`
        ON `shedule_stage_id`=`stage_id`
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
        AND `shedule_season_id`=$igosja_season_id
        ORDER BY `shedule_id` ASC";
$game_sql = f_igosja_mysqli_query($sql);

$game_array = $game_sql->fetch_all(1);

include(__DIR__ . '/view/layout/main.php');