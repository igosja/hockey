<?php

/**
 * Нова фіз форма для хоккеїстів
 */
function f_igosja_newseason_phisical()
{
    $sql = "UPDATE `player`
            SET `player_phisical_id`=(
              SELECT `phisical_id`
              FROM `phisical`
              ORDER BY RAND()
            )";
    f_igosja_mysqli_query($sql);
}