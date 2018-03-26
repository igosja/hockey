<?php

include(__DIR__ . '/../include/include.php');

$sql = "SELECT `news_id`,
               `news_text`,
               `user_id`,
               `user_login`
        FROM `news`
        LEFT JOIN `user`
        ON `news_user_id`=`user_id`
        WHERE `news_check`=0
        ORDER BY `news_id` ASC
        LIMIT 1";
$news_sql = f_igosja_mysqli_query($sql);

if (0 == $news_sql->num_rows)
{
    redirect('/admin/moderation_newscomment.php');
}

$news_array = $news_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'moderation_news.php', 'text'  => 'Модерация');
$breadcrumb_array[] = 'Новость';

include(__DIR__ . '/view/layout/main.php');