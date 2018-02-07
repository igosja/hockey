<?php

/**
 * Визначаємо позицію хокеїства, що кидає по воротах
 * @param $game_result array
 * @param $team string home або guest
 * @return array
 */
function f_igosja_select_player_shot($game_result, $team)
{
    if (1 == rand(1, 3))
    {
        $game_result['player'] = rand(POSITION_LD, POSITION_RD);
    }
    else
    {
        $game_result['player'] = rand(POSITION_LW, POSITION_RW);
    }

    $penalty_position = f_igosja_penalty_position_array($game_result, $team);

    if (in_array($game_result['player'], $penalty_position))
    {
        $game_result = f_igosja_select_player_shot($game_result, $team);
    }

    return $game_result;
}