<?php

include (__DIR__ . '/../include/include.php');

$num_get = (int) f_igosja_get('num');

$sql = "SELECT `surname_id`,
               `surname_name`
        FROM `surname`
        WHERE `surname_id`='$num_get'
        LIMIT 1";
$surname_sql = igosja_db_query($sql);

if (0 == $surname_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$surname_array = $surname_sql->fetch_all(1);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `surnamecountry`
        LEFT JOIN `country`
        ON `surnamecountry_country_id`=`country_id`
        WHERE `surnamecountry_surname_id`='$num_get'";
$country_sql = igosja_db_query($sql);

$country_array = $country_sql->fetch_all(1);

$breadcrumb_array[] = array('url' => 'surname_list.php', 'text' => 'Фамилии');
$breadcrumb_array[] = $surname_array[0]['surname_name'];

include (__DIR__ . '/view/layout/main.php');