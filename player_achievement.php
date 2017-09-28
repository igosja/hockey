<?php

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

include(__DIR__ . '/include/sql/player_view.php');

$sql = "SELECT `achievementplayer_season_id`,
               `achievementplayer_position`,
               `tournamenttype_name`
        FROM `achievementplayer`
        LEFT JOIN `tournamenttype`
        ON `achievementplayer_tournamenttype_id`=`tournamenttype_id`
        WHERE `achievementplayer_player_id`=$num_get
        ORDER BY `achievementplayer_id` DESC";
$achievement_sql = f_igosja_mysqli_query($sql, false);

$achievement_array = $achievement_sql->fetch_all(1);

$seo_title          = $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'] . '. Достижения хоккеиста';
$seo_description    = $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'] . '. Достижения хоккеиста на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'] . ' достижения хоккеиста';

include(__DIR__ . '/view/layout/main.php');