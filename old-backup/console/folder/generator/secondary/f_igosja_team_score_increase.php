<?php

/**
 * Записуємо дані про гол в масив команди
 * @param $game_result array
 * @param $team string home або guest
 * @param $opponent string home або guest
 * @return array
 */
function f_igosja_team_score_increase($game_result, $team, $opponent)
{
    $game_result[$team]['team']['score']['total']++;
    $game_result[$opponent]['player']['gk']['pass']++;

    if (20 > $game_result['minute'])
    {
        $game_result[$team]['team']['score'][1]++;
    }
    elseif (40 > $game_result['minute'])
    {
        $game_result[$team]['team']['score'][2]++;
    }
    elseif (60 > $game_result['minute'])
    {
        $game_result[$team]['team']['score'][3]++;
    }
    elseif (65 > $game_result['minute'])
    {
        $game_result[$team]['team']['score']['over']++;
    }

    return $game_result;
}