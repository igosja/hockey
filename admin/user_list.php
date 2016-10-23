<?php

include (__DIR__ . '/../include/include.php');
include (__DIR__ . '/../include/pagination_offset.php');

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `user_id`,
               `user_login`
        FROM `user`
        WHERE $sql_filter
        ORDER BY `user_id`
        LIMIT $offset, $limit";
$user_sql = igosja_db_query($sql);

$user_array = $user_sql->fetch_all(1);

$breadcrumb_array[] = 'Пользователи';

include (__DIR__ . '/../include/pagination_count.php');
include (__DIR__ . '/view/layout/main.php');