<?php

/**
 * Переносимо поточної сили хокеїстів в стару
 */
function f_igosja_generator_player_power_new_to_old()
{
    $sql = "UPDATE `player`
            SET `player_power_old`=`player_power_nominal`
            WHERE `player_power_old`!=`player_power_nominal`";
    f_igosja_mysqli_query($sql);
}