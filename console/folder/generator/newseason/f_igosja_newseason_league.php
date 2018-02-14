<?php

/**
 * Формуємо матчі перщого відбіркового раунда ЛЧ
 */
function f_igosja_newseason_league()
{
    global $igosja_season_id;

    $game_1_array = array();
    $game_2_array = array();

    $sql = "SELECT `schedule_id`
            FROM `schedule`
            WHERE `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
            AND `schedule_stage_id`=" . STAGE_1_QUALIFY . "
            AND `schedule_season_id`=$igosja_season_id+1
            LIMIT 2";
    $schedule_sql = f_igosja_mysqli_query($sql);

    $schedule_array = $schedule_sql->fetch_all(MYSQLI_ASSOC);

    $schedule_1_id = $schedule_array[0]['schedule_id'];
    $schedule_2_id = $schedule_array[1]['schedule_id'];

    $sql = "SELECT `team_id`,
                   `stadium_id`
            FROM `participantleague`
            LEFT JOIN `team`
            ON `participantleague_team_id`=`team_id`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            WHERE `participantleague_season_id`=$igosja_season_id+1
            AND `participantleague_stage_in`=" . STAGE_1_QUALIFY . "
            ORDER BY RAND()";
    $team_sql = f_igosja_mysqli_query($sql);

    $count_team = $team_sql->num_rows;
    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_team; $i=$i+2)
    {
        $team_1_id      = $team_array[$i]['team_id'];
        $team_2_id      = $team_array[$i+1]['team_id'];
        $stadium_1_id   = $team_array[$i]['stadium_id'];
        $stadium_2_id   = $team_array[$i+1]['stadium_id'];
        $game_1_array[] = '(' . $team_2_id . ',' . $team_1_id . ',' . $schedule_1_id . ',' . $stadium_1_id . ')';
        $game_2_array[] = '(' . $team_1_id . ',' . $team_2_id . ',' . $schedule_2_id . ',' . $stadium_2_id . ')';
    }

    $game_1_array = implode(', ', $game_1_array);
    $game_2_array = implode(', ', $game_2_array);

    $sql = "INSERT INTO `game` (`game_guest_team_id`, `game_home_team_id`, `game_schedule_id`, `game_stadium_id`)
            VALUES $game_1_array;";
    f_igosja_mysqli_query($sql);

    $sql = "INSERT INTO `game` (`game_guest_team_id`, `game_home_team_id`, `game_schedule_id`, `game_stadium_id`)
            VALUES $game_2_array;";
    f_igosja_mysqli_query($sql);
}