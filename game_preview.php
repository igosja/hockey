<?php

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `championship_country_id`,
               `championship_division_id`,
               `game_played`,
               `guest_national`.`national_id` AS `guest_national_id`,
               `guest_country`.`country_name` AS `guest_national_name`,
               `guest_national`.`national_power_vs` AS `guest_national_power_vs`,
               `guest_team`.`team_id` AS `guest_team_id`,
               `guest_team`.`team_name` AS `guest_team_name`,
               `guest_team`.`team_power_vs` AS `guest_team_power_vs`,
               `home_national`.`national_id` AS `home_national_id`,
               `home_country`.`country_name` AS `home_national_name`,
               `home_national`.`national_power_vs` AS `home_national_power_vs`,
               `home_team`.`team_id` AS `home_team_id`,
               `home_team`.`team_name` AS `home_team_name`,
               `home_team`.`team_power_vs` AS `home_team_power_vs`,
               `schedule_date`,
               `schedule_season_id`,
               `stadium_capacity`,
               `stadium_name`,
               `stadium_team`.`team_id` AS `stadium_team_id`,
               `stage_id`,
               `stage_name`,
               `tournamenttype_id`,
               `tournamenttype_name`
        FROM `game`
        LEFT JOIN `team` AS `guest_team`
        ON `game_guest_team_id`=`guest_team`.`team_id`
        LEFT JOIN `national` AS `guest_national`
        ON `game_guest_national_id`=`guest_national`.`national_id`
        LEFT JOIN `country` AS `guest_country`
        ON `guest_national`.`national_country_id`=`guest_country`.`country_id`
        LEFT JOIN `team` AS `home_team`
        ON `game_home_team_id`=`home_team`.`team_id`
        LEFT JOIN `national` AS `home_national`
        ON `game_home_national_id`=`home_national`.`national_id`
        LEFT JOIN `country` AS `home_country`
        ON `home_national`.`national_country_id`=`home_country`.`country_id`
        LEFT JOIN `schedule`
        ON `game_schedule_id`=`schedule_id`
        LEFT JOIN `tournamenttype`
        ON `schedule_tournamenttype_id`=`tournamenttype_id`
        LEFT JOIN `stage`
        ON `schedule_stage_id`=`stage_id`
        LEFT JOIN `stadium`
        ON `game_stadium_id`=`stadium_id`
        LEFT JOIN `team` AS `stadium_team`
        ON `stadium_team`.`team_stadium_id`=`stadium_id`
        LEFT JOIN `championship`
        ON (`game_home_team_id`=`championship_team_id`
        AND `schedule_season_id`=`championship_season_id`)
        WHERE `game_id`=$num_get
        LIMIT 1";
$game_sql = f_igosja_mysqli_query($sql);

if (0 == $game_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

$home_team_id       = (int) $game_array[0]['home_team_id'];
$home_national_id   = (int) $game_array[0]['home_national_id'];
$guest_team_id      = (int) $game_array[0]['guest_team_id'];
$guest_national_id  = (int) $game_array[0]['guest_national_id'];

$sql = "SELECT `game_guest_score`,
               `game_home_score`,
               `game_id`,
               `game_played`,
               `guest_national`.`national_id` AS `guest_national_id`,
               `guest_country`.`country_name` AS `guest_national_name`,
               `guest_team`.`team_id` AS `guest_team_id`,
               `guest_team`.`team_name` AS `guest_team_name`,
               `home_national`.`national_id` AS `home_national_id`,
               `home_country`.`country_name` AS `home_national_name`,
               `home_team`.`team_id` AS `home_team_id`,
               `home_team`.`team_name` AS `home_team_name`,
               `schedule_date`,
               `stage_name`,
               `tournamenttype_name`
        FROM `game`
        LEFT JOIN `schedule`
        ON `game_schedule_id`=`schedule_id`
        LEFT JOIN `tournamenttype`
        ON `schedule_tournamenttype_id`=`tournamenttype_id`
        LEFT JOIN `stage`
        ON `schedule_stage_id`=`stage_id`
        LEFT JOIN `team` AS `guest_team`
        ON `game_guest_team_id`=`guest_team`.`team_id`
        LEFT JOIN `national` AS `guest_national`
        ON `game_guest_national_id`=`guest_national`.`national_id`
        LEFT JOIN `country` AS `guest_country`
        ON `guest_national`.`national_country_id`=`guest_country`.`country_id`
        LEFT JOIN `team` AS `home_team`
        ON `game_home_team_id`=`home_team`.`team_id`
        LEFT JOIN `national` AS `home_national`
        ON `game_home_national_id`=`home_national`.`national_id`
        LEFT JOIN `country` AS `home_country`
        ON `home_national`.`national_country_id`=`home_country`.`country_id`
        WHERE (`game_home_team_id`=$home_team_id
        AND `game_home_national_id`=$home_national_id
        AND `game_guest_team_id`=$guest_team_id
        AND `game_guest_national_id`=$guest_national_id)
        OR (`game_home_team_id`=$guest_team_id
        AND `game_home_national_id`=$guest_national_id
        AND `game_guest_team_id`=$home_team_id
        AND `game_guest_national_id`=$home_national_id)
        ORDER BY `game_id` DESC";
$previous_sql = f_igosja_mysqli_query($sql);

$previous_array = $previous_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = ($game_array[0]['home_team_id'] ? $game_array[0]['home_team_name'] : $game_array[0]['home_national_name']) . ' - ' . ($game_array[0]['guest_team_id'] ? $game_array[0]['guest_team_name'] : $game_array[0]['guest_national_name']) . '. Информация перед началом матча';
$seo_description    = ($game_array[0]['home_team_id'] ? $game_array[0]['home_team_name'] : $game_array[0]['home_national_name']) . ' - ' . ($game_array[0]['guest_team_id'] ? $game_array[0]['guest_team_name'] : $game_array[0]['guest_national_name']) . '. Информация перед началом матча на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = ($game_array[0]['home_team_id'] ? $game_array[0]['home_team_name'] : $game_array[0]['home_national_name']) . ' ' . ($game_array[0]['guest_team_id'] ? $game_array[0]['guest_team_name'] : $game_array[0]['guest_national_name']) . ' информация перед началом матча';

include(__DIR__ . '/view/layout/main.php');