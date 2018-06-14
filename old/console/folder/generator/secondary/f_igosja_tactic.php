<?php

/**
 * Визначаємо тактику залежно від хвилини матчу
 * @param $game_result array
 * @return array
 */
function f_igosja_tactic($game_result)
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
            $tactic = $game_result[$team]['team']['tactic'][1];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $tactic = $game_result[$team]['team']['tactic'][2];
        }
        else
        {
            $tactic = $game_result[$team]['team']['tactic'][3];
        }

        $game_result[$team]['team']['tactic']['current'] = $tactic;
    }

    return $game_result;
}