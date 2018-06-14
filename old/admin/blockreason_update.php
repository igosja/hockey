<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `blockreason_id`,
               `blockreason_text`
        FROM `blockreason`
        WHERE `blockreason_id`=$num_get
        LIMIT 1";
$blockreason_sql = f_igosja_mysqli_query($sql);

if (0 == $blockreason_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$blockreason_array = $blockreason_sql->fetch_all(MYSQLI_ASSOC);

if ($data = f_igosja_request_post('data'))
{
    $set_sql = f_igosja_sql_data($data, array(
        'blockreason_text'
    ));

    $sql = "UPDATE `blockreason`
            SET $set_sql
            WHERE `blockreason_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    redirect('/admin/blockreason_view.php?num=' . $num_get);
}

$breadcrumb_array[] = array('url' => 'blockreason_list.php', 'text' => 'Причины блокировки');
$breadcrumb_array[] = array(
    'url' => 'blockreason_view.php?num=' . $blockreason_array[0]['blockreason_id'],
    'text' => $blockreason_array[0]['blockreason_name']
);
$breadcrumb_array[] = 'Редактирование';

include(__DIR__ . '/view/layout/main.php');