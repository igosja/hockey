<?php

include (__DIR__ . '/include/include.php');

$sql = "SELECT `country_id`,
               `country_name`
        FROM `championship`
        LEFT JOIN `country`
        ON `championship_country_id`=`country_id`
        WHERE `championship_season_id`='$igosja_season_id'
        GROUP BY `country_id`
        ORDER BY `country_id` ASC";
$country_sql = igosja_db_query($sql);

$country_array = $country_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');