<?php

/**
 * Жереб ЛЧ однієї пари на етапі кваліфікації
 * @param $team_array array список команд, котрі треба прожеребкувати
 * @param $team_result_array array массив команд
 * @return array массив команд
 */
function f_igosja_league_one($team_array, $team_result_array = array())
{
    $home_team  = f_igosja_get_league_home_team($team_array);
    $guest_team = f_igosja_get_league_guest_team($team_array, $home_team);

    if (!$guest_team)
    {
        return false;
    }

    $team_result_array[] = array(
        'home'  => $home_team['team_id'],
        'guest' => $guest_team['team_id']
    );

    unset($team_array[0][$home_team['i']]);
    unset($team_array[1][$guest_team['i']]);

    $team_array = array(
        array_values($team_array[0]),
        array_values($team_array[1]),
    );

    if (count($team_array[0]))
    {
        $team_result_array = f_igosja_league_one($team_array, $team_result_array);
    }

    return $team_result_array;
}