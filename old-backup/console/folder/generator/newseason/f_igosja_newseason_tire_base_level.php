<?php

/**
 * Виводимо втому хокеїстів на рівень мед центру
 */
function f_igosja_newseason_tire_base_level()
{
    $sql = "UPDATE `player`
            LEFT JOIN `team`
            ON `player_team_id`=`team_id`
            LEFT JOIN `basemedical`
            ON `team_basemedical_id`=`basemedical_id`
            SET `player_tire`=`basemedical_tire`
            WHERE `player_team_id`!=0
            AND `player_rent_team_id`=0";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `player`
            LEFT JOIN `team`
            ON `player_rent_team_id`=`team_id`
            LEFT JOIN `basemedical`
            ON `team_basemedical_id`=`basemedical_id`
            SET `player_tire`=`basemedical_tire`
            WHERE `player_team_id`!=0
            AND `player_rent_team_id`!=0";
    f_igosja_mysqli_query($sql);
}