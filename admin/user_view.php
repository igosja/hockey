<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `user_code`,
               `user_date_forum_block`,
               `user_date_login`,
               `user_date_register`,
               `user_email`,
               `user_id`,
               `user_login`,
               `user_money`
        FROM `user`
        WHERE `user_id`=$num_get
        LIMIT 1";
$user_sql = f_igosja_mysqli_query($sql, false);

if (0 == $user_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$user_array = $user_sql->fetch_all(1);

$breadcrumb_array[] = array('url' => 'user_list.php', 'text' => 'Пользователи');
$breadcrumb_array[] = $user_array[0]['user_login'];

include(__DIR__ . '/view/layout/main.php');