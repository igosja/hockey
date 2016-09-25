<?php

$sql = "SELECT `city_id`,
               `city_name`,
               `country_id`,
               `country_name`
        FROM `city`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `city_id`='$num_get'
        LIMIT 1";
$city_sql = igosja_db_query($sql);
$city_array = $city_sql->fetch_all(1);