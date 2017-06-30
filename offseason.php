<?php

include(__DIR__ . '/include/include.php');

$sql = "SELECT COUNT(`offseason_id`) AS `count`
        FROM `offseason`
        WHERE `offseason_season_id`=$igosja_season_id";
$team_sql = f_igosja_mysqli_query($sql);

$team_array = $team_sql->fetch_all(1);
$count_team = $team_array[0]['count'];

$seo_title          = 'Кубок межсезонья';
$seo_description    = 'Кубок межсезонья, календарь игр и турнирная таблица на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'кубок межсезонья клк';

include(__DIR__ . '/view/layout/main.php');