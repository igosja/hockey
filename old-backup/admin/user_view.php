<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `user_code`,
               `user_date_block`,
               `user_date_block_comment`,
               `user_date_block_dealcomment`,
               `user_date_block_forum`,
               `user_date_block_gamecomment`,
               `user_date_block_newscomment`,
               `user_date_login`,
               `user_date_register`,
               `user_email`,
               `user_id`,
               `user_ip`,
               `user_login`,
               `user_money`
        FROM `user`
        WHERE `user_id`=$num_get
        LIMIT 1";
$user_sql = f_igosja_mysqli_query($sql);

if (0 == $user_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

$user_ip = $user_array[0]['user_ip'];

$sql = "SELECT `user_id`,
               `user_ip`,
               `user_login`
        FROM `user`
        WHERE `user_ip`='$user_ip'
        AND `user_id`!=$num_get
        AND `user_date_block`<UNIX_TIMESTAMP()";
$ip_sql = f_igosja_mysqli_query($sql);

$ip_array = $ip_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `onecomputer_count`,
               `user_id`,
               `user_ip`,
               `user_login`
        FROM `onecomputer`
        LEFT JOIN `user`
        ON IF(`onecomputer_user_id`=$num_get, `onecomputer_child_id`, `onecomputer_user_id`)=`user_id`
        WHERE (`onecomputer_user_id`=$num_get
        OR `onecomputer_child_id`=$num_get)
        AND `user_date_block`<UNIX_TIMESTAMP()";
$cookie_sql = f_igosja_mysqli_query($sql);

$cookie_array = $cookie_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'user_list.php', 'text' => 'Пользователи');
$breadcrumb_array[] = $user_array[0]['user_login'];

include(__DIR__ . '/view/layout/main.php');