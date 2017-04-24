<?php

/**
 * Строительство стадиона
 */
function f_igosja_generator_building_stadium()
{
    $sql = "UPDATE `buildingstadium`
            SET `buildingstadium_day`=`buildingstadium_day`-1
            WHERE `buildingstadium_ready`=0";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `stadium`
            LEFT JOIN `team`
            ON `stadium_id`=`team_stadium_id`
            LEFT JOIN `buildingstadium`
            ON `buildingstadium_team_id`=`team_id`
            SET `stadium_capacity`=`buildingstadium_capacity`
            WHERE `buildingstadium_day`=1
            AND `buildingstadium_ready`=0";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `buildingstadium`
            SET `buildingstadium_ready`=1
            WHERE `buildingstadium_day`=0
            AND `buildingstadium_ready`=0";
    f_igosja_mysqli_query($sql);

    print '.';
    flush();
}