<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "DELETE FROM `news`
        WHERE `news_id`=$num_get
        LIMIT 1";
f_igosja_mysqli_query($sql);

$sql = "DELETE FROM `newscomment`
        WHERE `newscomment_news_id`=$num_get";
f_igosja_mysqli_query($sql);

redirect('/admin/moderation_news.php');