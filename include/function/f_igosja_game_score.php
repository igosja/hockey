<?php

/**
 * Отображение счета на основе метки о том, сыгран ли матч
 * @param $played boolean метка о том, сыгран ли матч
 * @param $home_score integer шайбы хозяев
 * @param $guest_score integer шайбы гостей
 * @return string счет или ?:?
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