<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `rentcomment_text`
        FROM `rentcomment`
        WHERE `rentcomment_id`=$num_get
        LIMIT 1";
$rentcomment_sql = f_igosja_mysqli_query($sql);

if (0 == $rentcomment_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$rentcomment_array = $rentcomment_sql->fetch_all(MYSQLI_ASSOC);

if ($data = f_igosja_request_post('data'))
{
    $set_sql = f_igosja_sql_data($data, array(
        'rentcomment_text',
    ));

    $sql = "UPDATE `rentcomment`
            SET $set_sql
            WHERE `rentcomment_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    redirect('/admin/moderation_rentcomment.php');
}

$breadcrumb_array[] = array('url' => 'moderation_rentcomment.php', 'text'  => 'Модерация');
$breadcrumb_array[] = array('url' => 'moderation_rentcomment.php', 'text'  => 'Комментарий к аренде');
$breadcrumb_array[] = 'Редактирование';

include(__DIR__ . '/view/layout/main.php');