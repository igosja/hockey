<?php

/**
 * @var $auth_date_vip integer
 * @var $auth_team_id integer
 * @var $auth_user_id integer
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/include/include.php');

$schedule_id = 120;

$sql = "SELECT `conference_team_id`,
               `stadium_id`
        FROM `conference`
        LEFT JOIN `team`
        ON `conference_team_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        WHERE `conference_season_id`=$igosja_season_id
        ORDER BY RAND()";
$team_sql = f_igosja_mysqli_query($sql);

$count_team = $team_sql->num_rows;
$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

for ($i=0; $i<$count_team; $i=$i+2)
{
    $team_1_id      = $team_array[$i]['conference_team_id'];
    $team_2_id      = $team_array[$i+1]['conference_team_id'];
    $stadium_id     = $team_array[$i]['stadium_id'];
    $game_array[]   = '(' . $team_2_id . ',' . $team_1_id . ',' . $schedule_id . ',' . $stadium_id . ')';
}

$game_array = implode(', ', $game_array);

$sql = "INSERT INTO `game` (`game_guest_team_id`, `game_home_team_id`, `game_schedule_id`, `game_stadium_id`)
        VALUES $game_array;";
f_igosja_mysqli_query($sql);