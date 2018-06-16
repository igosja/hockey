<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `transfercomment_text`
        FROM `transfercomment`
        WHERE `transfercomment_id`=$num_get
        LIMIT 1";
$transfercomment_sql = f_igosja_mysqli_query($sql);

if (0 == $transfercomment_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$transfercomment_array = $transfercomment_sql->fetch_all(MYSQLI_ASSOC);

if ($data = f_igosja_request_post('data'))
{
    $set_sql = f_igosja_sql_data($data, array(
        'transfercomment_text',
    ));

    $sql = "UPDATE `transfercomment`
            SET $set_sql
            WHERE `transfercomment_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    redirect('/admin/moderation_transfercomment.php');
}

$breadcrumb_array[] = array('url' => 'moderation_transfercomment.php', 'text'  => 'Модерация');
$breadcrumb_array[] = array('url' => 'moderation_transfercomment.php', 'text'  => 'Комментарий к трансферу');
$breadcrumb_array[] = 'Редактирование';

include(__DIR__ . '/view/layout/main.php');