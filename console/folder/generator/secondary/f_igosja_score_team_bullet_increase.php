<?php

function f_igosja_team_score_bullet_increase($game_result, $team)
{
    $game_result[$team]['team']['score']['bullet']++;

    return $game_result;
}