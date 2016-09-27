<?php

include(__DIR__ . '/../../include/pagination_offset.php');

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `surname_id`,
               `surname_name`
        FROM `surname`
        WHERE $sql_filter
        ORDER BY `surname_id`
        LIMIT $offset, $limit";
$surname_sql = igosja_db_query($sql);
$surname_array = $surname_sql->fetch_all(1);

include(__DIR__ . '/../../include/pagination_count.php');