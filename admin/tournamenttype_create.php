<?php

include (__DIR__ . '/../include/include.php');

if ($data = f_igosja_post('data'))
{
    $set_sql = f_igosja_sql_data($data);

    $sql = "INSERT INTO `tournamenttype`
            SET $set_sql";
    igosja_db_query($sql);

    redirect('/admin/tournamenttype_view.php?num=' . $mysqli->insert_id);
}

$breadcrumb_array[] = array('url' => 'tournamenttype_list.php', 'text' => 'Типы турниров');
$breadcrumb_array[] = 'Создание';

$tpl = 'tournamenttype_update';

include (__DIR__ . '/view/layout/main.php');