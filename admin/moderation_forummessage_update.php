<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `forummessage_text`
        FROM `forummessage`
        WHERE `forummessage_id`=$num_get
        LIMIT 1";
$forummessage_sql = f_igosja_mysqli_query($sql);

if (0 == $forummessage_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$forummessage_array = $forummessage_sql->fetch_all(MYSQLI_ASSOC);

if ($data = f_igosja_request_post('data'))
{
    $set_sql = f_igosja_sql_data($data, array(
        'forummessage_text',
    ));

    $sql = "UPDATE `forummessage`
            SET $set_sql
            WHERE `forummessage_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    redirect('/admin/moderation_forummessage.php');
}

$breadcrumb_array[] = array('url' => 'moderation_forummessage.php', 'text'  => 'Модерация');
$breadcrumb_array[] = array('url' => 'moderation_forummessage.php', 'text'  => 'Сообщение на форуме');
$breadcrumb_array[] = 'Редактирование';

include(__DIR__ . '/view/layout/main.php');