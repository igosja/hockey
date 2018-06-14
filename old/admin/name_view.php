<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `name_id`,
               `name_name`
        FROM `name`
        WHERE `name_id`=$num_get
        LIMIT 1";
$name_sql = f_igosja_mysqli_query($sql);

if (0 == $name_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$name_array = $name_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `namecountry`
        LEFT JOIN `country`
        ON `namecountry_country_id`=`country_id`
        WHERE `namecountry_name_id`=$num_get
        ORDER BY `country_id` ASC";
$country_sql = f_igosja_mysqli_query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'name_list.php', 'text' => 'Имена');
$breadcrumb_array[] = $name_array[0]['name_name'];

include(__DIR__ . '/view/layout/main.php');