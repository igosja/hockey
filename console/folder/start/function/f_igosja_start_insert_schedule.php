<?php

/**
 * Формуємо календар
 */
function f_igosja_start_insert_schedule()
{
    $schedule_insert_array       = array();
    $schedule_friendly_array     = array(6, 13, 20, 27, 34, 41, 48, 55, 61, 62);
    $schedule_offseason_array    = array(0, 1, 2, 3, 4, 5, 7, 8, 9, 10, 11, 12);
    $schedule_stage_array        = array(
        2,  3,   4,  5,  6,  7, 1,
        8,  9,  10, 11, 12, 13, 1,
        2,  3,   4,  5,  6,  7, 1,
        8,  9,  10, 11, 12, 13, 1,
        14, 15, 16, 17, 18, 19, 1,
        20, 21, 22, 23, 24, 25, 1,
        26, 27, 28, 29, 30, 31, 1,
        54, 54, 54, 55, 55, 55, 1,
        56, 56, 56, 56, 56,  1, 1
    );
    $schedule_conference_stage_array = array(
        2,  3,  4,  5,  6,  7, 1,
        8,  9, 10, 11, 12, 13, 1,
        2,  3,  4,  5,  6,  7, 1,
        8,  9, 10, 11, 12, 13, 1,
        14, 15, 16, 17, 18, 19, 1,
        20, 21, 22, 23, 24, 25, 1,
        26, 27, 28, 29, 30, 31, 1,
        32, 33, 34, 35, 36, 37, 1,
        38, 39, 40, 41, 42,  1, 1
    );

    $start_date = strtotime('Mon') + 12 * 60 * 60;
//    $start_date = time();

    for ($i=0; $i<63; $i++)
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
        else
        {
            $conference         = 1;
            $tournament_type    = TOURNAMENTTYPE_CHAMPIONSHIP;
        }

        $schedule_insert_array[] = "($date, 1, $schedule_stage_array[$i], $tournament_type)";

        if ($conference)
        {
            $tournament_type_c  = TOURNAMENTTYPE_CONFERENCE;
            $schedule_insert_array[] = "($date, 1, $schedule_conference_stage_array[$i], $tournament_type_c)";
        }
    }

    $schedule_insert_array = implode(',', $schedule_insert_array);

    $sql = "INSERT INTO `schedule` (`schedule_date`, `schedule_season_id`, `schedule_stage_id`, `schedule_tournamenttype_id`)
            VALUES $schedule_insert_array;";
    f_igosja_mysqli_query($sql);
}