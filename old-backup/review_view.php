<?php

/**
 * @var $auth_user_id integer
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `country_id`,
               `country_name`,
               `division_id`,
               `division_name`,
               `review_date`,
               `review_season_id`,
               `review_text`,
               `review_title`,
               `stage_id`,
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
        WHERE `review_id`=$num_get
        LIMIT 1";
$review_sql = f_igosja_mysqli_query($sql);

if (0 == $review_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$review_array = $review_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = 'Обзор национального чемпионата';
$seo_description    = 'Обзор национального чемпионата на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'обзор национального чемпионата';

include(__DIR__ . '/view/layout/main.php');