<?php

include (__DIR__ . '/include/include.php');

$sql = "SELECT `city_name`,
               `name_name`,
               `pl_country`.`country_id` AS `pl_country_id`,
               `pl_country`.`country_name` AS `pl_country_name`,
               `player_age`,
               `player_id`,
               `player_power_nominal`,
               `surname_name`,
               `t_country`.`country_name` AS `t_country_name`,
               `team_id`,
               `team_name`,
               `transfer_price_buyer`
        FROM `transfer`
        LEFT JOIN `player`
        ON `transfer_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `country` AS `pl_country`
        ON `player_country_id`=`pl_country`.`country_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country` AS `t_country`
        ON `city_country_id`=`t_country`.`country_id`
        WHERE `transfer_ready`=0
        ORDER BY `transfer_id` ASC";
$transfer_sql = f_igosja_mysqli_query($sql);

$count_transfer = $transfer_sql->num_rows;
$transfer_array = $transfer_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');