<?php

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        WHERE `country_id`='$num_get'
        LIMIT 1";
$country_sql = igosja_db_query($sql);
$country_array = $country_sql->fetch_all(1);