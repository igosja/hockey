<?php

/**
 * Зменшуємо штрафні хвилини команд у матчі
 * @param $game_result array
 * @return array
 */
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

        for ($j=0; $j<$count_penalty; $j++)
        {
            if (0 == $j)
            {
                if ($game_result['minute'] < $penalty_array_old[$j]['minute'] + 2)
                {
                    $penalty_array_new[] = $penalty_array_old[$j];
                }
            }
            elseif ($j > 1)
            {
                $penalty_array_new[] = array(
                    'minute' => $game_result['minute'],
                    'position' => $penalty_array_old[$j]['position'],
                );
            }
            else
            {
                $penalty_array_new[] = $penalty_array_old[$j];
            }
        }

        $game_result[$team]['team']['penalty']['current'] = $penalty_array_new;
    }

    return $game_result;
}