<?php

function f_igosja_game_score($played, $home_score, $guest_score)
{
    if ($played)
    {
        $result = $home_score . ':' . $guest_score;
    }
    else
    {
        $result = '?:?';
    }

    return $result;
}