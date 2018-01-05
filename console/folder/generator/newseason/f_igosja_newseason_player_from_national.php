<?php

/**
 * Повертаємо хокеїстів зі збірних
 */
function f_igosja_newseason_player_from_national()
{
    $sql = "UPDATE `player`
            SET `player_national_id`=0
            WHERE `player_national_id`!=0";
    f_igosja_mysqli_query($sql);
}