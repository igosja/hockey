<?php

/**
 * Визначаємо силу нападу залежно від хвилини матчу
 * @param $game_result array
 * @return array
 */
function f_igosja_forward($game_result)
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

        if (0 == $game_result['minute'] % 3)
        {
            $forward = $game_result[$team]['team']['power']['forward'][1];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $forward = $game_result[$team]['team']['power']['forward'][2];
        }
        else
        {
            $forward = $game_result[$team]['team']['power']['forward'][3];
        }

        $game_result[$team]['team']['power']['forward']['current'] = $forward;
    }

    return $game_result;
}