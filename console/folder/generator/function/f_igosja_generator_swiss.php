<?php

/**
 * Жеребьюем следуюющий раунд по швейцарской системе
 */
function f_igosja_generator_swiss()
{
    $sql = "SELECT `shedule_tournamenttype_id`
            FROM `shedule`
            WHERE FROM_UNIXTIME(`shedule_date`, '%Y-%m-%d')=CURDATE()
            AND `shedule_tournamenttype_id` IN (" . TOURNAMENTTYPE_CONFERENCE . ", " . TOURNAMENTTYPE_OFFSEASON. ")
            LIMIT 1";
    $tournamenttype_sql = f_igosja_mysqli_query($sql);

    if ($tournamenttype_sql->num_rows)
    {
        $tournamenttype_array = $tournamenttype_sql->fetch_all(1);

        f_igosja_swiss($tournamenttype_array[0]['shedule_tournamenttype_id'], 1, 1);
    }

    usleep(1);

    print '.';
    flush();
}