<?php

/**
 * Отримуємо позицію хокеїста, що має штрафні хвилини
 * @param $game_result array
 * @param $team string
 * @return array
 */
function f_igosja_penalty_position_array($game_result, $team)
{
    $penalty_position_array = array();

    $count_penalty = count($game_result[$team]['team']['penalty']['current']);

    if ($count_penalty > 2)
    {
        $count_penalty = 2;
    }

    for ($i=0; $i<$count_penalty; $i++)
    {
        $penalty_position_array[] = $game_result[$team]['team']['penalty']['current'][$i]['position'];
    }

    return $penalty_position_array;
}