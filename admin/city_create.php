<?php

include (__DIR__ . '/../include/include.php');

if ($data = f_igosja_post('data'))
{
    $set_sql = f_igosja_sql_data($data);

    $sql = "INSERT INTO `city`
            SET $set_sql";
    igosja_db_query($sql);

    redirect('/admin/city_view.php?num=' . $mysqli->insert_id);
}

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        ORDER BY `country_name` ASC";
$country_sql = igosja_db_query($sql);

$country_array = $country_sql->fetch_all(1);

$breadcrumb_array[] = array('url' => 'city_list.php', 'text' => 'Города');
$breadcrumb_array[] = 'Создание';

$tpl = 'city_update';

include (__DIR__ . '/view/layout/main.php');