<?php

/**
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$season_id = (int) f_igosja_request_get('season_id'))
{
    $season_id = $igosja_season_id;
}

$sql = "SELECT COUNT(`offseason_id`) AS `count`
        FROM `offseason`
        WHERE `offseason_season_id`=$season_id";
$team_sql = f_igosja_mysqli_query($sql, false);

$team_array = $team_sql->fetch_all(1);
$count_team = $team_array[0]['count'];

if (0 == $count_team)
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `season_id`
        FROM `offseason`
        LEFT JOIN `season`
        ON `offseason_season_id`=`season_id`
        GROUP BY `offseason_season_id`
        ORDER BY `offseason_season_id` DESC";
$season_sql = f_igosja_mysqli_query($sql, false);

$season_array = $season_sql->fetch_all(1);

$seo_title          = 'Кубок межсезонья';
$seo_description    = 'Кубок межсезонья, календарь игр и турнирная таблица на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'кубок межсезонья';

include(__DIR__ . '/view/layout/main.php');