<?php

function f_igosja_select_player_shot($game_result, $team)
{
    $game_result['player']  = rand(POSITION_LD, POSITION_RW);
    $penalty_position       = f_igosja_penalty_position_array($game_result, $team);

    if (in_array($game_result['player'], $penalty_position))
    {
        $game_result = f_igosja_select_player_shot($game_result, $team);
    }

    return $game_result;
}