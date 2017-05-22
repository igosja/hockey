<?php

/**
 * Рахуємо домашній бонус з урахуваннях типу матчу та кількості глядачів на трибунах
 * @param $game_result array
 * @param $game_bonus_home boolean наявність домашнього бонуса в даному типі матчу
 * @param $game_visitor integer кількість глядачів на грі
 * @param $game_stadium_capacity integer місткість стадіона
 * @return array
 */
function f_igosja_count_home_bonus($game_result, $game_bonus_home, $game_visitor, $game_stadium_capacity)
{
    if ($game_bonus_home)
    {
        $game_result['game_info']['home_bonus'] = 1 + $game_visitor / $game_stadium_capacity / 10;
    }
    else
    {
        $game_result['game_info']['home_bonus'] = 1;
    }

    return $game_result;
}