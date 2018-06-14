<?php

/**
 * Стиль для вигранної/програнної колізії
 * @param $style_1 integer стиль першої команди
 * @param $style_2 integer стиль другої команди
 * @return string
 */

function f_igosja_css_style($style_1, $style_2)
{
    $result = '';

    if ((STYLE_POWER == $style_1 && STYLE_SPEED == $style_2) ||
        (STYLE_SPEED == $style_1 && STYLE_TECHNIQUE == $style_2) ||
        (STYLE_TECHNIQUE == $style_1 && STYLE_POWER == $style_2))
    {
        $result = 'font-green';
    }
    elseif ((STYLE_SPEED == $style_1 && STYLE_POWER == $style_2) ||
            (STYLE_TECHNIQUE == $style_1 && STYLE_SPEED == $style_2) ||
            (STYLE_POWER == $style_1 && STYLE_TECHNIQUE == $style_2))
    {
        $result = 'font-red';
    }

    return $result;
}