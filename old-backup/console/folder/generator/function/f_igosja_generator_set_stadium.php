<?php

/**
 * Вызначаємо стадіони в матчах збірних
 */
function f_igosja_generator_set_stadium()
{
    $sql = "UPDATE `game`
            LEFT JOIN `schedule`
            ON `game_schedule_id`=`schedule_id`
            LEFT JOIN `national`
            ON `game_home_national_id`=`national_id`
            SET `game_stadium_id`=`national_stadium_id`
            WHERE `game_played`=0
            AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_NATIONAL . "";
    f_igosja_mysqli_query($sql);
}