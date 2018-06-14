<?php

/**
 * @var $limit integer
 * @var $offset integer
 * @var $sql_filter string
 */

include(__DIR__ . '/../include/include.php');
include(__DIR__ . '/../include/pagination_offset.php');

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `country_president`.`country_name` AS `president_country_name`,
               `country_vice`.`country_name` AS `vice_country_name`,
               `user_id`,
               `user_login`
        FROM `user`
        LEFT JOIN `country` AS `country_president`
        ON `user_id`=`country_president`.`country_president_id`
        LEFT JOIN `country` AS `country_vice`
        ON `user_id`=`country_vice`.`country_vice_id`
        WHERE $sql_filter
        AND (`country_president`.`country_president_id`!=0
        OR `country_vice`.`country_vice_id`!=0)
        ORDER BY IFNULL(`country_president`.`country_id`, `country_vice`.`country_id`) ASC
        LIMIT $offset, $limit";
$user_sql = f_igosja_mysqli_query($sql);

$user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = 'Пользователи';

include(__DIR__ . '/../include/pagination_count.php');
include(__DIR__ . '/view/layout/main.php');