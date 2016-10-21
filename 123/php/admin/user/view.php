<?php

$sql = "SELECT `user_date_login`,
               `user_date_register`,
               `user_email`,
               `user_id`,
               `user_login`,
               `user_money`
        FROM `user`
        WHERE `user_id`='$num_get'
        LIMIT 1";
$user_sql = igosja_db_query($sql);

$user_array = $user_sql->fetch_all(1);

$breadcrumb_array[] = array('url' => $route_path, 'text' => 'Пользователи');
$breadcrumb_array[] = $user_array[0]['user_login'];