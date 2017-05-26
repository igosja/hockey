<?php

include(__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

if ($num_get = (int) f_igosja_request_get('num'))
{
    $sql = "DELETE FROM `message`
            WHERE `message_id`=$num_get
            AND ((`message_user_id_to`=$auth_user_id
            AND `message_support_from`=1)
            OR (`message_user_id_from`=$auth_user_id
            AND `message_support_to`=1))
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    $_SESSION['message']['class']   = 'success';
    $_SESSION['message']['text']    = 'Сообщение успешно удалено.';
}

redirect('/support.php');