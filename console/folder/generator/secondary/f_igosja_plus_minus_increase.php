<?php

/**
 * Записуємо дані про показник плюс/мінус після голу в масив хокеїста
 * @param $game_result array
 * @param $team string home або guest
 * @param $opponent string home або guest
 * @return array
 */
function f_igosja_plus_minus_increase($game_result, $team, $opponent)
{
    $penalty_position_team     = f_igosja_penalty_position_array($game_result, $team);
    $penalty_position_opponent = f_igosja_penalty_position_array($game_result, $opponent);

    if (0 == $game_result['minute'] % 3)
    {
        if (!in_array(POSITION_LD, $penalty_position_team))
        {
            $game_result[$team]['player']['field']['ld_1']['plus_minus']++;
        }
        
        if (!in_array(POSITION_RD, $penalty_position_team))
        {
            $game_result[$team]['player']['field']['rd_1']['plus_minus']++;
        }
        
        if (!in_array(POSITION_LW, $penalty_position_team))
        {
            $game_result[$team]['player']['field']['lw_1']['plus_minus']++;
        }
        
        if (!in_array(POSITION_C, $penalty_position_team))
        {
            $game_result[$team]['player']['field']['c_1']['plus_minus']++;
        }

        if (!in_array(POSITION_RW, $penalty_position_team))
        {
            $game_result[$team]['player']['field']['rw_1']['plus_minus']++;
        }

        if (!in_array(POSITION_LD, $penalty_position_opponent))
        {
            $game_result[$opponent]['player']['field']['ld_1']['plus_minus']--;
        }
        
        if (!in_array(POSITION_RD, $penalty_position_opponent))
        {
            $game_result[$opponent]['player']['field']['rd_1']['plus_minus']--;
        }
        
        if (!in_array(POSITION_LW, $penalty_position_opponent))
        {
            $game_result[$opponent]['player']['field']['lw_1']['plus_minus']--;
        }
        
        if (!in_array(POSITION_C, $penalty_position_opponent))
        {
            $game_result[$opponent]['player']['field']['c_1']['plus_minus']--;
        }
        
        if (!in_array(POSITION_RW, $penalty_position_opponent))
        {
            $game_result[$opponent]['player']['field']['rw_1']['plus_minus']--;
        }
    }
    elseif (1 == $game_result['minute'] % 3)
    {
        if (!in_array(POSITION_LD, $penalty_position_team))
        {
            $game_result[$team]['player']['field']['ld_2']['plus_minus']++;
        }

        if (!in_array(POSITION_RD, $penalty_position_team))
        {
            $game_result[$team]['player']['field']['rd_2']['plus_minus']++;
        }

        if (!in_array(POSITION_LW, $penalty_position_team))
        {
            $game_result[$team]['player']['field']['lw_2']['plus_minus']++;
        }

        if (!in_array(POSITION_C, $penalty_position_team))
        {
            $game_result[$team]['player']['field']['c_2']['plus_minus']++;
        }

        if (!in_array(POSITION_RW, $penalty_position_team))
        {
            $game_result[$team]['player']['field']['rw_2']['plus_minus']++;
        }

        if (!in_array(POSITION_LD, $penalty_position_opponent))
        {
            $game_result[$opponent]['player']['field']['ld_2']['plus_minus']--;
        }

        if (!in_array(POSITION_RD, $penalty_position_opponent))
        {
            $game_result[$opponent]['player']['field']['rd_2']['plus_minus']--;
        }

        if (!in_array(POSITION_LW, $penalty_position_opponent))
        {
            $game_result[$opponent]['player']['field']['lw_2']['plus_minus']--;
        }

        if (!in_array(POSITION_C, $penalty_position_opponent))
        {
            $game_result[$opponent]['player']['field']['c_2']['plus_minus']--;
        }

        if (!in_array(POSITION_RW, $penalty_position_opponent))
        {
            $game_result[$opponent]['player']['field']['rw_2']['plus_minus']--;
        }
    }
    else
    {
        if (!in_array(POSITION_LD, $penalty_position_team))
        {
            $game_result[$team]['player']['field']['ld_3']['plus_minus']++;
        }

        if (!in_array(POSITION_RD, $penalty_position_team))
        {
            $game_result[$team]['player']['field']['rd_3']['plus_minus']++;
        }

        if (!in_array(POSITION_LW, $penalty_position_team))
        {
            $game_result[$team]['player']['field']['lw_3']['plus_minus']++;
        }

        if (!in_array(POSITION_C, $penalty_position_team))
        {
            $game_result[$team]['player']['field']['c_3']['plus_minus']++;
        }

        if (!in_array(POSITION_RW, $penalty_position_team))
        {
            $game_result[$team]['player']['field']['rw_3']['plus_minus']++;
        }

        if (!in_array(POSITION_LD, $penalty_position_opponent))
        {
            $game_result[$opponent]['player']['field']['ld_3']['plus_minus']--;
        }

        if (!in_array(POSITION_RD, $penalty_position_opponent))
        {
            $game_result[$opponent]['player']['field']['rd_3']['plus_minus']--;
        }

        if (!in_array(POSITION_LW, $penalty_position_opponent))
        {
            $game_result[$opponent]['player']['field']['lw_3']['plus_minus']--;
        }

        if (!in_array(POSITION_C, $penalty_position_opponent))
        {
            $game_result[$opponent]['player']['field']['c_3']['plus_minus']--;
        }

        if (!in_array(POSITION_RW, $penalty_position_opponent))
        {
            $game_result[$opponent]['player']['field']['rw_3']['plus_minus']--;
        }
    }

    return $game_result;
}