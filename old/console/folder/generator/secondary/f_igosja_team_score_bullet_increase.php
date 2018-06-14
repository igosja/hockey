<?php

/**
 * Записуємо дані про реалізований буліт в масив команди
 * @param $game_result array
 * @param $team string home або guest
 * @return array
 */
function f_igosja_team_score_bullet_increase($game_result, $team)
{
    $game_result[$team]['team']['score']['bullet']++;

    return $game_result;
}