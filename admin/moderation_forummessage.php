<?php

include(__DIR__ . '/../include/include.php');

$sql = "SELECT `forummessage_id`,
               `forummessage_text`,
               `user_id`,
               `user_login`
        FROM `forummessage`
        LEFT JOIN `user`
        ON `forummessage_user_id`=`user_id`
        WHERE `forummessage_check`=0
        ORDER BY `forummessage_id` ASC
        LIMIT 1";
$forummessage_sql = f_igosja_mysqli_query($sql);

if (0 == $forummessage_sql->num_rows)
{
    redirect('/admin/moderation_gamecomment.php');
}

$forummessage_array = $forummessage_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'moderation_forummessage.php', 'text'  => 'Модерация');
$breadcrumb_array[] = array('url' => 'moderation_forummessage.php', 'text'  => 'Сообщение на форуме');

include(__DIR__ . '/view/layout/main.php');