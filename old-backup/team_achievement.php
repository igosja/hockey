<?php

/**
 * @var $auth_team_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    if (!isset($auth_team_id))
    {
        redirect('/wrong_page.php');
    }

    if (0 == $auth_team_id)
    {
        redirect('/team_ask.php');
    }

    $num_get = $auth_team_id;
}

include(__DIR__ . '/include/sql/team_view_left.php');
include(__DIR__ . '/include/sql/team_view_right.php');

$sql = "SELECT `achievement_position`,
               `achievement_season_id`,
               `country_id`,
               `country_name`,
               `division_id`,
               `division_name`,
               `stage_name`,
               `tournamenttype_id`,
               `tournamenttype_name`
        FROM `achievement`
        LEFT JOIN `tournamenttype`
        ON `achievement_tournamenttype_id`=`tournamenttype_id`
        LEFT JOIN `division`
        ON `achievement_division_id`=`division_id`
        LEFT JOIN `country`
        ON `achievement_country_id`=`country_id`
        LEFT JOIN `stage`
        ON `achievement_stage_id`=`stage_id`
        WHERE `achievement_team_id`=$num_get
        ORDER BY `achievement_id` DESC";
$achievement_sql = f_igosja_mysqli_query($sql);

$achievement_array = $achievement_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = $team_array[0]['team_name'] . '. Достижения команды';
$seo_description    = $team_array[0]['team_name'] . '. Достижения команды на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $team_array[0]['team_name'] . ' достижения команды';

include(__DIR__ . '/view/layout/main.php');