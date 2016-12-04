<?php

include (__DIR__ . '/include/include.php');

$sql = "SELECT `news_date`,
               `news_text`,
               `news_title`,
               `user_id`,
               `user_login`
        FROM `news`
        LEFT JOIN `user`
        ON `news_user_id`=`user_id`
        WHERE `news_country_id`='0'
        ORDER BY `news_id` DESC
        LIMIT 1";
$news_sql = f_igosja_mysqli_query($sql);

$news_array = $news_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');