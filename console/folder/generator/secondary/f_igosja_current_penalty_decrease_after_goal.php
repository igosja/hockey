<?php

/**
 * Віпускаємо хокеїста на лід після пропущеного голу
 * @param $game_result array
 * @param $team string home або guest
 * @param $opponent string home або guest
 * @return array
 */
function f_igosja_current_penalty_decrease_after_goal($game_result, $team, $opponent)
{
    $count_team_penalty     = count($game_result[$team]['team']['penalty']['current']);
    $count_opponent_penalty = count($game_result[$opponent]['team']['penalty']['current']);

    if ($count_team_penalty <= $count_opponent_penalty || 2 <= $count_team_penalty)
    {
        return $game_result;
    }

    $penalty_array_old = $game_result[$opponent]['team']['penalty']['current'];
    $penalty_array_new = array();

    $count_penalty = count($penalty_array_old);

    for ($i=0; $i<$count_penalty; $i++)
    {
        if ($i > 1)
        {
            $penalty_array_new[] = array(
                'minute' => $game_result['minute'],
                'position' => $penalty_array_old[$i]['position'],
            );
        }
        elseif (0 != $i)
        {
            $penalty_array_new[] = $penalty_array_old[$i];
        }
    }

    $game_result[$opponent]['team']['penalty']['current'] = $penalty_array_new;

    return $game_result;
}