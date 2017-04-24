<?php

/**
 * Усталость игроков
 */
function f_igosja_generator_player_tire()
{
    $sql = "UPDATE `player`
            SET `player_tire`=`player_tire`+5
            WHERE `player_game_row`>0
            AND `player_age`<40";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `player`
            SET `player_tire`=`player_tire`-5
            WHERE `player_game_row`<0
            AND `player_age`<40";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `player`
            SET `player_tire`=50
            WHERE `player_tire`>50
            AND `player_age`<40";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `player`
            SET `player_tire`=0
            WHERE `player_tire`<0
            AND `player_age`<40";
    f_igosja_mysqli_query($sql);

    print '.';
    flush();
}