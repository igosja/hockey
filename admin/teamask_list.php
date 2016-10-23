<?php

include (__DIR__ . '/../include/include.php');
include (__DIR__ . '/../include/pagination_offset.php');

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `team_id`,
               `team_name`,
               `teamask_id`,
               `teamask_date`,
               `user_id`,
               `user_login`
        FROM `teamask`
        LEFT JOIN `team`
        ON `teamask_team_id`
        LEFT JOIN `user`
        ON `teamask_user_id`=`user_id`
        WHERE $sql_filter
        ORDER BY `teamask_date` ASC
        LIMIT $offset, $limit";
$teamask_sql = igosja_db_query($sql);

$teamask_array = $teamask_sql->fetch_all(1);

$breadcrumb_array[] = 'Заявки на команды';

include (__DIR__ . '/../include/pagination_count.php');
include (__DIR__ . '/view/layout/main.php');