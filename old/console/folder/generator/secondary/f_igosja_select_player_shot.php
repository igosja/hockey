<?php

/**
 * Визначаємо позицію хокеїства, що кидає по воротах
 * @param $game_result array
 * @param $team string home або guest
 * @return array
 */
function f_igosja_select_player_shot($game_result, $team)
{
    if (0 == $game_result['minute'] % 3)
    {
        $ld_power = $game_result[$team]['player']['field']['ld_1']['power_real'];
        $rd_power = $game_result[$team]['player']['field']['rd_1']['power_real'];
        $lw_power = $game_result[$team]['player']['field']['lw_1']['power_real'];
        $c_power  = $game_result[$team]['player']['field']['c_1']['power_real'];
        $rw_power = $game_result[$team]['player']['field']['rw_1']['power_real'];
    }
    elseif (1 == $game_result['minute'] % 3)
    {
        $ld_power = $game_result[$team]['player']['field']['ld_2']['power_real'];
        $rd_power = $game_result[$team]['player']['field']['rd_2']['power_real'];
        $lw_power = $game_result[$team]['player']['field']['lw_2']['power_real'];
        $c_power  = $game_result[$team]['player']['field']['c_2']['power_real'];
        $rw_power = $game_result[$team]['player']['field']['rw_2']['power_real'];
    }
    else
    {
        $ld_power = $game_result[$team]['player']['field']['ld_3']['power_real'];
        $rd_power = $game_result[$team]['player']['field']['rd_3']['power_real'];
        $lw_power = $game_result[$team]['player']['field']['lw_3']['power_real'];
        $c_power  = $game_result[$team]['player']['field']['c_3']['power_real'];
        $rw_power = $game_result[$team]['player']['field']['rw_3']['power_real'];
    }

    $ld_power = $ld_power * 100;
    $rd_power = $rd_power * 100;
    $lw_power = $lw_power * 105;
    $c_power  = $c_power  * 110;
    $rw_power = $rw_power * 105;

    $total_power = $ld_power + $rd_power + $lw_power + $c_power + $rw_power;

    $rand = rand(0, $total_power);

    if ($rand < $ld_power)
    {
        $game_result['player'] = POSITION_LD;
    }
    elseif ($rand < $ld_power + $rd_power)
    {
        $game_result['player'] = POSITION_RD;
    }
    elseif ($rand < $ld_power + $rd_power + $lw_power)
    {
        $game_result['player'] = POSITION_LW;
    }
    elseif ($rand < $ld_power + $rd_power + $lw_power + $c_power)
    {
        $game_result['player'] = POSITION_C;
    }
    else
    {
        $game_result['player'] = POSITION_RW;
    }

    $penalty_position = f_igosja_penalty_position_array($game_result, $team);

    if (in_array($game_result['player'], $penalty_position))
    {
        $game_result = f_igosja_select_player_shot($game_result, $team);
    }

    return $game_result;
}