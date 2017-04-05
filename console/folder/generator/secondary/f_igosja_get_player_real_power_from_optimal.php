<?php

function f_igosja_get_player_real_power_from_optimal($player_array, $position_id)
{
    $player_id      = $player_array['player_id'];
    $player_power   = $player_array['power_optimal'];
    $position_array = array();

    $sql = "SELECT `playerposition_position_id`
            FROM `playerposition`
            WHERE `playerposition_player_id`=$player_id
            ORDER BY `playerposition_position_id` ASC";
    $playerposition_sql = f_igosja_mysqli_query($sql);

    $playerposition_array = $playerposition_sql->fetch_all(1);

    foreach ($playerposition_array as $item)
    {
        $position_array[] = $item['playerposition_position_id'];
    }

    if (POSITION_LD == $position_id)
    {
        $position_coefficient = array(
            POSITION_LD,
            array(POSITION_RD, POSITION_LW)
        );
    }
    elseif (POSITION_RD == $position_id)
    {
        $position_coefficient = array(
            POSITION_RD,
            array(POSITION_LD, POSITION_RW)
        );
    }
    elseif (POSITION_LW == $position_id)
    {
        $position_coefficient = array(
            POSITION_LW,
            array(POSITION_LD, POSITION_C)
        );
    }
    elseif (POSITION_C == $position_id)
    {
        $position_coefficient = array(
            POSITION_C,
            array(POSITION_LW, POSITION_RW)
        );
    }
    elseif (POSITION_RW == $position_id)
    {
        $position_coefficient = array(
            POSITION_RW,
            array(POSITION_RD, POSITION_C)
        );
    }
    else
    {
        $position_coefficient = array(0, 0);
    }

    if (in_array($position_coefficient[0], $position_array))
    {
        $power = $player_power;
    }
    elseif (in_array($position_coefficient[1][0], $position_array) || in_array($position_coefficient[1][1], $position_array))
    {
        $power = round($player_power * 0.9);
    }
    else
    {
        $power = round($player_power * 0.8);
    }

    return $power;
}