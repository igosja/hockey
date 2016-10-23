<?php

include (__DIR__ . '/../include/include.php');

$num_get = (int) f_igosja_get('num');

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

if (0 == $city_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$city_array = $city_sql->fetch_all(1);

$breadcrumb_array[] = array('url' => 'city_list.php', 'text' => 'Города');
$breadcrumb_array[] = $city_array[0]['city_name'];

include (__DIR__ . '/view/layout/main.php');