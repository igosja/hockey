<?php

/**
 * Додаєто обов'язковий плюс до додатніх чисел
 * @param $value integer
 * @return string
 */

function f_igosja_plus_necessary($value)
{
    if ($value > 0)
    {
        $result = '+' . $value;
    }
    else
    {
        $result = $value;
    }

    return $result;
}