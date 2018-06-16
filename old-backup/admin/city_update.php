<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `city_country_id`,
               `city_id`,
               `city_name`
        FROM `city`
        WHERE `city_id`=$num_get
        LIMIT 1";
$city_sql = f_igosja_mysqli_query($sql);

if (0 == $city_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$city_array = $city_sql->fetch_all(MYSQLI_ASSOC);

if ($data = f_igosja_request_post('data'))
{
    $set_sql = f_igosja_sql_data($data, array(
        'city_country_id',
        'city_name'
    ));

    $sql = "UPDATE `city`
            SET $set_sql
            WHERE `city_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    redirect('/admin/city_view.php?num=' . $num_get);
}

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        ORDER BY `country_name` ASC, `country_id` ASC";
$country_sql = f_igosja_mysqli_query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'city_list.php', 'text' => 'Города');
$breadcrumb_array[] = array(
    'url' => 'city_view.php?num=' . $city_array[0]['city_id'],
    'text' => $city_array[0]['city_name']
);
$breadcrumb_array[] = 'Редактирование';

include(__DIR__ . '/view/layout/main.php');