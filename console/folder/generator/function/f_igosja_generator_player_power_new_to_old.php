<?php

/**
 * Перенос текущей силы игроков в старую
 */
function f_igosja_generator_player_power_new_to_old()
{
    $sql = "UPDATE `player`
            SET `player_power_old`=`player_power_nominal`";
    f_igosja_mysqli_query($sql);

    print '.';
    flush();
}