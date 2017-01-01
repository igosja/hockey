<?php

function f_igosja_count_home_bonus($game_result, $game_bonus_home, $game_visitor, $game_stadium_capacity)
{
    if ($game_bonus_home)
    {
        $game_result['game_info']['home_bonus'] = 1 + $game_visitor / $game_stadium_capacity / 10;
    }
    else
    {
        $game_result['game_info']['home_bonus'] = 1;
    }

    return $game_result;
}