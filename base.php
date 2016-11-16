<?php

include (__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_get('num'))
{
    redirect('/wrong_page.php');
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

$sql = "SELECT `base_level`,
               `base_slot_max`,
               `base_slot_min`,
               `basemedical_level`,
               `basemedical_tire`,
               `basephisical_change_count`,
               `basephisical_level`,
               `basephisical_tire_bobus`,
               `baseschool_level`,
               `baseschool_player_count`,
               `basescout_level`,
               `basescout_my_style_count`,
               `basetraining_level`,
               `basetraining_position_count`,
               `basetraining_power_count`,
               `basetraining_special_count`,
               `basetraining_training_speed_max`,
               `basetraining_training_speed_min`
        FROM `team`
        LEFT JOIN `base`
        ON `team_base_id`=`base_id`
        LEFT JOIN `basemedical`
        ON `team_basemedical_id`=`basemedical_id`
        LEFT JOIN `basephisical`
        ON `team_basephisical_id`=`basephisical_id`
        LEFT JOIN `baseschool`
        ON `team_baseschool_id`=`baseschool_id`
        LEFT JOIN `basescout`
        ON `team_basescout_id`=`basescout_id`
        LEFT JOIN `basetraining`
        ON `team_basetraining_id`=`basetraining_id`
        WHERE `team_id`='$num_get'";
$base_sql = igosja_db_query($sql);

$base_array = $base_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');