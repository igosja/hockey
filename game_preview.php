<?php

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `game_played`,
               `guest_team`.`team_id` AS `guest_team_id`,
               `guest_team`.`team_name` AS `guest_team_name`,
               `guest_team`.`team_power_vs` AS `guest_team_power_vs`,
               `home_team`.`team_id` AS `home_team_id`,
               `home_team`.`team_name` AS `home_team_name`,
               `home_team`.`team_power_vs` AS `home_team_power_vs`,
               `shedule_date`,
               `stadium_capacity`,
               `stadium_name`,
               `stadium_team`.`team_id` AS `stadium_team_id`,
               `stage_name`,
               `tournamenttype_name`
        FROM `game`
        LEFT JOIN `team` AS `guest_team`
        ON `game_guest_team_id`=`guest_team`.`team_id`
        LEFT JOIN `team` AS `home_team`
        ON `game_home_team_id`=`home_team`.`team_id`
        LEFT JOIN `shedule`
        ON `game_shedule_id`=`shedule_id`
        LEFT JOIN `tournamenttype`
        ON `shedule_tournamenttype_id`=`tournamenttype_id`
        LEFT JOIN `stage`
        ON `shedule_stage_id`=`stage_id`
        LEFT JOIN `stadium`
        ON `game_stadium_id`=`stadium_id`
        LEFT JOIN `team` AS `stadium_team`
        ON `stadium_team`.`team_stadium_id`=`stadium_id`
        WHERE `game_id`=$num_get
        LIMIT 1";
$game_sql = f_igosja_mysqli_query($sql);

if (0 == $game_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$game_array = $game_sql->fetch_all(1);

$home_team_id   = $game_array[0]['home_team_id'];
$guest_team_id  = $game_array[0]['guest_team_id'];

$sql = "SELECT `game_guest_score`,
               `game_home_score`,
               `game_id`,
               `game_played`,
               `guest_team`.`team_id` AS `guest_team_id`,
               `guest_team`.`team_name` AS `guest_team_name`,
               `home_team`.`team_id` AS `home_team_id`,
               `home_team`.`team_name` AS `home_team_name`,
               `shedule_date`,
               `stage_name`,
               `tournamenttype_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `game_shedule_id`=`shedule_id`
        LEFT JOIN `tournamenttype`
        ON `shedule_tournamenttype_id`=`tournamenttype_id`
        LEFT JOIN `stage`
        ON `shedule_stage_id`=`stage_id`
        LEFT JOIN `team` AS `guest_team`
        ON `game_guest_team_id`=`guest_team`.`team_id`
        LEFT JOIN `team` AS `home_team`
        ON `game_home_team_id`=`home_team`.`team_id`
        WHERE (`game_home_team_id`=$home_team_id
        AND `game_guest_team_id`=$guest_team_id)
        OR (`game_home_team_id`=$guest_team_id
        AND `game_guest_team_id`=$home_team_id)
        ORDER BY `game_id` DESC";
$previous_sql = f_igosja_mysqli_query($sql);

$previous_array = $previous_sql->fetch_all(1);

$seo_title          = 'Информация перед началом матча';
$seo_description    = 'Информация перед началом матча на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'информация перед началом матча';

include(__DIR__ . '/view/layout/main.php');