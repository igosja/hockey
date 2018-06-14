<?php

/**
 * Перераховуємо вартість утримання стадіону
 */
function f_igosja_generator_stadium_maintenance()
{
    $sql = "UPDATE `stadium`
            SET `stadium_maintenance`=ROUND(POW(`stadium_capacity`, 2) / 1000)";
    f_igosja_mysqli_query($sql);
}