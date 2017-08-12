<?php

/**
 * Зміна статусу голосувань за тренерів сбірних
 */
function f_igosja_generator_national_vote_status()
{
    $sql = "SELECT `schedule_nationalvotestep_id`
            FROM `schedule`
            WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            AND `schedule_nationalvotestep_id` IN (
                ".NATIONALVOTESTEP_MAIN_APPLICATION.",
                ".NATIONALVOTESTEP_MAIN_VOTE.",
                ".NATIONALVOTESTEP_21_APPLICATION.",
                ".NATIONALVOTESTEP_21_VOTE.",
                ".NATIONALVOTESTEP_19_APPLICATION.",
                ".NATIONALVOTESTEP_19_VOTE."
            )
            LIMIT 1";
    $schedule_sql = f_igosja_mysqli_query($sql);

    if ($schedule_sql->num_rows)
    {
        $schedule_array = $schedule_sql->fetch_all(1);

        $sql = "SELECT `schedule_nationalvotestep_id`
                FROM `schedule`
                WHERE FROM_UNIXTIME(`schedule_date`-86400, '%Y-%m-%d')=CURDATE()
                LIMIT 1";
        $tomorrow_sql = f_igosja_mysqli_query($sql);

        $tomorrow_array = $tomorrow_sql->fetch_all(1);

        if (NATIONALVOTESTEP_MAIN_APPLICATION == $schedule_array[0]['schedule_nationalvotestep_id'] &&
            NATIONALVOTESTEP_MAIN_VOTE == $tomorrow_array[0]['schedule_nationalvotestep_id'])
        {
            f_igosja_election_national_to_open(NATIONALTYPE_MAIN);
        }
        elseif (NATIONALVOTESTEP_MAIN_VOTE == $schedule_array[0]['schedule_nationalvotestep_id'] &&
                NATIONALVOTESTEP_21_APPLICATION == $tomorrow_array[0]['schedule_nationalvotestep_id'])
        {
            f_igosja_election_national_to_close(NATIONALTYPE_MAIN);
        }
        elseif (NATIONALVOTESTEP_21_APPLICATION == $schedule_array[0]['schedule_nationalvotestep_id'] &&
                NATIONALVOTESTEP_21_VOTE == $tomorrow_array[0]['schedule_nationalvotestep_id'])
        {
            f_igosja_election_national_to_open(NATIONALTYPE_21);
        }
        elseif (NATIONALVOTESTEP_21_VOTE == $schedule_array[0]['schedule_nationalvotestep_id'] &&
                NATIONALVOTESTEP_19_APPLICATION == $tomorrow_array[0]['schedule_nationalvotestep_id'])
        {
            f_igosja_election_national_to_close(NATIONALTYPE_21);
        }
        elseif (NATIONALVOTESTEP_19_APPLICATION == $schedule_array[0]['schedule_nationalvotestep_id'] &&
                NATIONALVOTESTEP_19_VOTE == $tomorrow_array[0]['schedule_nationalvotestep_id'])
        {
            f_igosja_election_national_to_open(NATIONALTYPE_19);
        }
        elseif (NATIONALVOTESTEP_19_VOTE == $schedule_array[0]['schedule_nationalvotestep_id'] &&
                0 == $tomorrow_array[0]['schedule_nationalvotestep_id'])
        {
            f_igosja_election_national_to_close(NATIONALTYPE_19);
        }
    }
}