<?php

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        WHERE `country_id`='$num_get'
        LIMIT 1";
$country_sql = igosja_db_query($sql);

$country_array = $country_sql->fetch_all(1);

$breadcrumb_array[] = array('url' => $route_path, 'text' => 'Страны');
$breadcrumb_array[] = $country_array[0]['country_name'];