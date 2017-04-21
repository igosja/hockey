<?php

function f_igosja_collision($game_result)
{
    for ($i=0; $i<2; $i++)
    {
        if (0 == $i)
        {
            $team       = TEAM_HOME;
            $opponent   = TEAM_GUEST;
        }
        else
        {
            $team       = TEAM_GUEST;
            $opponent   = TEAM_HOME;
        }

        for ($j=1; $j<=3; $j++)
        {
            if ((STYLE_POWER == $game_result[$team]['team']['style'][$i] && STYLE_SPEED == $game_result[$opponent]['team']['style'][$i]) ||
                (STYLE_SPEED == $game_result[$team]['team']['style'][$i] && STYLE_TECHNIQUE == $game_result[$opponent]['team']['style'][$i]) ||
                (STYLE_TECHNIQUE == $game_result[$team]['team']['style'][$i] && STYLE_POWER == $game_result[$opponent]['team']['style'][$i]))
            {
                $game_result[$team]['team']['collision'][$i]        = 1;
                $game_result[$team]['opponent']['collision'][$i]    = -1;
            }
            elseif ((STYLE_SPEED == $game_result[$team]['team']['style'][$i] && STYLE_POWER == $game_result[$opponent]['team']['style'][$i]) ||
                    (STYLE_TECHNIQUE == $game_result[$team]['team']['style'][$i] && STYLE_SPEED == $game_result[$opponent]['team']['style'][$i]) ||
                    (STYLE_POWER == $game_result[$team]['team']['style'][$i] && STYLE_TECHNIQUE == $game_result[$opponent]['team']['style'][$i]))
            {
                $game_result[$team]['team']['collision'][$i]        = -1;
                $game_result[$team]['opponent']['collision'][$i]    = 1;
            }
        }
    }

    return $game_result;
}