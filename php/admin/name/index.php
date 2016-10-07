<?php

include(__DIR__ . '/../../include/pagination_offset.php');

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `name_id`,
               `name_name`
        FROM `name`
        WHERE $sql_filter
        ORDER BY `name_id`
        LIMIT $offset, $limit";
$name_sql = igosja_db_query($sql);

$name_array = $name_sql->fetch_all(1);

$breadcrumb_array[] = 'Имена';

include(__DIR__ . '/../../include/pagination_count.php');