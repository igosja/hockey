<?php

include (__DIR__ . '/../include/include.php');

$num_get = (int) f_igosja_get('num');

if ($data = f_igosja_post('data'))
{
    $set_sql = f_igosja_sql_data($data);

    $sql = "UPDATE `news`
            SET $set_sql
            WHERE `news_id`='$num_get'
            LIMIT 1";
    igosja_db_query($sql);

    redirect('/admin/news_view.php?num=' . $num_get);
}

$sql = "SELECT `news_id`,
               `news_text`,
               `news_title`
        FROM `news`
        WHERE `news_id`='$num_get'
        LIMIT 1";
$news_sql = igosja_db_query($sql);

if (0 == $news_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$news_array = $news_sql->fetch_all(1);

$breadcrumb_array[] = array('url' => 'news_list.php', 'text' => 'Новости');
$breadcrumb_array[] = array(
    'url' => 'news_view.php?num=' . $news_array[0]['news_id'],
    'text' => $news_array[0]['news_title']
);
$breadcrumb_array[] = 'Редактирование';

include (__DIR__ . '/view/layout/main.php');