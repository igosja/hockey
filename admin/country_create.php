<?php

include (__DIR__ . '/../include/include.php');

if ($data = f_igosja_post('data'))
{
    $set_sql = f_igosja_sql_data($data);

    $sql = "INSERT INTO `country`
            SET $set_sql";
    igosja_db_query($sql);

    redirect('/admin/country_view.php?num=' . $mysqli->insert_id);
}

$breadcrumb_array[] = array('url' => 'country_list.php', 'text' => 'Страны');
$breadcrumb_array[] = 'Создание';

$tpl = 'country_update';

include (__DIR__ . '/view/layout/main.php');