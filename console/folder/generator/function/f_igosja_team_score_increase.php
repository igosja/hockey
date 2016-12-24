<?php

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
    else
    {
        $game_result[$team]['team']['score'][3]++;
    }

    return $game_result;
}