<?php

function f_igosja_assist_1($game_result, $team)
{
    if (rand(0, 3))
    {
        $game_result = f_igosja_select_assist_1($game_result, $team);
    }
    else
    {
        $game_result['assist_1'] = 0;
    }

    return $game_result;
}