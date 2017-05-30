<?php

/**
 * Рахуємо ціну хокеїстів та їх зарплати
 */
function f_igosja_generator_player_price_and_salary()
{
    $sql = "UPDATE `player`
            LEFT JOIN
            (
                SELECT `playerspecial_player_id`, SUM(`playerspecial_level`) AS `special_level`
                FROM `playerspecial`
                GROUP BY `playerspecial_player_id`
            ) AS `t1`
            ON `playerspecial_player_id`=`player_id`
            LEFT JOIN
            (
                SELECT `playerposition_player_id`, COUNT(`playerposition_position_id`) AS `position`
                FROM `playerposition`
                GROUP BY `playerposition_player_id`
            ) AS `t2`
            ON `playerposition_player_id`=`player_id`
            SET `player_price`=POW(150-(28-`player_power_nominal`/2), 2)*`player_power_nominal`*(1+IF(`special_level` IS NULL, 0, `special_level`)/8)*(2+`position`)/3
            WHERE `player_age`<40";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `player`
            SET `player_salary`=`player_price`/999
            WHERE `player_age`<40";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}