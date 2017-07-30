<?php

/**
 * Зміна статусу голосувань за тренерів сбірних
 */
function f_igosja_generator_national_vote_status()
{
    $sql = "SELECT `shedule_nationalvotestep_id`
            FROM `shedule`
            WHERE FROM_UNIXTIME(`shedule_date`, '%Y-%m-%d')=CURDATE()
            AND `shedule_nationalvotestep_id` IN (
                ".NATIONALVOTESTEP_MAIN_APPLICATION.",
                ".NATIONALVOTESTEP_MAIN_VOTE.",
                ".NATIONALVOTESTEP_21_APPLICATION.",
                ".NATIONALVOTESTEP_21_VOTE.",
                ".NATIONALVOTESTEP_19_APPLICATION.",
                ".NATIONALVOTESTEP_19_VOTE."
            )
            LIMIT 1";
    $shedule_sql = f_igosja_mysqli_query($sql);

    if ($shedule_sql->num_rows)
    {
        $shedule_array = $shedule_sql->fetch_all(1);

        $sql = "SELECT `shedule_nationalvotestep_id`
                FROM `shedule`
                WHERE FROM_UNIXTIME(`shedule_date`-86400, '%Y-%m-%d')=CURDATE()
                LIMIT 1";
        $tomorrow_sql = f_igosja_mysqli_query($sql);

        $tomorrow_array = $tomorrow_sql->fetch_all(1);

        if (NATIONALVOTESTEP_MAIN_APPLICATION == $shedule_array[0]['shedule_nationalvotestep_id'] &&
            NATIONALVOTESTEP_MAIN_VOTE == $tomorrow_array[0]['shedule_nationalvotestep_id'])
        {
            f_igosja_election_national_to_open(NATIONALTYPE_MAIN);
        }
        elseif (NATIONALVOTESTEP_MAIN_VOTE == $shedule_array[0]['shedule_nationalvotestep_id'] &&
                NATIONALVOTESTEP_21_APPLICATION == $tomorrow_array[0]['shedule_nationalvotestep_id'])
        {
            f_igosja_election_national_to_close(NATIONALTYPE_MAIN);
        }
        elseif (NATIONALVOTESTEP_21_APPLICATION == $shedule_array[0]['shedule_nationalvotestep_id'] &&
                NATIONALVOTESTEP_21_VOTE == $tomorrow_array[0]['shedule_nationalvotestep_id'])
        {
            f_igosja_election_national_to_open(NATIONALTYPE_21);
        }
        elseif (NATIONALVOTESTEP_21_VOTE == $shedule_array[0]['shedule_nationalvotestep_id'] &&
                NATIONALVOTESTEP_19_APPLICATION == $tomorrow_array[0]['shedule_nationalvotestep_id'])
        {
            f_igosja_election_national_to_close(NATIONALTYPE_21);
        }
        elseif (NATIONALVOTESTEP_19_APPLICATION == $shedule_array[0]['shedule_nationalvotestep_id'] &&
                NATIONALVOTESTEP_19_VOTE == $tomorrow_array[0]['shedule_nationalvotestep_id'])
        {
            f_igosja_election_national_to_open(NATIONALTYPE_19);
        }
        elseif (NATIONALVOTESTEP_19_VOTE == $shedule_array[0]['shedule_nationalvotestep_id'] &&
                0 == $tomorrow_array[0]['shedule_nationalvotestep_id'])
        {
            f_igosja_election_national_to_close(NATIONALTYPE_19);
        }
    }
}