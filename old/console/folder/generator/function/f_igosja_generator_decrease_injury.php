<?php

/**
 * Зменшення травм хокеїстам
 */
function f_igosja_generator_decrease_injury()
{
    $sql = "UPDATE `player`
            SET `player_injury_day`=`player_injury_day`-1
            WHERE `player_injury`=1";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `player`
            LEFT JOIN `team`
            ON `player_team_id`=`team_id`
            LEFT JOIN `basemedical`
            ON `team_basemedical_id`=`basemedical_id`
            SET `player_tire`=`basemedical_tire`,
                `player_injury`=0
            WHERE `player_injury`=1
            AND `player_injury_day`<=0";
    f_igosja_mysqli_query($sql);
}