<?php

include(__DIR__ . '/../include/include.php');

$sql = "SELECT `transfercomment_id`,
               `transfercomment_text`,
               `user_id`,
               `user_login`
        FROM `transfercomment`
        LEFT JOIN `user`
        ON `transfercomment_user_id`=`user_id`
        WHERE `transfercomment_check`=0
        ORDER BY `transfercomment_id` ASC
        LIMIT 1";
$transfercomment_sql = f_igosja_mysqli_query($sql);

if (0 == $transfercomment_sql->num_rows)
{
    redirect('/admin/moderation_review.php');
}

$transfercomment_array = $transfercomment_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'moderation_transfercomment.php', 'text'  => 'Модерация');
$breadcrumb_array[] = 'Комментарий к трансферу';

include(__DIR__ . '/view/layout/main.php');