<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `news_text`
        FROM `news`
        WHERE `news_id`=$num_get
        LIMIT 1";
$news_sql = f_igosja_mysqli_query($sql);

if (0 == $news_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$news_array = $news_sql->fetch_all(MYSQLI_ASSOC);

if ($data = f_igosja_request_post('data'))
{
    $set_sql = f_igosja_sql_data($data, array(
        'news_text',
    ));

    $sql = "UPDATE `news`
            SET $set_sql
            WHERE `news_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    redirect('/admin/moderation_news.php');
}

$breadcrumb_array[] = array('url' => 'moderation_news.php', 'text'  => 'Модерация');
$breadcrumb_array[] = array('url' => 'moderation_news.php', 'text'  => 'Новость');
$breadcrumb_array[] = 'Редактирование';

include(__DIR__ . '/view/layout/main.php');