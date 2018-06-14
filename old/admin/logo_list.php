<?php

/**
 * @var $limit integer
 * @var $offset integer
 * @var $sql_filter string
 */

include(__DIR__ . '/../include/include.php');
include(__DIR__ . '/../include/pagination_offset.php');

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `logo_id`,
               `logo_date`,
               `team_id`,
               `team_name`,
               `user_id`,
               `user_login`
        FROM `logo`
        LEFT JOIN `team`
        ON `logo_team_id`=`team_id`
        LEFT JOIN `user`
        ON `logo_user_id`=`user_id`
        WHERE $sql_filter
        ORDER BY `logo_date` ASC
        LIMIT $offset, $limit";
$logo_sql = f_igosja_mysqli_query($sql);

$logo_array = $logo_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = 'Логотипы команд';

include(__DIR__ . '/../include/pagination_count.php');
include(__DIR__ . '/view/layout/main.php');