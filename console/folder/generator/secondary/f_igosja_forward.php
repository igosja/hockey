<?php

function f_igosja_forward($game_result, $team)
{
    if (0 == $game_result['minute'] % 3)
    {
        $forward = $game_result[$team]['team']['power']['forward'][1];
    }
    elseif (1 == $game_result['minute'] % 3)
    {
        $forward = $game_result[$team]['team']['power']['forward'][2];
    }
    else
    {
        $forward = $game_result[$team]['team']['power']['forward'][3];
    }

    $game_result[$team]['team']['power']['forward']['current'] = $forward;

    return $game_result;
}