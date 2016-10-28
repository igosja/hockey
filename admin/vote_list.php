<?php

include (__DIR__ . '/../include/include.php');
include (__DIR__ . '/../include/pagination_offset.php');

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `vote_id`,
               `vote_text`
        FROM `vote`
        WHERE $sql_filter
        ORDER BY `vote_id`
        LIMIT $offset, $limit";
$vote_sql = igosja_db_query($sql);

$vote_array = $vote_sql->fetch_all(1);

$breadcrumb_array[] = 'Опросы';

include (__DIR__ . '/../include/pagination_count.php');
include (__DIR__ . '/view/layout/main.php');