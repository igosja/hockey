<?php

/**
 * @var $limit integer
 * @var $offset integer
 * @var $sql_filter string
 */

include(__DIR__ . '/../include/include.php');
include(__DIR__ . '/../include/pagination_offset.php');

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `country_coach`.`country_name` AS `coach_country_name`,
               `nationaltype_coach`.`nationaltype_name` AS `coach_nationaltype_name`,
               `country_vice`.`country_name` AS `vice_country_name`,
               `nationaltype_vice`.`nationaltype_name` AS `vice_nationaltype_name`,
               `user_id`,
               `user_login`
        FROM `user`
        LEFT JOIN `national` AS `national_coach`
        ON `user_id`=`national_coach`.`national_user_id`
        LEFT JOIN `nationaltype` AS `nationaltype_coach`
        ON `national_coach`.`national_nationaltype_id`=`nationaltype_coach`.`nationaltype_id`
        LEFT JOIN `country` AS `country_coach`
        ON `national_coach`.`national_country_id`=`country_coach`.`country_id`
        LEFT JOIN `national` AS `national_vice`
        ON `user_id`=`national_vice`.`national_vice_id`
        LEFT JOIN `nationaltype` AS `nationaltype_vice`
        ON `national_vice`.`national_nationaltype_id`=`nationaltype_vice`.`nationaltype_id`
        LEFT JOIN `country` AS `country_vice`
        ON `national_vice`.`national_country_id`=`country_vice`.`country_id`
        WHERE $sql_filter
        AND (`national_coach`.`national_user_id`!=0
        OR `national_vice`.`national_vice_id`!=0)
        ORDER BY IFNULL(`country_coach`.`country_id`, `country_vice`.`country_id`) ASC
        LIMIT $offset, $limit";
$user_sql = f_igosja_mysqli_query($sql);

$user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = 'Пользователи';

include(__DIR__ . '/../include/pagination_count.php');
include(__DIR__ . '/view/layout/main.php');