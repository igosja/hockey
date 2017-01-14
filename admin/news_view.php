<?php

include (__DIR__ . '/../include/include.php');

$num_get = (int) f_igosja_request_get('num');

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

$news_array = $news_sql->fetch_all(1);

$breadcrumb_array[] = array('url' => 'news_list.php', 'text' => 'Новости');
$breadcrumb_array[] = $news_array[0]['news_title'];

include (__DIR__ . '/view/layout/main.php');