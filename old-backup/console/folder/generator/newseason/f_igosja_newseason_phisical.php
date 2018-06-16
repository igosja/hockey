<?php

/**
 * Нова фіз форма для хокеїстів
 */
function f_igosja_newseason_phisical()
{
    $sql = "UPDATE `player`
            SET `player_phisical_id`=(
                SELECT `phisical_id`
                FROM `phisical`
                ORDER BY RAND()
                LIMIT 1
            )";
    f_igosja_mysqli_query($sql);
}