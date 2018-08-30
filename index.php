<?php

include(__DIR__ . '/include/include.php');

if ($num_get = (int) f_igosja_request_get('num'))
{
    setcookie('user_referrer_id', $num_get, time() + 31536000); //365 днів

    redirect('/');
}

$sql = "SELECT `news_text`,
               `news_title`,
               `user_id`,
               `user_login`
        FROM `news`
        LEFT JOIN `user`
        ON `news_user_id`=`user_id`
        WHERE `news_country_id`=0
        ORDER BY `news_id` DESC
        LIMIT 1";
$news_sql = f_igosja_mysqli_query($sql);

$news_array = $news_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_name`,
               `division_name`,
               `review_id`,
               `review_title`,
               `stage_name`,
               `user_id`,
               `user_login`
        FROM `review`
        LEFT JOIN `country`
        ON `review_country_id`=`country_id`
        LEFT JOIN `division`
        ON `review_division_id`=`division_id`
        LEFT JOIN `stage`
        ON `review_stage_id`=`stage_id`
        LEFT JOIN `user`
        ON `review_user_id`=`user_id`
        ORDER BY `review_id` DESC
        LIMIT 10";
$review_sql = f_igosja_mysqli_query($sql);
