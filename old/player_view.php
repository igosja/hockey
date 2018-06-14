<?php

/**
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

include(__DIR__ . '/include/sql/player_view.php');

if (!$season_id = (int) f_igosja_request_get('season_id'))
{
    $season_id = $igosja_season_id;
}

if ($season_id > $igosja_season_id)
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `season_id`
        FROM `season`
        ORDER BY `season_id` DESC";
$season_sql = f_igosja_mysqli_query($sql);

$season_array = $season_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `game_id`,
               `game_home_score`,
               `game_guest_score`,
               `guest_city`.`city_name` AS `guest_city_name`,
               `guest_country`.`country_name` AS `guest_country_name`,
               `guest_national_country`.`country_name` AS `guest_national_name`,
               `guest_national`.`national_id` AS `guest_national_id`,
               `guest_nationaltype`.`nationaltype_name` AS `guest_nationaltype_name`,
               `guest_team`.`team_id` AS `guest_team_id`,
               `guest_team`.`team_name` AS `guest_team_name`,
               `home_city`.`city_name` AS `home_city_name`,
               `home_country`.`country_name` AS `home_country_name`,
               `home_national_country`.`country_name` AS `home_national_name`,
               `home_national`.`national_id` AS `home_national_id`,
               `home_nationaltype`.`nationaltype_name` AS `home_nationaltype_name`,
               `home_team`.`team_id` AS `home_team_id`,
               `home_team`.`team_name` AS `home_team_name`,
               `lineup_assist`,
               `lineup_plus_minus`,
               `lineup_power_change`,
               `lineup_power_real`,
               `lineup_score`,
               `position_short`,
               `schedule_date`,
               `stage_name`,
               `tournamenttype_name`
        FROM `lineup`
        LEFT JOIN `game`
        ON `lineup_game_id`=`game_id`
        LEFT JOIN `schedule`
        ON `game_schedule_id`=`schedule_id`
        LEFT JOIN `tournamenttype`
        ON `schedule_tournamenttype_id`=`tournamenttype_id`
        LEFT JOIN `stage`
        ON `schedule_stage_id`=`stage_id`
        LEFT JOIN `position`
        ON `lineup_position_id`=`position_id`
        LEFT JOIN `team` AS `guest_team`
        ON `game_guest_team_id`=`guest_team`.`team_id`
        LEFT JOIN `stadium` AS `guest_stadium`
        ON `guest_team`.`team_stadium_id`=`guest_stadium`.`stadium_id`
        LEFT JOIN `city` AS `guest_city`
        ON `guest_stadium`.`stadium_city_id`=`guest_city`.`city_id`
        LEFT JOIN `country` AS `guest_country`
        ON `guest_city`.`city_country_id`=`guest_country`.`country_id`
        LEFT JOIN `national` AS `guest_national`
        ON `game_guest_national_id`=`guest_national`.`national_id`
        LEFT JOIN `nationaltype` AS `guest_nationaltype`
        ON `guest_national`.`national_nationaltype_id`=`guest_nationaltype`.`nationaltype_id`
        LEFT JOIN `country` AS `guest_national_country`
        ON `guest_national`.`national_country_id`=`guest_national_country`.`country_id`
        LEFT JOIN `team` AS `home_team`
        ON `game_home_team_id`=`home_team`.`team_id`
        LEFT JOIN `stadium` AS `home_stadium`
        ON `home_team`.`team_stadium_id`=`home_stadium`.`stadium_id`
        LEFT JOIN `city` AS `home_city`
        ON `home_stadium`.`stadium_city_id`=`home_city`.`city_id`
        LEFT JOIN `country` AS `home_country`
        ON `home_city`.`city_country_id`=`home_country`.`country_id`
        LEFT JOIN `national` AS `home_national`
        ON `game_home_national_id`=`home_national`.`national_id`
        LEFT JOIN `nationaltype` AS `home_nationaltype`
        ON `home_national`.`national_nationaltype_id`=`home_nationaltype`.`nationaltype_id`
        LEFT JOIN `country` AS `home_national_country`
        ON `home_national`.`national_country_id`=`home_national_country`.`country_id`
        WHERE `lineup_player_id`=$num_get
        AND `schedule_season_id`=$season_id
        AND `game_played`=1
        ORDER BY `schedule_id` DESC";
$game_sql = f_igosja_mysqli_query($sql);

$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'] . '. Профиль хоккеиста';
$seo_description    = $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'] . '. Профиль хоккеиста на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'] . ' профиль хоккеиста';

include(__DIR__ . '/view/layout/main.php');