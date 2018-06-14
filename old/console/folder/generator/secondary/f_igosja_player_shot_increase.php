<?php

/**
 * Записуємо дані про кидок по воротах в масив хокеїста
 * @param $game_result array
 * @param $team string home або guest
 * @return array
 */
function f_igosja_player_shot_increase($game_result, $team)
{
    if (POSITION_LD == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result[$team]['player']['field']['ld_1']['shot']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result[$team]['player']['field']['ld_2']['shot']++;
        }
        else
        {
            $game_result[$team]['player']['field']['ld_3']['shot']++;
        }
    }
    elseif (POSITION_RD == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result[$team]['player']['field']['rd_1']['shot']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result[$team]['player']['field']['rd_2']['shot']++;
        }
        else
        {
            $game_result[$team]['player']['field']['rd_3']['shot']++;
        }
    }
    elseif (POSITION_LW == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result[$team]['player']['field']['lw_1']['shot']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result[$team]['player']['field']['lw_2']['shot']++;
        }
        else
        {
            $game_result[$team]['player']['field']['lw_3']['shot']++;
        }
    }
    elseif (POSITION_C == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result[$team]['player']['field']['c_1']['shot']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result[$team]['player']['field']['c_2']['shot']++;
        }
        else
        {
            $game_result[$team]['player']['field']['c_3']['shot']++;
        }
    }
    elseif (POSITION_RW == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result[$team]['player']['field']['rw_1']['shot']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result[$team]['player']['field']['rw_2']['shot']++;
        }
        else
        {
            $game_result[$team]['player']['field']['rw_3']['shot']++;
        }
    }

    return $game_result;
}