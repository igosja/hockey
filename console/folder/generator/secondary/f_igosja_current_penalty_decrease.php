<?php

function f_igosja_current_penalty_decrease($game_result)
{
    for ($i=0; $i<2; $i++)
    {
        if (0 == $i)
        {
            $team = TEAM_HOME;
        }
        else
        {
            $team = TEAM_GUEST;
        }

        $penalty_array_old = $game_result[$team]['team']['penalty']['current'];
        $penalty_array_new = array();

        $count_penalty = count($penalty_array_old);

        for ($i=0; $i<$count_penalty; $i++)
        {
            if (0 == $i)
            {
                if ($game_result['minute'] < $penalty_array_old[$i]['minute'] + 2)
                {
                    $penalty_array_new[] = $penalty_array_old[$i];
                }
            }
            elseif (1 < $i)
            {
                $penalty_array_new[] = array(
                    'minute' => $game_result['minute'],
                    'position' => $penalty_array_old[$i]['position'],
                );
            }
            else
            {
                $penalty_array_new[] = $penalty_array_old[$i];
            }
        }

        $game_result[$team]['team']['penalty']['current'] = $penalty_array_new;
    }

    return $game_result;
}