<?php

/**
 * @var $limit integer
 * @var $offset integer
 * @var $sql_filter string
 */

include(__DIR__ . '/../include/include.php');
include(__DIR__ . '/../include/pagination_offset.php');

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `team_id`,
               `team_name`,
               `teamask_id`,
               `teamask_date`,
               `user_id`,
               `user_login`
        FROM `teamask`
        LEFT JOIN `team`
        ON `teamask_team_id`=`team_id`
        LEFT JOIN `user`
        ON `teamask_user_id`=`user_id`
        LEFT JOIN
        (
            SELECT COUNT(`history_id`) AS `count_history`,
                   `history_user_id`
            FROM `history`
            WHERE `history_historytext_id`=" . HISTORYTEXT_USER_MANAGER_TEAM_IN . "
            AND `history_user_id` IN
            (
                SELECT `teamask_user_id`
                FROM `teamask`
            )
            GROUP BY `history_user_id`
        ) AS `t1`
        ON `user_id`=`history_user_id`
        WHERE $sql_filter
        AND `teamask_date`<UNIX_TIMESTAMP()-CEIL(IFNULL(`count_history`, 0)/5)-IFNULL(`count_history`, 0)*3600
        ORDER BY IFNULL(`count_history`, 0) ASC, `teamask_date` ASC
        LIMIT $offset, $limit";
$teamask_sql = f_igosja_mysqli_query($sql);

$teamask_array = $teamask_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = 'Заявки на команды';

include(__DIR__ . '/../include/pagination_count.php');
include(__DIR__ . '/view/layout/main.php');