<?php

include (__DIR__ . '/../include/include.php');
include (__DIR__ . '/../include/pagination_offset.php');

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `rule_id`,
               `rule_title`
        FROM `rule`
        WHERE $sql_filter
        ORDER BY `rule_order`
        LIMIT $offset, $limit";
$rule_sql = f_igosja_mysqli_query($sql);

$rule_array = $rule_sql->fetch_all(1);

$breadcrumb_array[] = 'Правила';

include (__DIR__ . '/../include/pagination_count.php');
include (__DIR__ . '/view/layout/main.php');