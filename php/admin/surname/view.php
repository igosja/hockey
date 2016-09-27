<?php

$sql = "SELECT `surname_id`,
               `surname_name`
        FROM `surname`
        WHERE `surname_id`='$num_get'
        LIMIT 1";
$surname_sql = igosja_db_query($sql);
$surname_array = $surname_sql->fetch_all(1);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `surnamecountry`
        LEFT JOIN `country`
        ON `surnamecountry_country_id`=`country_id`
        WHERE `surnamecountry_surname_id`='$num_get'";
$country_sql = igosja_db_query($sql);
$country_array = $country_sql->fetch_all(1);