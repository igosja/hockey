<?php

/**
 * Відображення рахунку на основі мітки про те, чи зіграли матч
 * @param $played boolean мітка про те, чи зіграли матч
 * @param $home_score integer шайби господарів
 * @param $guest_score integer шайби гостей
 * @return string рахунок або ?:?
 */
function f_igosja_game_score($played, $home_score, $guest_score)
{
    if ($played)
    {
        $result = $home_score . ':' . $guest_score;
    }
    else
    {
        $result = '?:?';
    }

    return $result;
}