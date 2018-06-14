<?php

include(__DIR__ . '/../include/include.php');

if ($data = f_igosja_request_post('data'))
{
    $set_sql = f_igosja_sql_data($data, array(
        'blockreason_text'
    ));

    $sql = "INSERT INTO `blockreason`
            SET $set_sql";
    f_igosja_mysqli_query($sql);

    redirect('/admin/blockreason_view.php?num=' . $mysqli->insert_id);
}

$breadcrumb_array[] = array('url' => 'blockreason_list.php', 'text' => 'Причины блокировки');
$breadcrumb_array[] = 'Создание';

$tpl = 'blockreason_update';

include(__DIR__ . '/view/layout/main.php');