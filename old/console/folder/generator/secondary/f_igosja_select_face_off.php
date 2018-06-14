<?php

/**
 * Визначаємо позицію хокеїства, що боротиметься за вкидання
 * @param $game_result array
 * @param $team string home або guest
 * @return array
 */
function f_igosja_select_face_off($game_result, $team)
{
    $penalty_position = f_igosja_penalty_position_array($game_result, $team);

    if (!in_array(POSITION_C, $penalty_position))
    {
        $game_result['face_off_' . $team] = POSITION_C;
    }
    else
    {
        $game_result['face_off_' . $team] = rand(POSITION_LD, POSITION_RW);
    }

    if (in_array($game_result['face_off_' . $team], $penalty_position))
    {
        $game_result = f_igosja_select_face_off($game_result, $team);
    }

    return $game_result;
}