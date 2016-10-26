<?php

include (__DIR__ . '/include/include.php');

$sql = "SELECT `country_id`,
               `country_name`
        FROM `tournament`
        LEFT JOIN `country`
        ON `tournament_country_id`=`country_id`
        WHERE `tournament_tournamenttype_id`='" . TOURNAMENTTYPE_CHAMPIONSHIP . "'
        ORDER BY `country_id` ASC";
$country_sql = igosja_db_query($sql);

$country_array = $country_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');