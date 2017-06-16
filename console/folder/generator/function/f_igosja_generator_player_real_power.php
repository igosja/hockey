<?php

/**
 * Рахуємо реальну силу хокеїстів
 */
function f_igosja_generator_player_real_power()
{
    $sql = "UPDATE `player`
            LEFT JOIN `phisical`
            ON `player_phisical_id`=`phisical_id`
            SET `player_power_real`=`player_power_nominal`*(100-`player_tire`)/100*`phisical_value`/100
            WHERE `player_age`<40";
    f_igosja_mysqli_query($sql);
}