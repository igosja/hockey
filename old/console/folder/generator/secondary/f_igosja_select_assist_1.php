<?php

/**
 * Визначаємо позицію хокеїства, що віддав результативну передачу
 * @param $game_result array
 * @param $team string home або guest
 * @return array
 */
function f_igosja_select_assist_1($game_result, $team)
{
    if (1 == rand(1, 3))
    {
        $game_result['assist_1'] = rand(POSITION_LD, POSITION_RD);
    }
    else
    {
        $game_result['assist_1'] = rand(POSITION_LW, POSITION_RW);
    }

    $penalty_position           = f_igosja_penalty_position_array($game_result, $team);
    $penalty_position[]         = $game_result['player'];

    if (in_array($game_result['assist_1'], $penalty_position))
    {
        $game_result = f_igosja_select_assist_1($game_result, $team);
    }

    return $game_result;
}