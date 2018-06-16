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
        if ($score_difference < $should_win + 1)
        {
            $result = true;
        }
    }
    else
    {
        if ($score_difference < -$should_win + 1)
        {
            $result = true;
        }
    }

    return $result;
}