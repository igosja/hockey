<?php

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    if (!isset($auth_user_id))
    {
        redirect('/wrong_page.php');
    }

    $num_get = $auth_user_id;
}

include(__DIR__ . '/include/sql/user_view.php');

$sql = "SELECT `user_id`,
               `user_login`
        FROM `message`
        LEFT JOIN `user`
        ON IF (`message_user_id_from`=$auth_user_id, `message_user_id_to`, `message_user_id_from`)=`user_id`
        WHERE (`message_support_to`=0
        AND `message_user_id_from`=$auth_user_id)
        OR (`message_support_from`=0
        AND `message_user_id_to`=$auth_user_id)
        GROUP BY `user_id`
        ORDER BY `message_id` DESC";
$message_sql = f_igosja_mysqli_query($sql);

$message_array = $message_sql->fetch_all(1);

include(__DIR__ . '/view/layout/main.php');