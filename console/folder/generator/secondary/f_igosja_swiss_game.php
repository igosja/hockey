<?php

/**
 * Отримуємо массив матчів за швейцарською системою
 * @param $tournamenttype_id integer
 * @return array
 */
function f_igosja_swiss_game($tournamenttype_id)
{
    $position_difference = 100;

    $team_array = f_igosja_swiss_prepare($tournamenttype_id);
    $game_array = f_igosja_swiss($tournamenttype_id, $position_difference, $team_array);

    return $game_array;
}