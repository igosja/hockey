<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `surname_id`,
               `surname_name`
        FROM `surname`
        WHERE `surname_id`=$num_get
        LIMIT 1";
$surname_sql = f_igosja_mysqli_query($sql);

if (0 == $surname_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$surname_array = $surname_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `surnamecountry`
        LEFT JOIN `country`
        ON `surnamecountry_country_id`=`country_id`
        WHERE `surnamecountry_surname_id`=$num_get
        ORDER BY `country_id` ASC";
$country_sql = f_igosja_mysqli_query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'surname_list.php', 'text' => 'Фамилии');
$breadcrumb_array[] = $surname_array[0]['surname_name'];

include(__DIR__ . '/view/layout/main.php');