<?php

/**
 * Змінюємо силу хокеїстів при зміні їх віку
 */
function f_igosja_newseason_player_game_row()
{
    $sql = "UPDATE `player`
            SET `player_game_row`=-1
            WHERE `player_game_row`!=-1";
    f_igosja_mysqli_query($sql);
}