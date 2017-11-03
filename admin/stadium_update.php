<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `stadium_city_id`,
               `stadium_id`,
               `stadium_name`
        FROM `stadium`
        WHERE `stadium_id`=$num_get
        LIMIT 1";
$stadium_sql = f_igosja_mysqli_query($sql);

if (0 == $stadium_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$stadium_array = $stadium_sql->fetch_all(MYSQLI_ASSOC);

if ($data = f_igosja_request_post('data'))
{
    $set_sql = f_igosja_sql_data($data, array(
        'stadium_city_id',
        'stadium_name'
    ));

    $sql = "UPDATE `stadium`
            SET $set_sql
            WHERE `stadium_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    redirect('/admin/stadium_view.php?num=' . $num_get);
}

$sql = "SELECT `city_id`,
               `city_name`
        FROM `city`
        ORDER BY `city_name` ASC, `city_id` ASC";
$city_sql = f_igosja_mysqli_query($sql);

$city_array = $city_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'stadium_list.php', 'text' => 'Стадионы');
$breadcrumb_array[] = array(
    'url' => 'stadium_view.php?num=' . $stadium_array[0]['stadium_id'],
    'text' => $stadium_array[0]['stadium_name']
);
$breadcrumb_array[] = 'Редактирование';

include(__DIR__ . '/view/layout/main.php');