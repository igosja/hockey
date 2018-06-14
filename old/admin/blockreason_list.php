<?php

/**
 * @var $limit integer
 * @var $offset integer
 * @var $sql_filter string
 */

include(__DIR__ . '/../include/include.php');
include(__DIR__ . '/../include/pagination_offset.php');

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `blockreason_id`,
               `blockreason_text`
        FROM `blockreason`
        WHERE $sql_filter
        ORDER BY `blockreason_id` ASC
        LIMIT $offset, $limit";
$blockreason_sql = f_igosja_mysqli_query($sql);

$blockreason_array = $blockreason_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = 'Причины блокировки';

include(__DIR__ . '/../include/pagination_count.php');
include(__DIR__ . '/view/layout/main.php');