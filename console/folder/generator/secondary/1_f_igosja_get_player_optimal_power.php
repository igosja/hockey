<?php

function f_igosja_get_player_optiomal_power_1($real_power, $player_array, $game_result, $team, $opponent, $home_bonus)
{
    $power = $real_power * $home_bonus * $player_array['bonus'] * (100 + $game_result[$team]['team']['leader']) / 100;

    if (STYLE_POWER == $game_result[$team . '_style_id'])
    {
        if (STYLE_SPEED == $game_result[$opponent . '_style_id'])
        {
            $power = $power * 1.1;
        }
        elseif (STYLE_TECHNIQUE == $game_result[$opponent . '_style_id'])
        {
            $power = $power * 0.9;
        }
    }
    elseif (STYLE_SPEED == $game_result[$team . '_style_id'])
    {
        if (STYLE_TECHNIQUE == $game_result[$opponent . '_style_id'])
        {
            $power = $power * 1.1;
        }
        elseif (STYLE_POWER == $game_result[$opponent . '_style_id'])
        {
            $power = $power * 0.9;
        }
    }
    elseif (STYLE_TECHNIQUE == $game_result[$team . '_style_id'])
    {
        if (STYLE_POWER == $game_result[$opponent . '_style_id'])
        {
            $power = $power * 1.1;
        }
        elseif (STYLE_SPEED == $game_result[$opponent . '_style_id'])
        {
            $power = $power * 0.9;
        }
    }

    if (RUDE_RUDE == $game_result[$team . '_rude_id'])
    {
        $power = $power * 1.05;
    }

    if (MOOD_SUPER == $game_result[$team . '_mood_id'])
    {
        $power = $power * 1.1;
    }
    elseif (MOOD_REST == $game_result[$team . '_mood_id'])
    {
        $power = $power * 0.9;
    }

    return $power;
}