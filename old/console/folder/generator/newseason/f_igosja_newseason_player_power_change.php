<?php

/**
 * Змінюємо силу хокеїстів при зміні їх віку
 */
function f_igosja_newseason_player_power_change()
{
    $sql = "UPDATE `player`
            SET `player_power_nominal`=`player_power_nominal`+27-`player_age`
            WHERE `player_age`<=23";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `player`
            SET `player_power_nominal`=ROUND(`player_power_nominal`*(100-(`player_age`-34)*5)/100)
            WHERE `player_age` BETWEEN 35 AND 39";
    f_igosja_mysqli_query($sql);
}