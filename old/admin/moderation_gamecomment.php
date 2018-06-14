<?php

include(__DIR__ . '/../include/include.php');

$sql = "SELECT `gamecomment_id`,
               `gamecomment_text`,
               `user_id`,
               `user_login`
        FROM `gamecomment`
        LEFT JOIN `user`
        ON `gamecomment_user_id`=`user_id`
        WHERE `gamecomment_check`=0
        ORDER BY `gamecomment_id` ASC
        LIMIT 1";
$gamecomment_sql = f_igosja_mysqli_query($sql);

if (0 == $gamecomment_sql->num_rows)
{
    redirect('/admin/moderation_news.php');
}

$gamecomment_array = $gamecomment_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'moderation_gamecomment.php', 'text'  => 'Модерация');
$breadcrumb_array[] = 'Комментарий к матчу';

include(__DIR__ . '/view/layout/main.php');