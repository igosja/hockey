<?php

function f_igosja_after_teamwork($game_result, $team)
{
    for ($i=1; $i<=3; $i++)
    {
        $defence = $game_result[$team]['team']['power']['defence'][$i];
        $forward = $game_result[$team]['team']['power']['forward'][$i];
        $teamwork = $game_result[$team]['team']['teamwork'][$i];
        $game_result[$team]['team']['power']['defence'][$i] = round($defence + $defence * $teamwork / TEAMWORK_MAX);
        $game_result[$team]['team']['power']['forward'][$i] = round($forward + $forward * $teamwork / TEAMWORK_MAX);
    }

    $game_result[$team]['team']['power']['total']
        = $game_result[$team]['team']['power']['gk']
        + $game_result[$team]['team']['power']['defence'][1]
        + $game_result[$team]['team']['power']['defence'][2]
        + $game_result[$team]['team']['power']['defence'][3]
        + $game_result[$team]['team']['power']['forward'][1]
        + $game_result[$team]['team']['power']['forward'][2]
        + $game_result[$team]['team']['power']['forward'][3];

    return $game_result;
}