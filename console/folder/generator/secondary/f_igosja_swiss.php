<?php

/**
 * Жереб за швейцарською системою
 * @param $tournamenttype_id integer
 * @param $position_difference integer різниця в позиції (починаємо з мінімума і поступово збільшуємо)
 * @param $team_array array список команд, котрі треба прожеребкувати
 * @return array массив з матчами
 */
function f_igosja_swiss($tournamenttype_id, $position_difference, $team_array)
{
    if (!$game_array = f_igosja_swiss_one($tournamenttype_id, $position_difference, $team_array))
    {
        $position_difference++;

        $game_array = f_igosja_swiss($tournamenttype_id, $position_difference, $team_array);
    }

    return $game_array;
}