<?php

/**
 * Вибираємо несіяну команду для кваліфікації ЛЧ
 * @param $team_array array
 * @param $home_team array
 * @return array
 */
function f_igosja_get_league_guest_team($team_array, $home_team)
{
    $shuffle_array = $team_array[1];

    shuffle($shuffle_array);

    foreach ($shuffle_array as $item)
    {
        if ($item['city_country_id'] != $home_team['country_id'])
        {
            for ($i=0, $count_team=count($team_array[1]); $i<$count_team; $i++)
            {
                if ($team_array[1][$i]['team_id'] == $item['team_id'])
                {
                    return array(
                        'i'         => $i,
                        'team_id'   => $team_array[1][$i]['team_id'],
                    );
                }
            }
        }
    }

    return false;
}