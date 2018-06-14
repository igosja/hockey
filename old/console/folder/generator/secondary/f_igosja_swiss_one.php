<?php

/**
 * Жереб за швейцарською системою однієї пари
 * @param $tournamenttype_id integer
 * @param $position_difference integer різниця в позиції
 * @param $game_array array массив матчів
 * @return array массив матчів
 */
function f_igosja_swiss_one($tournamenttype_id, $position_difference, $team_array, $game_array = array())
{
    $home_team  = f_igosja_get_swiss_home_team($team_array);
    $guest_team = f_igosja_get_swiss_guest_team($team_array, $home_team, $position_difference);

    if (!$home_team || !$guest_team)
    {
        return array();
    }

    $game_array[] = array(
        'home'  => $home_team['team_id'],
        'guest' => $guest_team['team_id']
    );

    unset($team_array[$home_team['i']]);
    unset($team_array[$guest_team['i']]);

    $team_array = array_values($team_array);

    if (count($team_array))
    {
        $game_array = f_igosja_swiss_one($tournamenttype_id, $position_difference, $team_array, $game_array);
    }

    return $game_array;
}