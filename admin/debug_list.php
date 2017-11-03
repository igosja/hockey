<?php

/**
 * @var $limit integer
 * @var $offset integer
 * @var $sql_filter string
 */

include(__DIR__ . '/../include/include.php');
include(__DIR__ . '/../include/pagination_offset.php');

$sort = f_igosja_request_get('sort');

if (1 == $sort)
{
    $order = '`debug_sql` ASC';
}
elseif (2 == $sort)
{
    $order = '`debug_sql` DESC';
}
elseif (3 == $sort)
{
    $order = '`debug_time` ASC';
}
elseif (4 == $sort)
{
    $order = '`debug_time` DESC';
}
else
{
    $order = '`debug_id` ASC';
}

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `debug_id`,
               `debug_file`,
               `debug_line`,
               `debug_sql`,
               `debug_time`
        FROM `debug`
        WHERE $sql_filter
        ORDER BY $order
        LIMIT $offset, $limit";
$debug_sql = f_igosja_mysqli_query($sql);

$debug_array = $debug_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = 'Debugger';

include(__DIR__ . '/../include/pagination_count.php');
include(__DIR__ . '/view/layout/main.php');