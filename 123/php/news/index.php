<?php

$sql = "SELECT `news_id`,
               `news_date`,
               `news_text`,
               `news_title`,
               `user_id`,
               `user_login`
        FROM `news`
        LEFT JOIN `user`
        ON `news_user_id`=`user_id`
        ORDER BY `news_id` DESC";
$news_sql = igosja_db_query($sql);

$news_array = $news_sql->fetch_all(1);