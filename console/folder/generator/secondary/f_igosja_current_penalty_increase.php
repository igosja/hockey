<?php

function f_igosja_current_penalty_increase($game_result, $team)
{
    $game_result[$team]['team']['penalty']['current'][] = array(
        'minute' => $game_result['minute'],
        'position' => $game_result['player'],
    );

    return $game_result;
}