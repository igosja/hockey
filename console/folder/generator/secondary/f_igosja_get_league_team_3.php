<?php

/**
 * Вибираємо команду для 3 місця в групі ЛЧ
 * @param $team_array array
 * @param $team_1 array
 * @param $team_2 array
 * @return array
 */
function f_igosja_get_league_team_3($team_array, $team_1, $team_2)
{
    $shuffle_array = $team_array[2];

    shuffle($shuffle_array);

    foreach ($shuffle_array as $item)
    {
        if (!in_array($item['city_country_id'], array($team_1['country_id'], $team_2['country_id'])))
        {
            for ($i=0, $count_team=count($team_array[2]); $i<$count_team; $i++)
            {
                if ($team_array[2][$i]['team_id'] == $item['team_id'])
                {
                    return array(
                        'i'             => $i,
                        'team_id'       => $team_array[2][$i]['team_id'],
                        'country_id'    => $team_array[2][$i]['city_country_id'],
                    );
                }
            }
        }
    }

    return false;
}