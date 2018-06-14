<?php

/**
 * @var $auth_user_id integer
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    if (!isset($auth_user_id))
    {
        redirect('/wrong_page.php');
    }

    $num_get = $auth_user_id;
}

include(__DIR__ . '/include/sql/user_view.php');

$sql = "SELECT `achievement_season_id`,
               `achievement_position`,
               `city_name`,
               `tournament_country`.`country_id` AS `country_id`,
               `tournament_country`.`country_name` AS `country_name`,
               `division_id`,
               `division_name`,
               `stage_name`,
               `team_country`.`country_id` AS `team_country_id`,
               `team_country`.`country_name` AS `team_country_name`,
               `team_id`,
               `team_name`,
               `tournamenttype_id`,
               `tournamenttype_name`
        FROM `achievement`
        LEFT JOIN `tournamenttype`
        ON `achievement_tournamenttype_id`=`tournamenttype_id`
        LEFT JOIN `team`
        ON `achievement_team_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country` AS `team_country`
        ON `city_country_id`=`team_country`.`country_id`
        LEFT JOIN `division`
        ON `achievement_division_id`=`division_id`
        LEFT JOIN `country` AS `tournament_country`
        ON `achievement_country_id`=`tournament_country`.`country_id`
        LEFT JOIN `stage`
        ON `achievement_stage_id`=`stage_id`
        WHERE `achievement_user_id`=$num_get
        ORDER BY `achievement_id` DESC";
$achievement_sql = f_igosja_mysqli_query($sql);

$achievement_array = $achievement_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = $user_array[0]['user_login'] . '. Достижения менеджера';
$seo_description    = $user_array[0]['user_login'] . '. Достижения менеджера на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $user_array[0]['user_login'] . ' достижения менеджера';

include(__DIR__ . '/view/layout/main.php');