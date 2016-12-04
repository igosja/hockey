<?php

include (__DIR__ . '/../include/include.php');
include (__DIR__ . '/../include/pagination_offset.php');

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `message_date`,
               `message_id`,
               `message_read`,
               `user_id`,
               `user_login`
        FROM `message`
        LEFT JOIN `user`
        ON `message_user_id_from`=`user_id`
        WHERE $sql_filter
        AND `message_support_to`='1'
        ORDER BY `message_read` ASC, `message_id` DESC
        LIMIT $offset, $limit";
$message_sql = f_igosja_mysqli_query($sql);

$message_array = $message_sql->fetch_all(1);

$breadcrumb_array[] = 'Вопросы в техподдержку';

include (__DIR__ . '/../include/pagination_count.php');
include (__DIR__ . '/view/layout/main.php');