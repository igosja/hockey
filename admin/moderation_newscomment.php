<?php

include(__DIR__ . '/../include/include.php');

$sql = "SELECT `newscomment_id`,
               `newscomment_text`,
               `user_id`,
               `user_login`
        FROM `newscomment`
        LEFT JOIN `user`
        ON `newscomment_user_id`=`user_id`
        WHERE `newscomment_check`=0
        ORDER BY `newscomment_id` ASC
        LIMIT 1";
$newscomment_sql = f_igosja_mysqli_query($sql);

if (0 == $newscomment_sql->num_rows)
{
    redirect('/admin/moderation_rentcomment.php');
}

$newscomment_array = $newscomment_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'moderation_newscomment.php', 'text'  => 'Модерация');
$breadcrumb_array[] = 'Комментарий к новости';

include(__DIR__ . '/view/layout/main.php');