<?php

include(__DIR__ . '/../../include/pagination_offset.php');

$sql = "SELECT `country_id`,
               `country_name`
        FROM `stadium`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        GROUP BY `city_country_id`
        ORDER BY `country_name`";
$country_sql = igosja_db_query($sql);

$country_array = $country_sql->fetch_all(1);

$sql = "SELECT `city_id`,
               `city_name`
        FROM `stadium`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        GROUP BY `stadium_city_id`
        ORDER BY `city_name`";
$city_sql = igosja_db_query($sql);

$city_array = $city_sql->fetch_all(1);

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `city_id`,
               `city_name`,
               `country_id`,
               `country_name`,
               `stadium_id`,
               `stadium_name`
        FROM `stadium`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE $sql_filter
        ORDER BY `stadium_id`
        LIMIT $offset, $limit";
$stadium_sql = igosja_db_query($sql);

$stadium_array = $stadium_sql->fetch_all(1);

$breadcrumb_array[] = 'Стадионы';

include(__DIR__ . '/../../include/pagination_count.php');