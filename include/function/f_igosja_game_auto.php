<?php

/**
 * Відмітка про автосостав
 * @param $auto boolean мітка про автосостав
 * @return string зірочка, якщо був автосостав
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