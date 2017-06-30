<?php

/**
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/include/include.php');

$sql = "SELECT COUNT(`conference_id`) AS `count`
        FROM `conference`
        WHERE `conference_season_id`=$igosja_season_id";
$team_sql = f_igosja_mysqli_query($sql);

$team_array = $team_sql->fetch_all(1);
$count_team = $team_array[0]['count'];

$seo_title          = 'Конференция любительских клубов';
$seo_description    = 'Конференция любительских клубов, календарь игр и турнирная таблица на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'конференция любительских клубов клк';

include(__DIR__ . '/view/layout/main.php');