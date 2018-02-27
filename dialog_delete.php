<?php

/**
 * @var $auth_user_id integer
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `message_id`,
               `message_user_id_from`,
               `message_user_id_to`
        FROM `message`
        WHERE `message_id`=$num_get
        AND ((`message_user_id_to`=$auth_user_id
        AND `message_support_from`=0)
        OR (`message_user_id_from`=$auth_user_id
        AND `message_support_to`=0))
        LIMIT 1";
$message_sql = f_igosja_mysqli_query($sql);

if (0 == $message_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$message_array = $message_sql->fetch_all(MYSQLI_ASSOC);

$message_id = $message_array[0]['message_id'];

if ($auth_user_id == $message_array[0]['message_user_id_from'])
{
    $field      = '`message_delete_from`';
    $user_id    = $message_array[0]['message_user_id_to'];
}
else
{
    $field      = '`message_delete_to`';
    $user_id    = $message_array[0]['message_user_id_from'];
}

$sql = "UPDATE `message`
        SET " . $field . "=1
        WHERE `message_id`=$message_id
        LIMIT 1";
f_igosja_mysqli_query($sql);

$sql = "DELETE FROM `message`
        WHERE `message_id`=$num_get
        AND `message_delete_from`=1
        AND `message_delete_to`=1
        LIMIT 1";
f_igosja_mysqli_query($sql);

f_igosja_session_front_flash_set('success', 'Сообщение успешно удалено.');

redirect('/dialog.php?num=' . $user_id);