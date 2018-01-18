<?php

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

include(__DIR__ . '/include/sql/player_view.php');

$sql = "SELECT `game_id`,
               `game_home_score`,
               `game_guest_score`,
               `guest_team`.`team_id` AS `guest_team_id`,
               `guest_team`.`team_name` AS `guest_team_name`,
               `home_team`.`team_id` AS `home_team_id`,
               `home_team`.`team_name` AS `home_team_name`,
               `lineup_assist`,
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
        LEFT JOIN `team` AS `home_team`
        ON `game_home_team_id`=`home_team`.`team_id`
        LEFT JOIN `team` AS `guest_team`
        ON `game_guest_team_id`=`guest_team`.`team_id`
        WHERE `lineup_player_id`=$num_get
        AND `game_played`=1
        ORDER BY `schedule_id` DESC";
$game_sql = f_igosja_mysqli_query($sql);

$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'] . '. Профиль хоккеиста';
$seo_description    = $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'] . '. Профиль хоккеиста на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'] . ' профиль хоккеиста';

include(__DIR__ . '/view/layout/main.php');