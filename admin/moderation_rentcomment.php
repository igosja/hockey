<?php

include(__DIR__ . '/../include/include.php');

$sql = "SELECT `rentcomment_id`,
               `rentcomment_text`,
               `user_id`,
               `user_login`
        FROM `rentcomment`
        LEFT JOIN `user`
        ON `rentcomment_user_id`=`user_id`
        WHERE `rentcomment_check`=0
        ORDER BY `rentcomment_id` ASC
        LIMIT 1";
$rentcomment_sql = f_igosja_mysqli_query($sql);

if (0 == $rentcomment_sql->num_rows)
{
    redirect('/admin/moderation_transfercomment.php');
}

$rentcomment_array = $rentcomment_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'moderation_rentcomment.php', 'text'  => 'Модерация');
$breadcrumb_array[] = 'Комментарий к аренде';

include(__DIR__ . '/view/layout/main.php');