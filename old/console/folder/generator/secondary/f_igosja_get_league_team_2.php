<?php

/**
 * Вибираємо команду для 2 місця в групі ЛЧ
 * @param $team_array array
 * @param $team_1 array
 * @return array
 */
function f_igosja_get_league_team_2($team_array, $team_1)
{
    $shuffle_array = $team_array[1];

    shuffle($shuffle_array);

    foreach ($shuffle_array as $item)
    {
        if ($item['city_country_id'] != $team_1['country_id'])
        {
            for ($i=0, $count_team=count($team_array[1]); $i<$count_team; $i++)
            {
                if ($team_array[1][$i]['team_id'] == $item['team_id'])
                {
                    return array(
                        'i'             => $i,
                        'team_id'       => $team_array[1][$i]['team_id'],
                        'country_id'    => $team_array[1][$i]['city_country_id'],
                    );
                }
            }
        }
    }

    return false;
}