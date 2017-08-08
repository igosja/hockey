<?php

/**
 * @var $auth_national_id integer
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    if (!isset($auth_national_id))
    {
        redirect('/wrong_page.php');
    }

    if (0 == $auth_national_id)
    {
        redirect('/wrong_page.php');
    }

    $num_get = $auth_national_id;
}

include(__DIR__ . '/include/sql/national_view_left.php');
include(__DIR__ . '/include/sql/national_view_right.php');

$sql = "SELECT `country_name`,
               IF(`game_guest_national_id`=$num_get, `game_guest_auto`, `game_home_auto`) AS `game_auto`,
               `game_guest_score`,
               `game_home_score`,
               `game_id`,
               IF(`game_guest_national_id`=$num_get, `game_guest_plus_minus`, `game_home_plus_minus`) AS `game_minus`,
               `game_played`,
               IF(`game_guest_national_id`=$num_get, `game_guest_plus_minus`, `game_home_plus_minus`) AS `game_plus`,
               IF(
                   `game_played`=1,
                   100,
                   IF(
                       `game_guest_national_id`=$num_get,
                       ROUND(`game_home_power`/`game_guest_power`*100),
                       ROUND(`game_guest_power`/`game_home_power`*100)
                   )
               ) AS `power_percent`,
               `shedule_date`,
               `stage_name`,
               `opponent`.`national_id` AS `national_id`,
               `tournamenttype_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `game_shedule_id`=`shedule_id`
        LEFT JOIN `tournamenttype`
        ON `shedule_tournamenttype_id`=`tournamenttype_id`
        LEFT JOIN `stage`
        ON `shedule_stage_id`=`stage_id`
        LEFT JOIN `national` AS `opponent`
        ON IF(`game_guest_national_id`=$num_get, `game_home_national_id`, `game_guest_national_id`)=`opponent`.`national_id`
        LEFT JOIN `national` AS `my_national`
        ON IF(`game_guest_national_id`=$num_get, `game_guest_national_id`, `game_home_national_id`)=`my_national`.`national_id`
        LEFT JOIN `country`
        ON `opponent`.`national_country_id`=`country_id`
        WHERE (`game_guest_national_id`=$num_get
        OR `game_home_national_id`=$num_get)
        AND `shedule_season_id`=$igosja_season_id
        ORDER BY `shedule_id` ASC";
$game_sql = f_igosja_mysqli_query($sql);

$game_array = $game_sql->fetch_all(1);

$seo_title          = $national_array[0]['country_name'] . '. Матчи команды';
$seo_description    = $national_array[0]['country_name'] . '. Матчи команды на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $national_array[0]['country_name'] . ' матчи команды';

include(__DIR__ . '/view/layout/main.php');