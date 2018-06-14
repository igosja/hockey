<?php

/**
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$season_id = (int) f_igosja_request_get('season_id'))
{
    $season_id = $igosja_season_id;
}

$sql = "SELECT COUNT(`conference_id`) AS `count`
        FROM `conference`
        WHERE `conference_season_id`=$season_id";
$team_sql = f_igosja_mysqli_query($sql);

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);
$count_team = $team_array[0]['count'];

if (0 == $count_team)
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `season_id`
        FROM `conference`
        LEFT JOIN `season`
        ON `conference_season_id`=`season_id`
        GROUP BY `conference_season_id`
        ORDER BY `conference_season_id` DESC";
$season_sql = f_igosja_mysqli_query($sql);

$season_array = $season_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = 'Конференция любительских клубов';
$seo_description    = 'Конференция любительских клубов, календарь игр и турнирная таблица на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'конференция любительских клубов клк';

include(__DIR__ . '/view/layout/main.php');