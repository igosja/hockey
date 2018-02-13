<?php

/**
 * @var $auth_admin_user_id integer
 * @var $mysqli mysqli
 */

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `message_date`,
               `message_id`,
               `message_text`,
               `user_id`,
               `user_login`
        FROM `message`
        LEFT JOIN `user`
        ON `message_user_id_from`=`user_id`
        WHERE (`message_user_id_from`=$num_get
        AND `message_support_to`=1)
        OR (`message_user_id_to`=$num_get
        AND `message_support_from`=1)
        ORDER BY `message_id` DESC";
$message_sql = f_igosja_mysqli_query($sql);

if (0 == $message_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$message_array = $message_sql->fetch_all(MYSQLI_ASSOC);

$user_login = end($message_array);
$user_login = $user_login['user_login'];

if ($data = f_igosja_request_post('data'))
{
    if (isset($data['text']))
    {
        $text = trim($data['text']);
        $text = $mysqli->real_escape_string($text);

        if (!empty($text))
        {
            $sql = "INSERT INTO `message`
                    SET `message_date`=UNIX_TIMESTAMP(),
                        `message_text`='$text',
                        `message_support_from`=1,
                        `message_user_id_from`=$auth_admin_user_id,
                        `message_user_id_to`=$num_get";
            f_igosja_mysqli_query($sql);
        }
    }

    refresh();
}

$sql = "UPDATE `message`
        SET `message_read`=1
        WHERE `message_user_id_from`=$num_get
        AND `message_support_to`=1";
f_igosja_mysqli_query($sql);

$breadcrumb_array[] = array('url' => 'support_list.php', 'text' => 'Вопросы в техподдержку');
$breadcrumb_array[] = $message_array[0]['user_login'];

include(__DIR__ . '/view/layout/main.php');