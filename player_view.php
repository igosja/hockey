<?php

include (__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `country_id`,
               `country_name`,
               `name_name`,
               `phisical_id`,
               `phisical_value`,
               `player_age`,
               `player_game_row`,
               `player_id`,
               `player_power_nominal`,
               `player_power_real`,
               `player_price`,
               `player_salary`,
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
        LEFT JOIN `country`
        ON `player_country_id`=`country_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        WHERE `player_id`='$num_get'
        LIMIT 1";
$player_sql = f_igosja_mysqli_query($sql);

if (0 == $player_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$player_array = $player_sql->fetch_all(1);

$sql = "SELECT `game_id`,
               `game_home_score`,
               `game_guest_score`,
               `guest_team`.`team_id` AS `guest_team_id`,
               `guest_team`.`team_name` AS `guest_team_name`,
               `home_team`.`team_id` AS `home_team_id`,
               `home_team`.`team_name` AS `home_team_name`,
               `lineup_assist`,
               `lineup_power_real`,
               `lineup_score`,
               `position_name`,
               `shedule_date`,
               `stage_name`,
               `tournamenttype_name`
        FROM `lineup`
        LEFT JOIN `game`
        ON `lineup_game_id`=`game_id`
        LEFT JOIN `shedule`
        ON `game_shedule_id`=`shedule_id`
        LEFT JOIN `tournamenttype`
        ON `shedule_tournamenttype_id`=`tournamenttype_id`
        LEFT JOIN `stage`
        ON `shedule_stage_id`=`stage_id`
        LEFT JOIN `position`
        ON `lineup_position_id`=`position_id`
        LEFT JOIN `team` AS `home_team`
        ON `game_home_team_id`=`home_team`.`team_id`
        LEFT JOIN `team` AS `guest_team`
        ON `game_guest_team_id`=`guest_team`.`team_id`
        WHERE `lineup_player_id`='$num_get'
        AND `game_played`='1'
        ORDER BY `shedule_id` DESC";
$game_sql = f_igosja_mysqli_query($sql);

$game_array = $game_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');