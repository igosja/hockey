<?php

function f_igosja_game_with_bullet($game_result)
{
    $game_result['home']['player']['gk']['game_with_bullet']    = 1;
    $game_result['guest']['player']['gk']['game_with_bullet']   = 1;

    return $game_result;
}