<?php

/**
 * Рахуємо відсотки оптимальності
 * @param $game_result array
 * @return array
 */
function f_igosja_optimality($game_result)
{
    $home_power_real        = $game_result['home']['team']['power']['total'];
    $home_power_optimal     = $game_result['home']['team']['power']['optimal'];

    if (0 == $home_power_optimal)
    {
        $home_power_optimal = 1;
    }

    $home_optimal_1 = round($home_power_real / $home_power_optimal * 100);

    $guest_power_real       = $game_result['guest']['team']['power']['total'];
    $guest_power_optimal    = $game_result['guest']['team']['power']['optimal'];

    if (0 == $guest_power_optimal)
    {
        $guest_power_optimal = 1;
    }

    $guest_optimal_1 = round($guest_power_real / $guest_power_optimal * 100);

    $home_forecast = $game_result['home']['team']['power']['forecast'];

    if (0 == $home_forecast)
    {
        $home_forecast = 1;
    }

    $home_optimal_2 = round($home_power_real / $game_result['game_info']['home_bonus'] / $home_forecast * 100);

    $guest_forecast = $game_result['guest']['team']['power']['forecast'];

    if (0 == $guest_forecast)
    {
        $guest_forecast = 1;
    }

    $guest_optimal_2 = round($guest_power_real / $guest_forecast * 100);

    if (0 == $home_power_real)
    {
        $home_power_real = 1;
    }

    if (0 == $guest_power_real)
    {
        $guest_power_real = 1;
    }

    $team_power_total       = $home_power_real + $guest_power_real;
    $home_power_percent     = round($home_power_real / $team_power_total * 100);
    $guest_power_percent    = 100 - $home_power_percent;

    $game_result['home']['team']['optimality_1']        = $home_optimal_1;
    $game_result['home']['team']['optimality_2']        = $home_optimal_2;
    $game_result['home']['team']['power']['percent']    = $home_power_percent;
    $game_result['guest']['team']['optimality_1']       = $guest_optimal_1;
    $game_result['guest']['team']['optimality_2']       = $guest_optimal_2;
    $game_result['guest']['team']['power']['percent']   = $guest_power_percent;

    return $game_result;
}