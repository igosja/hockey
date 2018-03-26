<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `newscomment_text`
        FROM `newscomment`
        WHERE `newscomment_id`=$num_get
        LIMIT 1";
$newscomment_sql = f_igosja_mysqli_query($sql);

if (0 == $newscomment_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$newscomment_array = $newscomment_sql->fetch_all(MYSQLI_ASSOC);

if ($data = f_igosja_request_post('data'))
{
    $set_sql = f_igosja_sql_data($data, array(
        'newscomment_text',
    ));

    $sql = "UPDATE `newscomment`
            SET $set_sql
            WHERE `newscomment_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    redirect('/admin/moderation_newscomment.php');
}

$breadcrumb_array[] = array('url' => 'moderation_newscomment.php', 'text'  => 'Модерация');
$breadcrumb_array[] = array('url' => 'moderation_newscomment.php', 'text'  => 'Комментарий к новости');
$breadcrumb_array[] = 'Редактирование';

include(__DIR__ . '/view/layout/main.php');