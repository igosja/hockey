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
        ORDER BY `forumchapter_id` ASC";
$forumchapter_sql = f_igosja_mysqli_query($sql);

$forumchapter_array = $forumchapter_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `forumchapter_id`,
               `forumchapter_name`,
               `forumgroup_id`,
               `forumgroup_name`
        FROM `forumgroup`
        LEFT JOIN `forumchapter`
        ON `forumgroup_forumchapter_id`=`forumchapter_id`
        WHERE $sql_filter
        ORDER BY `forumgroup_id` ASC
        LIMIT $offset, $limit";
$forumgroup_sql = f_igosja_mysqli_query($sql);

$forumgroup_array = $forumgroup_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = 'Группы';

include(__DIR__ . '/../include/pagination_count.php');
include(__DIR__ . '/view/layout/main.php');