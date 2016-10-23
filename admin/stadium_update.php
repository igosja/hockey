<?php

include (__DIR__ . '/../include/include.php');

$num_get = (int) f_igosja_get('num');

if ($data = f_igosja_post('data'))
{
    $set_sql = f_igosja_sql_data($data);

    $sql = "UPDATE `stadium`
            SET $set_sql
            WHERE `stadium_id`='$num_get'
            LIMIT 1";
    igosja_db_query($sql);

    redirect('/admin/stadium_view.php?num=' . $num_get);
}

$sql = "SELECT `stadium_city_id`,
               `stadium_id`,
               `stadium_name`
        FROM `stadium`
        WHERE `stadium_id`='$num_get'
        LIMIT 1";
$stadium_sql = igosja_db_query($sql);

if (0 == $stadium_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$stadium_array = $stadium_sql->fetch_all(1);

$sql = "SELECT `city_id`,
               `city_name`
        FROM `city`
        ORDER BY `city_name` ASC";
$city_sql = igosja_db_query($sql);

$city_array = $city_sql->fetch_all(1);

$breadcrumb_array[] = array('url' => 'stadium_list.php', 'text' => 'Стадионы');
$breadcrumb_array[] = array(
    'url' => 'stadium_view.php?num=' . $stadium_array[0]['stadium_id'],
    'text' => $stadium_array[0]['stadium_name']
);
$breadcrumb_array[] = 'Редактирование';

include (__DIR__ . '/view/layout/main.php');