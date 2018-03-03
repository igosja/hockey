<?php

/**
 * Знімаємо заборону на трансфери
 */
function f_igosja_newseason_nodeal()
{
    $sql = "UPDATE `player`
            SET `player_nodeal`=0
            WHERE `player_nodeal`=1";
    f_igosja_mysqli_query($sql);
}