<?php

/**
 * Лікуємо всі травми
 */
function f_igosja_newseason_injury()
{
    $sql = "UPDATE `player`
            SET `player_injury`=0,
                `player_injury_day`=0
            WHERE `player_injury`=1";
    f_igosja_mysqli_query($sql);
}