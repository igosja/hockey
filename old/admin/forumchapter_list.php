<?php

/**
 * @var $limit integer
 * @var $offset integer
 * @var $sql_filter string
 */

include(__DIR__ . '/../include/include.php');
include(__DIR__ . '/../include/pagination_offset.php');

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `forumchapter_id`,
               `forumchapter_name`
        FROM `forumchapter`
        WHERE $sql_filter
        ORDER BY `forumchapter_id` ASC
        LIMIT $offset, $limit";
$forumchapter_sql = f_igosja_mysqli_query($sql);

$forumchapter_array = $forumchapter_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = 'Разделы';

include(__DIR__ . '/../include/pagination_count.php');
include(__DIR__ . '/view/layout/main.php');