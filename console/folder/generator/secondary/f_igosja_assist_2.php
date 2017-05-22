<?php

/**
 * Визначаемо вірогідність шайби, що закинули з двох передач
 * та вибираємо позицію асистента
 * @param $game_result array
 * @param $team string home або guest
 * @return array
 */
function f_igosja_assist_2($game_result, $team)
{
    if (0 == rand(0, 4))
    {
        $game_result = f_igosja_select_assist_2($game_result, $team);
    }
    else
    {
        $game_result['assist_2'] = 0;
    }

    return $game_result;
}