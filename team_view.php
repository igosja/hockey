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
        WHERE `team_id`='$num_get'";
$team_sql = igosja_db_query($sql);

$team_array = $team_sql->fetch_all(1);

$sql = "SELECT `country_id`,
               `country_name`,
               `name_name`,
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
        WHERE `player_team_id`='$num_get'";
$player_sql = igosja_db_query($sql);

$player_array = $player_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');