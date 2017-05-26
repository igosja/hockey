<?php

include(__DIR__ . '/include/include.php');

$sql = "SELECT IF(`count_newscomment`, `count_newscomment`, 0) AS `count_newscomment`,
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
        AND `news_country_id`=0
        ORDER BY `news_id` DESC";
$news_sql = f_igosja_mysqli_query($sql);

$news_array = $news_sql->fetch_all(1);

include(__DIR__ . '/view/layout/main.php');