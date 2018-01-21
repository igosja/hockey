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

$review_array = $review_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_id`,
               `country_name`,
               `news_text`,
               `news_title`,
               `user_id`,
               `user_login`
        FROM `news`
        LEFT JOIN `user`
        ON `news_user_id`=`user_id`
        LEFT JOIN `country`
        ON `news_country_id`=`country_id`
        WHERE `news_country_id`!=0
        ORDER BY `news_id` DESC
        LIMIT 1";
$newscountry_sql = f_igosja_mysqli_query($sql);

$newscountry_array = $newscountry_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `user_birth_year`,
               `user_id`,
               `user_login`,
               `user_name`,
               `user_surname`
        FROM `user`
        WHERE `user_birth_day`=FROM_UNIXTIME(UNIX_TIMESTAMP(), '%e')
        AND `user_birth_month`=FROM_UNIXTIME(UNIX_TIMESTAMP(), '%c')
        AND `user_date_confirm`!=0
        AND `user_date_login`>UNIX_TIMESTAMP()-2592000
        AND `user_id`!=0
        ORDER BY `user_id` ASC";
$birth_sql = f_igosja_mysqli_query($sql);

$birth_array = $birth_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `forumgroup_name`,
               `forumtheme_id`,
               `forumtheme_name`,
               CEIL(`forumtheme_count_message`/20) AS `last_page`
        FROM `forumtheme`
        LEFT JOIN `forumgroup`
        ON `forumtheme_forumgroup_id`=`forumgroup_id`
        WHERE `forumgroup_forumchapter_id`!=4
        ORDER BY `forumtheme_last_date` DESC
        LIMIT 10";
$forum_sql = f_igosja_mysqli_query($sql);

$forum_array = $forum_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = 'Хоккейный онлайн-менеджер';
$seo_description    = 'Виртуальная Хоккейная Лига - лучший бесплатный хоккейный онлайн-менеджер.';

include(__DIR__ . '/view/layout/main.php');