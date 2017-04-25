<?php

/**
 * Отметка о автосоставе
 * @param $auto boolean метка о автосоставе
 * @return string звездочка, если был автосостав
 */
function f_igosja_game_auto($auto)
{
    $result = '';

    if ($auto)
    {
        $result = '*';
    }

    return $result;
}