<?php

/**
 * Вибираємо команду для 1 місця в групі ЛЧ
 * @param $team_array array
 * @return array массив матчів
 */
function f_igosja_get_league_team_1($team_array)
{
    $team = array_rand($team_array[0]);

    return array(
        'i'             => $team,
        'team_id'       => $team_array[0][$team]['team_id'],
        'country_id'    => $team_array[0][$team]['city_country_id'],
    );
}