<?php

include(__DIR__ . '/../include/include.php');

if ($data = f_igosja_request_post('data'))
{
    $set_sql = f_igosja_sql_data($data, array(
        'country_name'
    ));

    $sql = "INSERT INTO `country`
            SET $set_sql";
    f_igosja_mysqli_query($sql);

    redirect('/admin/country_view.php?num=' . $mysqli->insert_id);
}

$breadcrumb_array[] = array('url' => 'country_list.php', 'text' => 'Разделы');
$breadcrumb_array[] = 'Создание';

$tpl = 'forumchapter_update';

include(__DIR__ . '/view/layout/main.php');