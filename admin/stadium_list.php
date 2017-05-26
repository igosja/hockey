<?php

include(__DIR__ . '/../include/include.php');
include(__DIR__ . '/../include/pagination_offset.php');

$sql = "SELECT `country_id`,
               `country_name`
        FROM `stadium`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        GROUP BY `city_country_id`
        ORDER BY `country_name`";
$country_sql = f_igosja_mysqli_query($sql);

$country_array = $country_sql->fetch_all(1);

$sql = "SELECT `city_id`,
               `city_name`
        FROM `stadium`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        GROUP BY `stadium_city_id`
        ORDER BY `city_name`";
$city_sql = f_igosja_mysqli_query($sql);

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
$stadium_sql = f_igosja_mysqli_query($sql);

$stadium_array = $stadium_sql->fetch_all(1);

$breadcrumb_array[] = 'Стадионы';

include(__DIR__ . '/../include/pagination_count.php');
include(__DIR__ . '/view/layout/main.php');