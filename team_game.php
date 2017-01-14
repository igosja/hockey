<?php

include (__DIR__ . '/include/include.php');

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
        WHERE `team_id`=$num_get
        LIMIT 1";
$team_sql = f_igosja_mysqli_query($sql);

if (0 == $team_sql->num_rows)
{
    redirect('/wrong_page');
}

$team_array = $team_sql->fetch_all(1);

$sql = "SELECT `city_name`,
               `country_name`,
               IF(`game_guest_team_id`=$num_get, `game_guest_auto`, `game_home_auto`) AS `game_auto`,
               `game_guest_score`,
               `game_home_score`,
               `game_id`,
               `game_played`,
               `shedule_date`,
               `stage_name`,
               `team_id`,
               `team_name`,
               `tournamenttype_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `game_shedule_id`=`shedule_id`
        LEFT JOIN `tournamenttype`
        ON `shedule_tournamenttype_id`=`tournamenttype_id`
        LEFT JOIN `stage`
        ON `shedule_stage_id`=`stage_id`
        LEFT JOIN `team`
        ON IF(`game_guest_team_id`=$num_get, `game_home_team_id`, `game_guest_team_id`)=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
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

include (__DIR__ . '/view/layout/main.php');