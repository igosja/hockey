<?php

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `shedule_date`,
               `shedule_season_id`,
               `stage_name`,
               `tournamenttype_name`
        FROM `shedule`
        LEFT JOIN `tournamenttype`
        ON `shedule_tournamenttype_id`=`tournamenttype_id`
        LEFT JOIN `stage`
        ON `shedule_stage_id`=`stage_id`
        WHERE `shedule_id`=$num_get
        LIMIT 1";
$shedule_sql = f_igosja_mysqli_query($sql);

if (0 == $shedule_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$shedule_array = $shedule_sql->fetch_all(1);

$sql = "SELECT `game_id`,
               `game_guest_auto`,
               `game_guest_score`,
               `game_home_auto`,
               `game_home_score`,
               `guest_city`.`city_name` AS `guest_city_name`,
               `guest_country`.`country_name` AS `guest_country_name`,
               `guest_team`.`team_id` AS `guest_team_id`,
               `guest_team`.`team_name` AS `guest_team_name`,
               `home_city`.`city_name` AS `home_city_name`,
               `home_country`.`country_name` AS `home_country_name`,
               `home_team`.`team_id` AS `home_team_id`,
               `home_team`.`team_name` AS `home_team_name`,
               `game_played`
        FROM `game`
        LEFT JOIN `shedule`
        ON `game_shedule_id`=`shedule_id`
        LEFT JOIN `team` AS `guest_team`
        ON `game_guest_team_id`=`guest_team`.`team_id`
        LEFT JOIN `stadium` AS `guest_stadium`
        ON `guest_team`.`team_stadium_id`=`guest_stadium`.`stadium_id`
        LEFT JOIN `city` AS `guest_city`
        ON `guest_stadium`.`stadium_city_id`=`guest_city`.`city_id`
        LEFT JOIN `country` AS `guest_country`
        ON `guest_city`.`city_country_id`=`guest_country`.`country_id`
        LEFT JOIN `team` AS `home_team`
        ON `game_home_team_id`=`home_team`.`team_id`
        LEFT JOIN `stadium` AS `home_stadium`
        ON `home_team`.`team_stadium_id`=`home_stadium`.`stadium_id`
        LEFT JOIN `city` AS `home_city`
        ON `home_stadium`.`stadium_city_id`=`home_city`.`city_id`
        LEFT JOIN `country` AS `home_country`
        ON `home_city`.`city_country_id`=`home_country`.`country_id`
        WHERE `shedule_id`=$num_get
        ORDER BY `game_id`ASC";
$game_sql = f_igosja_mysqli_query($sql);

$game_array = $game_sql->fetch_all(1);

$seo_title          = f_igosja_ufu_date($shedule_array[0]['shedule_date']) . '. Список матчей игрового дня';
$seo_description    = f_igosja_ufu_date($shedule_array[0]['shedule_date']) . '. Список матчей игрового дня на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = f_igosja_ufu_date($shedule_array[0]['shedule_date']) . ' список матчей игрового дня';

include(__DIR__ . '/view/layout/main.php');