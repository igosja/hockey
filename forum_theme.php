<?php

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `forumtheme_name`
        FROM `forumtheme`
        WHERE `forumtheme_id`=$num_get
        LIMIT 1";
$forumtheme_sql = f_igosja_mysqli_query($sql);

if (0 == $forumtheme_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$forumtheme_array = $forumtheme_sql->fetch_all(1);

$sql = "SELECT `forummessage_date`,
               `forummessage_text`,
               `user_id`,
               `user_login`
        FROM `forummessage`
        LEFT JOIN `user`
        ON `forummessage_user_id`=`user_id`
        WHERE `forummessage_forumtheme_id`=$num_get
        ORDER BY `forummessage_id` ASC";
$forummessage_sql = f_igosja_mysqli_query($sql);

$forummessage_array = $forummessage_sql->fetch_all(1);

$seo_title          = $forumtheme_array[0]['forumtheme_name'] . ' - Форум';
$seo_description    = $forumtheme_array[0]['forumtheme_name'] . ' - Форум сайта Вирутальной Хоккейной Лиги.';
$seo_keywords       = $forumtheme_array[0]['forumtheme_name'] . ' форум';

include(__DIR__ . '/view/layout/main.php');