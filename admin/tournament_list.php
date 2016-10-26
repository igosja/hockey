<?php

include (__DIR__ . '/../include/include.php');
include (__DIR__ . '/../include/pagination_offset.php');

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `tournament_id`,
               `tournament_name`,
               `tournamenttype_id`,
               `tournamenttype_name`
        FROM `tournament`
        LEFT JOIN `tournamenttype`
        ON `tournament_tournamenttype_id`=`tournamenttype_id`
        WHERE $sql_filter
        ORDER BY `tournamenttype_id` ASC, `tournament_id` ASC
        LIMIT $offset, $limit";
$tournament_sql = igosja_db_query($sql);

$tournament_array = $tournament_sql->fetch_all(1);

$sql = "SELECT `tournamenttype_id`,
               `tournamenttype_name`
        FROM `tournamenttype`
        ORDER BY `tournamenttype_id` ASC";
$tournamenttype_sql = igosja_db_query($sql);

$tournamenttype_array = $tournamenttype_sql->fetch_all(1);

$breadcrumb_array[] = 'Турниры';

include (__DIR__ . '/../include/pagination_count.php');
include (__DIR__ . '/view/layout/main.php');