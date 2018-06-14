<?php

/**
 * Вивчаємо своїх хокеїстів у скаут центрі
 */
function f_igosja_generator_scout()
{
    global $igosja_season_id;

    $sql = "UPDATE `scout`
            LEFT JOIN `team`
            ON `scout_team_id`=`team_id`
            LEFT JOIN `basescout`
            ON `team_basescout_id`=`basescout_id`
            SET `scout_percent`=`scout_percent`+`basescout_scout_speed_min`+(`basescout_scout_speed_max`-`basescout_scout_speed_min`)/2*RAND()
            WHERE `scout_ready`=0";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `scout`
            SET `scout_percent`=100,
                `scout_ready`=1
            WHERE `scout_percent`>=100
            AND `scout_ready`=0";
    f_igosja_mysqli_query($sql);
}