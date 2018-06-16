<?php

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `forumchapter_id`,
               `forumchapter_name`,
               `forumgroup_name`
        FROM `forumgroup`
        LEFT JOIN `forumchapter`
        ON `forumgroup_forumchapter_id`=`forumchapter_id`
        WHERE `forumgroup_id`=$num_get
        LIMIT 1";
$forumgroup_sql = f_igosja_mysqli_query($sql);

if (0 == $forumgroup_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$forumgroup_array = $forumgroup_sql->fetch_all(MYSQLI_ASSOC);

if (!$page = (int) f_igosja_request_get('page'))
{
    $page = 1;
}

$limit  = 20;
$offset = ($page - 1) * $limit;

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `author`.`user_id` AS `author_id`,
               `author`.`user_login` AS `author_login`,
               `forumtheme_count_message`,
               `forumtheme_count_view`,
               `forumtheme_date`,
               `forumtheme_id`,
               `forumtheme_last_date`,
               `forumtheme_name`,
               CEIL((`forumtheme_count_message`-1)/20) AS `last_page`,
               `lastuser`.`user_id` AS `lastuser_id`,
               `lastuser`.`user_login` AS `lastuser_login`
        FROM `forumtheme`
        LEFT JOIN `user` AS `author`
        ON `forumtheme_user_id`=`author`.`user_id`
        LEFT JOIN `user` AS `lastuser`
        ON `forumtheme_last_user_id`=`lastuser`.`user_id`
        WHERE `forumtheme_forumgroup_id`=$num_get
        ORDER BY `forumtheme_last_date` DESC
        LIMIT $offset, $limit";
$forumtheme_sql = f_igosja_mysqli_query($sql);

$forumtheme_array = $forumtheme_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT FOUND_ROWS() AS `count`";
$total = f_igosja_mysqli_query($sql);
$total = $total->fetch_all(MYSQLI_ASSOC);
$total = $total[0]['count'];

$count_page = ceil($total / $limit);

$seo_title          = $forumgroup_array[0]['forumgroup_name'] . ' - Форум';
$seo_description    = $forumgroup_array[0]['forumgroup_name'] . ' - Форум сайта Вирутальной Хоккейной Лиги.';
$seo_keywords       = $forumgroup_array[0]['forumgroup_name'] . ' форум';

include(__DIR__ . '/view/layout/main.php');