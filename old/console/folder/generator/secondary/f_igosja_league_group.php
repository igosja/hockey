<?php

/**
 * Жереб ЛЧ однієї группи
 * @param $team_array array список команд, котрі треба прожеребкувати
 * @param $team_result_array array массив команд
 * @return array массив команд
 */
function f_igosja_league_group($team_array, $team_result_array = array(), $group_number = 1)
{
    $team_1 = f_igosja_get_league_team_1($team_array);
    $team_2 = f_igosja_get_league_team_2($team_array, $team_1);

    if (!$team_2)
    {
        return false;
    }

    $team_3 = f_igosja_get_league_team_3($team_array, $team_1, $team_2);

    if (!$team_3)
    {
        return false;
    }

    $team_4 = f_igosja_get_league_team_4($team_array, $team_1, $team_2, $team_3);

    if (!$team_4)
    {
        return false;
    }

    $team_result_array[$group_number] = array(
        $team_1['team_id'],
        $team_2['team_id'],
        $team_3['team_id'],
        $team_4['team_id'],
    );

    unset($team_array[0][$team_1['i']]);
    unset($team_array[1][$team_2['i']]);
    unset($team_array[2][$team_3['i']]);
    unset($team_array[3][$team_4['i']]);

    $team_array = array(
        array_values($team_array[0]),
        array_values($team_array[1]),
        array_values($team_array[2]),
        array_values($team_array[3]),
    );

    if (count($team_array[0]))
    {
        $group_number++;
        $team_result_array = f_igosja_league_group($team_array, $team_result_array, $group_number);
    }

    return $team_result_array;
}