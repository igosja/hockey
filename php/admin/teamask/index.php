<?php

include(__DIR__ . '/../../include/pagination_offset.php');

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `teamask_id`,
               `teamask_date`
        FROM `teamask`
        WHERE $sql_filter
        ORDER BY `teamask_date` ASC
        LIMIT $offset, $limit";
$teamask_sql = igosja_db_query($sql);

$teamask_array = $teamask_sql->fetch_all(1);

$breadcrumb_array[] = 'Заявки на команды';

include(__DIR__ . '/../../include/pagination_count.php');