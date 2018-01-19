<?php

include(__DIR__ . '/include/include.php');

$sql = "SELECT `game_guest_national_id`,
               `game_guest_score`,
               `game_guest_score_bullet`,
               `game_guest_score_over`,
               `game_guest_team_id`,
               `game_home_national_id`,
               `game_home_score`,
               `game_home_score_bullet`,
               `game_home_score_over`,
               `game_home_team_id`,
               `schedule_season_id`,
               `schedule_stage_id`,
               `schedule_tournamenttype_id`
        FROM `game`
        LEFT JOIN `schedule`
        ON `game_schedule_id`=`schedule_id`
        WHERE `game_id`=2159
        ORDER BY `game_id` ASC";
$game_sql = f_igosja_mysqli_query($sql);

$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

foreach ($game_array as $game) {
    $guest_loose = 0;
    $guest_loose_bullet = 0;
    $guest_loose_over = 0;
    $guest_win = 0;
    $guest_win_bullet = 0;
    $guest_win_over = 0;
    $home_loose = 0;
    $home_loose_bullet = 0;
    $home_loose_over = 0;
    $home_win = 0;
    $home_win_bullet = 0;
    $home_win_over = 0;

    if ($game['game_home_score'] > $game['game_guest_score']) {
        if (0 == $game['game_home_score_over']) {
            $home_win++;
            $guest_loose++;
        } else {
            $home_win_over++;
            $guest_loose_over++;
        }
    } elseif ($game['game_guest_score'] > $game['game_home_score']) {
        if (0 == $game['game_guest_score_over']) {
            $guest_win++;
            $home_loose++;
        } else {
            $guest_win_over++;
            $home_loose_over++;
        }
    } elseif ($game['game_guest_score'] == $game['game_home_score']) {
        if (0 == $game['game_home_score_bullet']) {
            $guest_win_bullet++;
            $home_loose_bullet++;
        } else {
            $home_win_bullet++;
            $guest_loose_bullet++;
        }
    }
}

print '<pre>';
print_r($home_win_bullet);
print '<pre>';
print_r($home_loose_bullet);
print '<pre>';
print_r($guest_win_bullet);
print '<pre>';
print_r($guest_loose_bullet);
exit;