<?php

include (__DIR__ . '/../include/include.php');

if ($data = f_igosja_post('data'))
{
    $set_sql = f_igosja_sql_data($data);

    $sql = "INSERT INTO `stadium`
            SET $set_sql";
    igosja_db_query($sql);

    redirect('/admin/stadium_view.php?num=' . $mysqli->insert_id);
}

$sql = "SELECT `city_id`,
               `city_name`
        FROM `city`
        ORDER BY `city_name` ASC";
$city_sql = igosja_db_query($sql);

$city_array = $city_sql->fetch_all(1);

$breadcrumb_array[] = array('url' => 'stadium_list.php', 'text' => 'Стадионы');
$breadcrumb_array[] = 'Создание';

$tpl = 'stadium_update';

include (__DIR__ . '/view/layout/main.php');