<?php

include (__DIR__ . '/include/include.php');

if (!$country_id = (int) f_igosja_request_get('country_id'))
{
    redirect('/wrong_page.php');
}

if (!$division_id = (int) f_igosja_request_get('division_id'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `country_name`,
               `division_name`
        FROM `championship`
        LEFT JOIN `country`
        ON `championship_country_id`=`country_id`
        LEFT JOIN `division`
        ON `championship_division_id`=`division_id`
        WHERE `championship_season_id`=$igosja_season_id
        AND `championship_country_id`=$country_id
        AND `championship_division_id`=$division_id
        LIMIT 1";
$country_sql = f_igosja_mysqli_query($sql);

if (0 == $country_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$country_array = $country_sql->fetch_all(1);

$sql = "SELECT `shedule_id`
        FROM `shedule`
        WHERE `shedule_date`<=UNIX_TIMESTAMP()
        AND `shedule_tournamenttype_id`=" . TOURNAMENTTYPE_CHAMPIONSHIP . "
        AND `shedule_season_id`=$igosja_season_id
        ORDER BY `shedule_id` DESC
        LIMIT 1";
$shedule_sql = f_igosja_mysqli_query($sql);

if (0 == $shedule_sql->num_rows)
{
    $sql = "SELECT `shedule_id`
            FROM `shedule`
            WHERE `shedule_date`>UNIX_TIMESTAMP()
            AND `shedule_tournamenttype_id`=" . TOURNAMENTTYPE_CHAMPIONSHIP . "
            AND `shedule_season_id`=$igosja_season_id
            ORDER BY `shedule_id` ASC
            LIMIT 1";
    $shedule_sql = f_igosja_mysqli_query($sql);
}

$shedule_array = $shedule_sql->fetch_all(1);

$shedule_id = $shedule_array[0]['shedule_id'];

$sql = "SELECT `game_id`,
               `game_guest_score`,
               `game_home_score`,
               `game_played`,
               `guest_team`.`team_id` AS `guest_team_id`,
               `guest_team`.`team_name` AS `guest_team_name`,
               `guest_city`.`city_name` AS `guest_city_name`,
               `home_team`.`team_id` AS `home_team_id`,
               `home_team`.`team_name` AS `home_team_name`,
               `home_city`.`city_name` AS `home_city_name`
        FROM `game`
        LEFT JOIN `team` AS `guest_team`
        ON `game_guest_team_id`=`guest_team`.`team_id`
        LEFT JOIN `stadium` AS `guest_stadium`
        ON `guest_team`.`team_stadium_id`=`guest_stadium`.`stadium_id`
        LEFT JOIN `city` AS `guest_city`
        ON `guest_stadium`.`stadium_city_id`=`guest_city`.`city_id`
        LEFT JOIN `team` AS `home_team`
        ON `game_home_team_id`=`home_team`.`team_id`
        LEFT JOIN `stadium` AS `home_stadium`
        ON `home_team`.`team_stadium_id`=`home_stadium`.`stadium_id`
        LEFT JOIN `city` AS `home_city`
        ON `home_stadium`.`stadium_city_id`=`home_city`.`city_id`
        LEFT JOIN `championship`
        ON `game_guest_team_id`=`championship_team_id`
        WHERE `game_shedule_id`=$shedule_id
        AND `championship_season_id`=$igosja_season_id
        AND `championship_country_id`=$country_id
        AND `championship_division_id`=$division_id
        ORDER BY `game_id` ASC";
$game_sql = f_igosja_mysqli_query($sql);

$game_array = $game_sql->fetch_all(1);

$sql = "SELECT `city_name`,
               `championship_game`,
               `championship_loose`,
               `championship_loose_over`,
               `championship_pass`,
               `championship_place`,
               `championship_point`,
               `championship_score`,
               `championship_win`,
               `championship_win_over`,
               `team_id`,
               `team_name`
        FROM `championship`
        LEFT JOIN `team`
        ON `championship_team_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        WHERE `championship_season_id`=$igosja_season_id
        AND `championship_country_id`=$country_id
        AND `championship_division_id`=$division_id
        ORDER BY `championship_place` ASC";
$team_sql = f_igosja_mysqli_query($sql);

$team_array = $team_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');