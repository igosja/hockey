<?php

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
    else
    {
        $game_result[$team]['team']['penalty'][3]++;
    }

    return $game_result;
}