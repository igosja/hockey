<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `gamecomment_text`
        FROM `gamecomment`
        WHERE `gamecomment_id`=$num_get
        LIMIT 1";
$gamecomment_sql = f_igosja_mysqli_query($sql);

if (0 == $gamecomment_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$gamecomment_array = $gamecomment_sql->fetch_all(MYSQLI_ASSOC);

if ($data = f_igosja_request_post('data'))
{
    $set_sql = f_igosja_sql_data($data, array(
        'gamecomment_text',
    ));

    $sql = "UPDATE `gamecomment`
            SET $set_sql
            WHERE `gamecomment_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    redirect('/admin/moderation_gamecomment.php');
}

$breadcrumb_array[] = array('url' => 'moderation_gamecomment.php', 'text'  => 'Модерация');
$breadcrumb_array[] = array('url' => 'moderation_gamecomment.php', 'text'  => 'Комментарий к матчу');
$breadcrumb_array[] = 'Редактирование';

include(__DIR__ . '/view/layout/main.php');