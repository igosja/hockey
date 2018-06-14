<?php

/**
 * Отримуємо массив матчів за швейцарською системою
 * @param $tournamenttype_id integer
 * @param $stage_id integer
 * @return array
 */
function f_igosja_swiss_game($tournamenttype_id, $stage_id)
{
    $position_difference = 1;

    $team_array = f_igosja_swiss_prepare($tournamenttype_id);
    $game_array = f_igosja_swiss($tournamenttype_id, $position_difference, $team_array, $stage_id);

    return $game_array;
}