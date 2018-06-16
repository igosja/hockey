<?php

/**
 * Записуємо дані про отриманий штраф в масив команди
 * @param $game_result array
 * @param $team string home або guest
 * @return array
 */
function f_igosja_team_penalty_increase($game_result, $team)
{
    $game_result[$team]['team']['penalty']['total']++;

    if (20 > $game_result['minute'])
    {
        $game_result[$team]['team']['penalty'][1]++;
    }
    elseif (40 > $game_result['minute'])
    {
        $game_result[$team]['team']['penalty'][2]++;
    }
    elseif (60 > $game_result['minute'])
    {
        $game_result[$team]['team']['penalty'][3]++;
    }
    elseif (65 > $game_result['minute'])
    {
        $game_result[$team]['team']['penalty']['over']++;
    }

    return $game_result;
}