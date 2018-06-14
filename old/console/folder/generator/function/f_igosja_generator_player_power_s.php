<?php

/**
 * Рахуємо силу хокеїстів для vs
 */
function f_igosja_generator_player_power_s()
{
    $sql = "UPDATE `player`
            LEFT JOIN
            (
                SELECT `playerspecial_player_id`, SUM(`playerspecial_level`) AS `special_level`
                FROM `playerspecial`
                LEFT JOIN `player`
                ON `playerspecial_player_id`=`player_id`
                WHERE `player_age`<40
                GROUP BY `playerspecial_player_id`
            ) AS `t1`
            ON `playerspecial_player_id`=`player_id`
            SET `player_power_nominal_s`=`player_power_nominal`+IF(`special_level` IS NULL, 0, `special_level`)*`player_power_nominal`*5/100
            WHERE `player_age`<40";
    f_igosja_mysqli_query($sql);
}