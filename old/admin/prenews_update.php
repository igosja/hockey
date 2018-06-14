<?php

include(__DIR__ . '/../include/include.php');

$sql = "SELECT `prenews_error`,
               `prenews_new`
        FROM `prenews`
        WHERE `prenews_id`=1
        LIMIT 1";
$prenews_sql = f_igosja_mysqli_query($sql);

if (0 == $prenews_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$prenews_array = $prenews_sql->fetch_all(MYSQLI_ASSOC);

if ($data = f_igosja_request_post('data'))
{
    $set_sql = f_igosja_sql_data($data, array(
        'prenews_error',
        'prenews_new'
    ), true);

    $sql = "UPDATE `prenews`
            SET $set_sql
            WHERE `prenews_id`=1
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    redirect('/admin/prenews_view.php');
}

$breadcrumb_array[] = array('url' => 'prenews_view.php', 'text' => 'Предварительные новости');
$breadcrumb_array[] = 'Редактирование';

include(__DIR__ . '/view/layout/main.php');