<?php

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `forumgroup_name`
        FROM `forumgroup`
        WHERE `forumgroup_id`=$num_get
        LIMIT 1";
$forumgroup_sql = f_igosja_mysqli_query($sql);

if (0 == $forumgroup_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$forumgroup_array = $forumgroup_sql->fetch_all(1);

$sql = "SELECT `author`.`user_id` AS `author_id`,
               `author`.`user_login` AS `author_login`,
               `forumtheme_count_message`,
               `forumtheme_count_view`,
               `forumtheme_date`,
               `forumtheme_id`,
               `forumtheme_last_date`,
               `forumtheme_name`,
               `lastuser`.`user_id` AS `lastuser_id`,
               `lastuser`.`user_login` AS `lastuser_login`
        FROM `forumtheme`
        LEFT JOIN `user` AS `author`
        ON `forumtheme_user_id`=`author`.`user_id`
        LEFT JOIN `user` AS `lastuser`
        ON `forumtheme_last_user_id`=`lastuser`.`user_id`
        WHERE `forumtheme_forumgroup_id`=$num_get
        ORDER BY `forumtheme_last_date` DESC";
$forumtheme_sql = f_igosja_mysqli_query($sql);

$forumtheme_array = $forumtheme_sql->fetch_all(1);

$seo_title          = $forumgroup_array[0]['forumgroup_name'] . ' - Форум';
$seo_description    = $forumgroup_array[0]['forumgroup_name'] . ' - Форум сайта Вирутальной Хоккейной Лиги.';
$seo_keywords       = $forumgroup_array[0]['forumgroup_name'] . ' форум';

include(__DIR__ . '/view/layout/main.php');