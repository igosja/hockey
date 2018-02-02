<?php

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `forumchapter_name`
        FROM `forumchapter`
        WHERE `forumchapter_id`=$num_get
        LIMIT 1";
$forumchapter_sql = f_igosja_mysqli_query($sql);

if (0 == $forumchapter_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$forumchapter_array = $forumchapter_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `forumgroup_count_message`,
               `forumgroup_count_theme`,
               `forumgroup_description`,
               `forumgroup_id`,
               `forumgroup_name`,
               `forumgroup_last_date`,
               `forumtheme_id`,
               `forumtheme_name`,
               CEIL((`forumtheme_count_message`-1)/20) AS `last_page`,
               `user_id`,
               `user_login`
        FROM `forumgroup`
        LEFT JOIN `forumtheme`
        ON `forumgroup_last_forumtheme_id`=`forumtheme_id`
        LEFT JOIN `user`
        ON `forumgroup_last_user_id`=`user_id`
        WHERE `forumgroup_forumchapter_id`=$num_get
        ORDER BY `forumgroup_order` ASC";
$forumgroup_sql = f_igosja_mysqli_query($sql);

$forumgroup_array = $forumgroup_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = $forumchapter_array[0]['forumchapter_name'] . ' - Форум';
$seo_description    = $forumchapter_array[0]['forumchapter_name'] . ' - Форум сайта Вирутальной Хоккейной Лиги.';
$seo_keywords       = $forumchapter_array[0]['forumchapter_name'] . ' форум';

include(__DIR__ . '/view/layout/main.php');