<?php

include(__DIR__ . '/include/include.php');

if (!$page = (int) f_igosja_request_get('page'))
{
    $page = 1;
}

$limit  = 10;
$offset = ($page - 1) * $limit;

$sql = "SELECT SQL_CALC_FOUND_ROWS
               IF(`count_newscomment`, `count_newscomment`, 0) AS `count_newscomment`,
               `news_date`,
               `news_id`,
               `news_text`,
               `news_title`,
               `user_id`,
               `user_login`
        FROM `news`
        LEFT JOIN `user`
        ON `news_user_id`=`user_id`
        LEFT JOIN
        (
            SELECT COUNT(`newscomment_id`) AS `count_newscomment`,
                   `newscomment_news_id`
            FROM `newscomment`
            GROUP BY `newscomment_news_id`
        ) AS `t1`
        ON `news_id`=`newscomment_news_id`
        WHERE `news_country_id`=0
        ORDER BY `news_id` DESC
        LIMIT $offset, $limit";
$news_sql = f_igosja_mysqli_query($sql, false);

$news_array = $news_sql->fetch_all(1);

$sql = "SELECT FOUND_ROWS() AS `count`";
$total = f_igosja_mysqli_query($sql, false);
$total = $total->fetch_all(1);
$total = $total[0]['count'];

$count_page = ceil($total / $limit);

$seo_title          = 'Новости сайта';
$seo_description    = 'Новости на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'новости сайта';

include(__DIR__ . '/view/layout/main.php');