<?php

/**
 * Записуємо дані про кидок по воромах в масив команди
 * @param $game_result array
 * @param $team string home або guest
 * @param $opponent string home або guest
 * @return array
 */
function f_igosja_team_shot_increase($game_result, $team, $opponent)
{
    $game_result[$opponent]['player']['gk']['shot']++;
    $game_result[$team]['team']['shot']['total']++;

    if (20 > $game_result['minute'])
    {
        $game_result[$team]['team']['shot'][1]++;
    }
    elseif (40 > $game_result['minute'])
    {
        $game_result[$team]['team']['shot'][2]++;
    }
    elseif (60 > $game_result['minute'])
    {
        $game_result[$team]['team']['shot'][3]++;
    }
    elseif (65 > $game_result['minute'])
    {
        $game_result[$team]['team']['shot']['over']++;
    }

    return $game_result;
}