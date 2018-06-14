<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `city_id`,
               `city_name`,
               `country_id`,
               `country_name`
        FROM `city`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `city_id`=$num_get
        LIMIT 1";
$city_sql = f_igosja_mysqli_query($sql);

if (0 == $city_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$city_array = $city_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'city_list.php', 'text' => 'Города');
$breadcrumb_array[] = $city_array[0]['city_name'];

include(__DIR__ . '/view/layout/main.php');