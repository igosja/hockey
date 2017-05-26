<?php

include(__DIR__ . '/../include/include.php');
include(__DIR__ . '/../include/pagination_offset.php');

$sql = "SELECT `country_id`,
               `country_name`
        FROM `city`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        GROUP BY `city_country_id`
        ORDER BY `country_name`";
$country_sql = f_igosja_mysqli_query($sql);

$country_array = $country_sql->fetch_all(1);

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `city_id`,
               `city_name`,
               `country_id`,
               `country_name`
        FROM `city`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE $sql_filter
        ORDER BY `city_id`
        LIMIT $offset, $limit";
$city_sql = f_igosja_mysqli_query($sql);

$city_array = $city_sql->fetch_all(1);

$breadcrumb_array[] = 'Города';

include(__DIR__ . '/../include/pagination_count.php');
include(__DIR__ . '/view/layout/main.php');