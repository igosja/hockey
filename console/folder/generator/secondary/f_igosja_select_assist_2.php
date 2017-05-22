<?php

/**
 * Визначаємо позицію хокеїства, що віддав другу результативну передачу
 * @param $game_result array
 * @param $team string home або guest
 * @return array
 */
function f_igosja_select_assist_2($game_result, $team)
{
    $game_result['assist_2']    = rand(POSITION_GK, POSITION_RW);
    $penalty_position           = f_igosja_penalty_position_array($game_result, $team);
    $penalty_position[]         = $game_result['player'];

    if (in_array($game_result['assist_2'], $penalty_position))
    {
        $game_result = f_igosja_select_assist_2($game_result, $team);
    }

    return $game_result;
}