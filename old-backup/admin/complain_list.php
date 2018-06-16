<?php

/**
 * @var $sql_filter string
 */

include(__DIR__ . '/../include/include.php');
include(__DIR__ . '/../include/pagination_offset.php');

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `complain_date`,
               `complain_id`,
               `complain_url`,
               `user_id`,
               `user_login`
        FROM `complain`
        LEFT JOIN `user`
        ON `complain_user_id`=`user_id`
        WHERE $sql_filter
        ORDER BY `complain_id` ASC
        LIMIT $offset, $limit";
$complain_sql = f_igosja_mysqli_query($sql);

$complain_array = $complain_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = 'Жалобы на форуме';

include(__DIR__ . '/../include/pagination_count.php');
include(__DIR__ . '/view/layout/main.php');