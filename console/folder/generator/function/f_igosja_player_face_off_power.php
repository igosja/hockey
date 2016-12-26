<?php

function f_igosja_player_face_off_power($game_result, $team)
{
    if (POSITION_LD == $game_result['face_off_' . $team])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $power = $game_result[$team]['player']['field']['ld_1']['power_real'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $power = $game_result[$team]['player']['field']['ld_2']['power_real'];
        }
        else
        {
            $power = $game_result[$team]['player']['field']['ld_3']['power_real'];
        }
    }
    elseif (POSITION_RD == $game_result['face_off_' . $team])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $power = $game_result[$team]['player']['field']['rd_1']['power_real'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $power = $game_result[$team]['player']['field']['rd_2']['power_real'];
        }
        else
        {
            $power = $game_result[$team]['player']['field']['rd_3']['power_real'];
        }
    }
    elseif (POSITION_LW == $game_result['face_off_' . $team])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $power = $game_result[$team]['player']['field']['lw_1']['power_real'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $power = $game_result[$team]['player']['field']['lw_2']['power_real'];
        }
        else
        {
            $power = $game_result[$team]['player']['field']['lw_3']['power_real'];
        }
    }
    elseif (POSITION_C == $game_result['face_off_' . $team])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $power = $game_result[$team]['player']['field']['c_1']['power_real'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $power = $game_result[$team]['player']['field']['c_2']['power_real'];
        }
        else
        {
            $power = $game_result[$team]['player']['field']['c_3']['power_real'];
        }
    }
    elseif (POSITION_RW == $game_result['face_off_' . $team])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $power = $game_result[$team]['player']['field']['rw_1']['power_real'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $power = $game_result[$team]['player']['field']['rw_2']['power_real'];
        }
        else
        {
            $power = $game_result[$team]['player']['field']['rw_3']['power_real'];
        }
    }

    if (isset($power))
    {
        $game_result[$team]['team']['power']['face_off'] = $power;
    }

    return $game_result;
}