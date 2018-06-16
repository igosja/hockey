<?php

/**
 * Формуємо календар
 */
function f_igosja_newseason_schedule()
{
    global $igosja_season_id;

    $schedule_insert_array      = array();
    $schedule_friendly_array    = array(6, 13, 20, 27, 34, 41, 48, 55, 62, 69, 76, 83, 90, 97);
    $schedule_offseason_array   = array(0, 1, 2, 3, 4, 5, 7, 8, 9, 10, 11, 12);
    $schedule_league_array      = array(15, 17, 22, 24, 29, 31, 36, 38, 43, 45, 50, 52, 57, 59, 64, 66, 71, 73, 78, 80);
    $schedule_worldcup_array    = array(19, 26, 33, 40, 47, 54, 61, 68, 75, 82, 96);
    $schedule_stage_array       = array(
         2,  3,  4,  5,  6,  7, 1,
         8,  9, 10, 11, 12, 13, 1,
         2, 43,  3, 43,  4,  2, 1,
         5, 44,  6, 44,  7,  3, 1,
         8, 45,  9, 45, 10,  4, 1,
        11,  2, 12,  3, 13,  5, 1,
        14,  4, 15,  5, 16,  6, 1,
        17,  6, 18,  7, 19,  7, 1,
        20, 53, 21, 53, 22,  8, 1,
        23, 54, 24, 54, 25,  9, 1,
        26, 55, 27, 55, 28, 10, 1,
        29, 56, 30, 56, 31, 11, 1,
        54, 54, 54, 55, 55, 55, 1,
        56, 56, 56, 56, 56, 12, 1,
    );
    $schedule_conference_stage_array       = array(
         2,  3,  4,  5,  6,  7, 1,
         8,  9, 10, 11, 12, 13, 1,
         2, 43,  3, 43,  4,  2, 1,
         5, 44,  6, 44,  7,  3, 1,
         8, 45,  9, 45, 10,  4, 1,
        11,  2, 12,  3, 13,  5, 1,
        14,  4, 15,  5, 16,  6, 1,
        17,  6, 18,  7, 19,  7, 1,
        20, 53, 21, 53, 22,  8, 1,
        23, 54, 24, 54, 25,  9, 1,
        26, 55, 27, 55, 28, 10, 1,
        29, 56, 30, 56, 31, 11, 1,
        32, 33, 34, 35, 36, 37, 1,
        38, 39, 40, 41, 42, 12, 1,
    );

    $start_date = strtotime('Mon') + 12 * 60 * 60;
//    $start_date = time();

    for ($i=0; $i<98; $i++)
    {
        $date       = $start_date + $i * 24 * 60 *60;
        $conference = 0;

        if (in_array($i, $schedule_friendly_array))
        {
            $tournament_type = TOURNAMENTTYPE_FRIENDLY;
        }
        elseif (in_array($i, $schedule_offseason_array))
        {
            $tournament_type = TOURNAMENTTYPE_OFFSEASON;
        }
        elseif (in_array($i, $schedule_league_array))
        {
            $tournament_type = TOURNAMENTTYPE_LEAGUE;
        }
        elseif (in_array($i, $schedule_worldcup_array))
        {
            $tournament_type = TOURNAMENTTYPE_NATIONAL;
        }
        else
        {
            $conference         = 1;
            $tournament_type    = TOURNAMENTTYPE_CHAMPIONSHIP;
        }

        $schedule_insert_array[] = "($date, $igosja_season_id+1, $schedule_stage_array[$i], $tournament_type)";

        if ($conference)
        {
            $tournament_type_c  = TOURNAMENTTYPE_CONFERENCE;
            $schedule_insert_array[] = "($date, $igosja_season_id+1, $schedule_conference_stage_array[$i], $tournament_type_c)";
        }
    }

    $schedule_insert_array = implode(',', $schedule_insert_array);

    $sql = "INSERT INTO `schedule` (`schedule_date`, `schedule_season_id`, `schedule_stage_id`, `schedule_tournamenttype_id`)
            VALUES $schedule_insert_array;";
    f_igosja_mysqli_query($sql);
}