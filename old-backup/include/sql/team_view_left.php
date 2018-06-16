<?php

/**
 * @var $igosja_season_id integer
 * @var $num_get integer
 */

$sql = "SELECT `base_level`,
               `base_slot_max`,
               `basemedical_level`+
               `basephisical_level`+
               `baseschool_level`+
               `basescout_level`+
               `basetraining_level` AS `base_slot_used`,
               `championship_place`,
               `city_name`,
               `conference_place`,
               `count_buildingbase`,
               `count_buildingstadium`,
               `country_id`,
               `country_name`,
               `division_id`,
               `division_name`,
               `stadium_capacity`,
               `stadium_name`,
               `team_finance`,
               `team_name`,
               `coach`.`user_date_vip` AS `user_date_vip`,
               `coach`.`user_id` AS `user_id`,
               `coach`.`user_login` AS `user_login`,
               `coach`.`user_name` AS `user_name`,
               `coach`.`user_surname` AS `user_surname`,
               `vice`.`user_date_vip` AS `vice_user_date_vip`,
               `vice`.`user_id` AS `vice_user_id`,
               `vice`.`user_login` AS `vice_user_login`,
               `vice`.`user_name` AS `vice_user_name`,
               `vice`.`user_surname` AS `vice_user_surname`
        FROM `team`
        LEFT JOIN `user` AS `coach`
        ON `team_user_id`=`coach`.`user_id`
        LEFT JOIN `user` AS `vice`
        ON `team_vice_id`=`vice`.`user_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
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
        LEFT JOIN
        (
            SELECT `championship_place`,
                   `championship_team_id`,
                   `division_id`,
                   `division_name`
            FROM `championship`
            LEFT JOIN `division`
            ON `championship_division_id`=`division_id`
            WHERE `championship_team_id`=$num_get
            AND `championship_season_id`=$igosja_season_id
        ) AS `t1`
        ON `team_id`=`championship_team_id`
        LEFT JOIN
        (
            SELECT `conference_place`,
                   `conference_team_id`
            FROM `conference`
            WHERE `conference_team_id`=$num_get
            AND `conference_season_id`=$igosja_season_id
        ) AS `t2`
        ON `team_id`=`conference_team_id`
        LEFT JOIN
        (
            SELECT `buildingbase_team_id`,
                   COUNT(`buildingbase_id`) AS `count_buildingbase`
            FROM `buildingbase`
            WHERE `buildingbase_team_id`=$num_get
            AND `buildingbase_ready`=0
        ) AS `t3`
        ON `team_id`=`buildingbase_team_id`
        LEFT JOIN
        (
            SELECT `buildingstadium_team_id`,
                   COUNT(`buildingstadium_id`) AS `count_buildingstadium`
            FROM `buildingstadium`
            WHERE `buildingstadium_team_id`=$num_get
            AND `buildingstadium_ready`=0
        ) AS `t4`
        ON `team_id`=`buildingstadium_team_id`
        WHERE `team_id`=$num_get
        LIMIT 1";
$team_sql = f_igosja_mysqli_query($sql);

if (0 == $team_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);