<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `city_id`,
               `city_name`,
               `country_id`,
               `country_name`,
               `stadium_id`,
               `stadium_capacity`,
               `stadium_name`
        FROM `stadium`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `stadium_id`=$num_get
        LIMIT 1";
$stadium_sql = f_igosja_mysqli_query($sql);

if (0 == $stadium_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$stadium_array = $stadium_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'stadium_list.php', 'text' => 'Стадионы');
$breadcrumb_array[] = $stadium_array[0]['stadium_name'];

include(__DIR__ . '/view/layout/main.php');