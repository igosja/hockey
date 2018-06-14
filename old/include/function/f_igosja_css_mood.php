<?php

/**
 * Стиль для налаштованості на гру
 * @param $mood_id integer налаштованість
 * @return string
 */

function f_igosja_css_mood($mood_id)
{
    $result = '';

    if (MOOD_SUPER == $mood_id)
    {
        $result = 'font-green';
    }
    elseif (MOOD_REST == $mood_id)
    {
        $result = 'font-red';
    }

    return $result;
}