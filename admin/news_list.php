<?php

include (__DIR__ . '/../include/include.php');
include (__DIR__ . '/../include/pagination_offset.php');

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `news_id`,
               `news_date`,
               `news_title`
        FROM `news`
        WHERE $sql_filter
        ORDER BY `news_id`
        LIMIT $offset, $limit";
$news_sql = f_igosja_mysqli_query($sql);

$news_array = $news_sql->fetch_all(1);

$breadcrumb_array[] = 'Новости';

include (__DIR__ . '/../include/pagination_count.php');
include (__DIR__ . '/view/layout/main.php');