<?php

include (__DIR__ . '/../include/include.php');
include (__DIR__ . '/../include/pagination_offset.php');

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `debug_id`,
               `debug_sql`,
               `debug_time`
        FROM `debug`
        WHERE $sql_filter
        ORDER BY `debug_id`
        LIMIT $offset, $limit";
$debug_sql = f_igosja_mysqli_query($sql);

$debug_array = $debug_sql->fetch_all(1);

$breadcrumb_array[] = 'Debugger';

include (__DIR__ . '/../include/pagination_count.php');
include (__DIR__ . '/view/layout/main.php');