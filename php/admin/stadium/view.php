<?php

$sql = "SELECT `city_id`,
               `city_name`,
               `country_id`,
               `country_name`,
               `stadium_id`,
               `stadium_capacity`,
               `stadium_name`
        FROM `stadium`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `stadium_id`='$num_get'
        LIMIT 1";
$stadium_sql = igosja_db_query($sql);

$stadium_array = $stadium_sql->fetch_all(1);

$breadcrumb_array[] = array('url' => $route_path, 'text' => 'Стадионы');
$breadcrumb_array[] = $stadium_array[0]['stadium_name'];