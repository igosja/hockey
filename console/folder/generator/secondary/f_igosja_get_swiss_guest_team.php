<?php

/**
 * Вибираємо гостьову команду для швейцарського жеребу
 * @param $team_array array
 * @param $home_team array
 * @param $position_difference integer
 * @return array
 */
function f_igosja_get_swiss_guest_team($team_array, $home_team, $position_difference)
{
    for ($i=0, $count_team=count($team_array); $i<$count_team; $i++)
    {
        if (
            $team_array[$i]['swisstable_home'] >= $team_array[$i]['swisstable_guest']
            && $team_array[$i]['swisstable_place'] >= $home_team['place'] - $position_difference
            && $team_array[$i]['swisstable_place'] <= $home_team['place'] + $position_difference
            && $team_array[$i]['swisstable_team_id'] != $home_team['team_id']
            && in_array($home_team['team_id'], $team_array[$i]['opponent'])
            && in_array($team_array[$i]['swisstable_team_id'], $home_team['opponent'])
        )
        {
            return array(
                'i'         => $i,
                'team_id'   => $team_array[$i]['swisstable_team_id'],
            );
        }
    }

    return array();
}