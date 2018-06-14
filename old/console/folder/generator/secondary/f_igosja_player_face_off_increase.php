<?php

/**
 * Записуємо дані про проведене вкидання в масив хокеїста
 * @param $game_result array
 * @param $team string home або guest
 * @return array
 */
function f_igosja_player_face_off_increase($game_result, $team)
{
    if (POSITION_LD == $game_result['face_off_' . $team])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result[$team]['player']['field']['ld_1']['face_off']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result[$team]['player']['field']['ld_2']['face_off']++;
        }
        else
        {
            $game_result[$team]['player']['field']['ld_3']['face_off']++;
        }
    }
    elseif (POSITION_RD == $game_result['face_off_' . $team])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result[$team]['player']['field']['rd_1']['face_off']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result[$team]['player']['field']['rd_2']['face_off']++;
        }
        else
        {
            $game_result[$team]['player']['field']['rd_3']['face_off']++;
        }
    }
    elseif (POSITION_LW == $game_result['face_off_' . $team])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result[$team]['player']['field']['lw_1']['face_off']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result[$team]['player']['field']['lw_2']['face_off']++;
        }
        else
        {
            $game_result[$team]['player']['field']['lw_3']['face_off']++;
        }
    }
    elseif (POSITION_C == $game_result['face_off_' . $team])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result[$team]['player']['field']['c_1']['face_off']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result[$team]['player']['field']['c_2']['face_off']++;
        }
        else
        {
            $game_result[$team]['player']['field']['c_3']['face_off']++;
        }
    }
    elseif (POSITION_RW == $game_result['face_off_' . $team])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result[$team]['player']['field']['rw_1']['face_off']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result[$team]['player']['field']['rw_2']['face_off']++;
        }
        else
        {
            $game_result[$team]['player']['field']['rw_3']['face_off']++;
        }
    }

    return $game_result;
}