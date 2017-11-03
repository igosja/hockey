<?php

/**
 * @var $limit integer
 * @var $offset integer
 * @var $sql_filter string
 */

include(__DIR__ . '/../include/include.php');
include(__DIR__ . '/../include/pagination_offset.php');

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `tournamenttype_id`,
               `tournamenttype_name`
        FROM `tournamenttype`
        WHERE $sql_filter
        ORDER BY `tournamenttype_id` ASC
        LIMIT $offset, $limit";
$tournamenttype_sql = f_igosja_mysqli_query($sql);

$tournamenttype_array = $tournamenttype_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = 'Типы турниров';

include(__DIR__ . '/../include/pagination_count.php');
include(__DIR__ . '/view/layout/main.php');