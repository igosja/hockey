<?php

/**
 * @var $limit integer
 * @var $offset integer
 * @var $sql_filter string
 */

include(__DIR__ . '/../include/include.php');
include(__DIR__ . '/../include/pagination_offset.php');

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `surname_id`,
               `surname_name`
        FROM `surname`
        WHERE $sql_filter
        ORDER BY `surname_id` ASC
        LIMIT $offset, $limit";
$surname_sql = f_igosja_mysqli_query($sql);

$surname_array = $surname_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = 'Фамилии';

include(__DIR__ . '/../include/pagination_count.php');
include(__DIR__ . '/view/layout/main.php');