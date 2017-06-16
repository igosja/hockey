<?php

/**
 * Формуємо таблицю та матчі кубка міжсезоння
 */
function f_igosja_start_insert_offseason()
{
    $game_array = array();

    $sql = "INSERT INTO `offseason` (`offseason_season_id`, `offseason_team_id`)
            SELECT 1, `team_id`
            FROM `team`
            WHERE `team_id`!=0
            ORDER BY `team_id` ASC";
    f_igosja_mysqli_query($sql);

    $sql = "SELECT `shedule_id`
            FROM `shedule`
            WHERE `shedule_tournamenttype_id`=" . TOURNAMENTTYPE_OFFSEASON . "
            AND `shedule_stage_id`=" . STAGE_1_TOUR . "
            AND `shedule_season_id`=1
            LIMIT 1";
    $shedule_sql = f_igosja_mysqli_query($sql);

    $shedule_array = $shedule_sql->fetch_all(1);

    $shedule_id = $shedule_array[0]['shedule_id'];

    $sql = "SELECT `offseason_team_id`,
                   `stadium_id`
            FROM `offseason`
            LEFT JOIN `team`
            ON `offseason_team_id`=`team_id`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            WHERE `offseason_season_id`=1
            ORDER BY RAND()";
    $team_sql = f_igosja_mysqli_query($sql);

    $count_team = $team_sql->num_rows;
    $team_array = $team_sql->fetch_all(1);

    for ($i=0; $i<$count_team; $i=$i+2)
    {
        $team_1_id      = $team_array[$i]['offseason_team_id'];
        $team_2_id      = $team_array[$i+1]['offseason_team_id'];
        $stadium_id     = $team_array[$i]['stadium_id'];
        $game_array[]   = "('$team_1_id', '$team_2_id', '$shedule_id', '$stadium_id')";
    }

    $game_array = implode(', ', $game_array);

    $sql = "INSERT INTO `game` (`game_guest_team_id`, `game_home_team_id`, `game_shedule_id`, `game_stadium_id`)
            VALUES $game_array;";
    f_igosja_mysqli_query($sql);
}