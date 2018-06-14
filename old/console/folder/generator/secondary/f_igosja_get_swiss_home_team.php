<?php

/**
 * Вибираємо домашню команду для швейцарського жеребу
 * @param $team_array array
 * @return array массив матчів
 */
function f_igosja_get_swiss_home_team($team_array)
{
    for ($i=0, $count_team=count($team_array); $i<$count_team; $i++)
    {
        if ($team_array[$i]['swisstable_home'] <= $team_array[$i]['swisstable_guest'])
        {
            return array(
                'i'         => $i,
                'team_id'   => $team_array[$i]['swisstable_team_id'],
                'place'     => $team_array[$i]['swisstable_place'],
                'opponent'  => $team_array[$i]['opponent'],
            );
        }
    }

    return array();
}