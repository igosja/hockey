<?php

include (__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_get('num'))
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

$sql = "SELECT `city_name`,
               `country_name`,
               `stadium_capacity`,
               `stadium_name`,
               `team_base_id`,
               `team_basemedical_id`+
               `team_basephisical_id`+
               `team_baseschool_id`+
               `team_basescout_id`+
               `team_basetraining_id` AS `team_base_slot_used`,
               `team_finance`,
               `team_name`,
               `user_login`,
               `user_name`,
               `user_surname`
        FROM `team`
        LEFT JOIN `user`
        ON `team_user_id`=`user_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `team_id`='$num_get'
        LIMIT 1";
$team_sql = igosja_db_query($sql);

if (0 == $team_sql->num_rows)
{
    redirect('/wrong_page');
}

$team_array = $team_sql->fetch_all(1);

$sql = "SELECT `game_id`,
               IF(`game_guest_team_id`='$num_get', `game_home_score`, `game_guest_score`) AS `guest_score`,
               IF(`game_guest_team_id`='$num_get', 'Г', 'Д') AS `home_guest`,
               IF(`game_guest_team_id`='$num_get', `game_guest_score`, `game_home_score`) AS `home_score`,
               `shedule_date`,
               `team_id`,
               `team_name`,
               `tournamenttype_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `game_shedule_id`=`shedule_id`
        LEFT JOIN `tournamenttype`
        ON `shedule_tournamenttype_id`=`tournamenttype_id`
        LEFT JOIN `team`
        ON IF(`game_guest_team_id`='$num_get', `game_home_team_id`, `game_guest_team_id`)=`team_id`
        WHERE (`game_guest_team_id`='$num_get'
        OR `game_home_team_id`='$num_get')
        AND `game_played`='1'
        ORDER BY `shedule_date` DESC
        LIMIT 3";
$latest_sql = igosja_db_query($sql);

$latest_array = $latest_sql->fetch_all(1);

$sql = "SELECT `game_id`,
               IF(`game_guest_team_id`='$num_get', 'Г', 'Д') AS `home_guest`,
               `shedule_date`,
               `team_id`,
               `team_name`,
               `tournamenttype_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `game_shedule_id`=`shedule_id`
        LEFT JOIN `tournamenttype`
        ON `shedule_tournamenttype_id`=`tournamenttype_id`
        LEFT JOIN `team`
        ON IF(`game_guest_team_id`='$num_get', `game_home_team_id`, `game_guest_team_id`)=`team_id`
        WHERE (`game_guest_team_id`='$num_get'
        OR `game_home_team_id`='$num_get')
        AND `game_played`='0'
        ORDER BY `shedule_date` ASC
        LIMIT 2";
$nearest_sql = igosja_db_query($sql);

$nearest_array = $nearest_sql->fetch_all(1);

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
               `player_tire`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `country`
        ON `player_country_id`=`country_id`
        LEFT JOIN `phisical`
        ON `player_phisical_id`=`phisical_id`
        WHERE `player_team_id`='$num_get'";
$player_sql = igosja_db_query($sql);

$player_array = $player_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');