<?php

/**
 * @var $limit integer
 * @var $offset integer
 * @var $sql_filter string
 */

include(__DIR__ . '/../include/include.php');
include(__DIR__ . '/../include/pagination_offset.php');

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `news_id`,
               `news_date`,
               `news_title`
        FROM `news`
        WHERE $sql_filter
        AND `news_country_id`=0
        ORDER BY `news_id` DESC
        LIMIT $offset, $limit";
$news_sql = f_igosja_mysqli_query($sql);

$news_array = $news_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = 'Новости';

include(__DIR__ . '/../include/pagination_count.php');
include(__DIR__ . '/view/layout/main.php');