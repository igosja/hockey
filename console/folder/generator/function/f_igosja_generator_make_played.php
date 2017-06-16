<?php

/**
 * Робимо матчі зіграними
 */
function f_igosja_generator_make_played()
{
    $sql = "UPDATE `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            SET `game_played`=1
            WHERE `game_played`=0
            AND FROM_UNIXTIME(`shedule_date`, '%Y-%m-%d')=CURDATE()";
    f_igosja_mysqli_query($sql);
}