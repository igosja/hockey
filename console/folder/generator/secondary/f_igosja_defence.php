<?php

function f_igosja_defence($game_result, $team)
{
    if (0 == $game_result['minute'] % 3)
    {
        $defence = $game_result[$team]['team']['power']['defence'][1];
    }
    elseif (1 == $game_result['minute'] % 3)
    {
        $defence = $game_result[$team]['team']['power']['defence'][2];
    }
    else
    {
        $defence = $game_result[$team]['team']['power']['defence'][3];
    }

    $game_result[$team]['team']['power']['defence']['current'] = $defence;

    return $game_result;
}