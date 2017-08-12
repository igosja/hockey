<?php

/**
 * Змінюємо фізичну форму хокеїстів
 */
function f_igosja_generator_phisical()
{
    $sql = "UPDATE `player`
            LEFT JOIN `phisicalchange`
            ON `player_id`=`phisicalchange_player_id`
            LEFT JOIN `phisical`
            ON `player_phisical_id`=`phisical_id`
            LEFT JOIN `schedule`
            ON `phisicalchange_schedule_id`=`schedule_id`
            SET `player_phisical_id`=`phisical_opposite`
            WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `player`
            SET `player_phisical_id`=`player_phisical_id`+1
            WHERE `player_age`<40";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `player`
            SET `player_phisical_id`=1
            WHERE `player_phisical_id`>20";
    f_igosja_mysqli_query($sql);
}