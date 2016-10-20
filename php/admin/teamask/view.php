<?php

$sql = "SELECT `city_id`,
               `city_name`,
               `country_id`,
               `country_name`,
               `stadium_id`,
               `stadium_capacity`,
               `stadium_name`,
               `team_id`,
               `team_name`
        FROM `team`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `team_id`='$num_get'
        LIMIT 1";
$team_sql = igosja_db_query($sql);

$team_array = $team_sql->fetch_all(1);

$breadcrumb_array[] = array('url' => $route_path, 'text' => 'Команды');
$breadcrumb_array[] = $team_array[0]['team_name'];