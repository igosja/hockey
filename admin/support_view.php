<?php

include (__DIR__ . '/../include/include.php');

$num_get = (int) f_igosja_get('num');

$sql = "SELECT `message_date`,
               `message_id`,
               `message_text`,
               `user_id`,
               `user_login`
        FROM `message`
        LEFT JOIN `user`
        ON `message_user_id_from`=`user_id`
        WHERE (`message_user_id_from`='$num_get'
        AND `message_support_to`='1')
        OR (`message_user_id_to`='$num_get'
        AND `message_support_from`='1')
        ORDER BY `message_id` DESC";
$message_sql = igosja_db_query($sql);

if (0 == $message_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$message_array = $message_sql->fetch_all(1);

if ($data = f_igosja_post('data'))
{
    if (isset($data['text']) && !empty(trim($data['text'])))
    {
        $text = trim($data['text']);

        $sql = "INSERT INTO `message`
                SET `message_date`=UNIX_TIMESTAMP(),
                    `message_text`='$text',
                    `message_support_from`='1',
                    `message_user_id_from`='$auth_user_id',
                    `message_user_id_to`='$num_get'";
        igosja_db_query($sql);

        refresh();
    }
}

$sql = "UPDATE `message`
        SET `message_read`='1'
        WHERE `message_user_id_from`='$num_get'
        AND `message_support_to`='1'";
igosja_db_query($sql);

$breadcrumb_array[] = array('url' => 'support_list.php', 'text' => 'Вопросы в техподдержку');
$breadcrumb_array[] = $message_array[0]['user_login'];

include (__DIR__ . '/view/layout/main.php');