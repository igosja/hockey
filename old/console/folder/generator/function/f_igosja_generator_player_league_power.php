<?php

/**
 * Скидаємо силу хокеїстів від ліги
 */
function f_igosja_generator_player_league_power()
{
    $sql = "UPDATE `player`
            SET `player_power_nominal`=`player_age`*2
            WHERE `player_age`=18
            AND `player_team_id`=0";
    f_igosja_mysqli_query($sql);
}