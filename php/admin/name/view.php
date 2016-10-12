<?php

$sql = "SELECT `name_id`,
               `name_name`
        FROM `name`
        WHERE `name_id`='$num_get'
        LIMIT 1";
$name_sql = igosja_db_query($sql);

$name_array = $name_sql->fetch_all(1);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `namecountry`
        LEFT JOIN `country`
        ON `namecountry_country_id`=`country_id`
        WHERE `namecountry_name_id`='$num_get'";
$country_sql = igosja_db_query($sql);

$country_array = $country_sql->fetch_all(1);

$breadcrumb_array[] = array('url' => $route_path, 'text' => 'Имена');
$breadcrumb_array[] = $name_array[0]['name_name'];