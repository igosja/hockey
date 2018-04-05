<?php

/**
 * Визначаємо чи може команда закинути гол
 * @param $game_result array
 * @param $should_win integer хто має вигарти
 * @param $team string home або guest
 * @param $opponent string home або guest
 * @return boolean
 */
function f_igosja_can_score($game_result, $should_win, $team, $opponent)
{
    $result = false;

    $score_difference = $game_result[$team]['team']['score']['total'] - $game_result[$opponent]['team']['score']['total'];

    if ('home' == $team)
    {
        if (in_array($should_win, array(0, 1)))
        {
            $result = true;
        }
        elseif (-1 == $should_win && $score_difference <= -2)
        {
            $result = true;
        }
    }
    else
    {
        if (in_array($should_win, array(0, -1)))
        {
            $result = true;
        }
        elseif (1 == $should_win && $score_difference <= -2)
        {
            $result = true;
        }
    }

    return $result;
}