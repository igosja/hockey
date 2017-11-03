<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        WHERE `country_id`=$num_get
        LIMIT 1";
$country_sql = f_igosja_mysqli_query($sql);

if (0 == $country_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'country_list.php', 'text' => 'Страны');
$breadcrumb_array[] = $country_array[0]['country_name'];

include(__DIR__ . '/view/layout/main.php');