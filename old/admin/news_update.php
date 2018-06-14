<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `news_id`,
               `news_text`,
               `news_title`
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
        'news_title'
    ), true);

    $sql = "UPDATE `news`
            SET $set_sql
            WHERE `news_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    redirect('/admin/news_view.php?num=' . $num_get);
}

$breadcrumb_array[] = array('url' => 'news_list.php', 'text' => 'Новости');
$breadcrumb_array[] = array(
    'url' => 'news_view.php?num=' . $news_array[0]['news_id'],
    'text' => $news_array[0]['news_title']
);
$breadcrumb_array[] = 'Редактирование';

include(__DIR__ . '/view/layout/main.php');