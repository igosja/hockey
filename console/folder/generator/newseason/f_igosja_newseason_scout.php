<?php

/**
 * Вивчаємо своїх хокеїстів у скаут центрі
 */
function f_igosja_newseason_scout()
{
    $sql = "UPDATE `scout`
            LEFT JOIN `team`
            ON `scout_team_id`=`team_id`
            LEFT JOIN `basescout`
            ON `team_basescout_id`=`basescout_id`
            SET `scout_percent`=100
            WHERE `scout_ready`=0";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `scout`
            SET `scout_percent`=100,
                `scout_ready`=1
            WHERE `scout_percent`>=100
            AND `scout_ready`=0";
    f_igosja_mysqli_query($sql);
}