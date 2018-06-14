<?php

include(__DIR__ . '/../include/include.php');

if ($data = f_igosja_request_post('data'))
{
    $set_sql = f_igosja_sql_data($data, array(
        'tournamenttype_name'
    ));

    $sql = "INSERT INTO `tournamenttype`
            SET $set_sql";
    f_igosja_mysqli_query($sql);

    redirect('/admin/tournamenttype_view.php?num=' . $mysqli->insert_id);
}

$breadcrumb_array[] = array('url' => 'tournamenttype_list.php', 'text' => 'Типы турниров');
$breadcrumb_array[] = 'Создание';

$tpl = 'tournamenttype_update';

include(__DIR__ . '/view/layout/main.php');