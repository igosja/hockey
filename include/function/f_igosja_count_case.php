<?php

/**
 * Відмінювання іменника після числа
 * @param $number integer число
 * @param $text_one string слово для 1
 * @param $text_two integer слово для 2-4
 * @param $text_five integer слово для 5-0
 * @return string рядок виду 'день/дня/дней'
 */
function f_igosja_count_case($number, $text_one, $text_two, $text_five)
{
    $number_10  = abs($number) % 100;
    $number     = $number_10 % 10;

    if ($number_10 >= 11 && $number_10 <= 19)
    {
        $result = $text_five;
    }
    elseif ($number >= 2 && $number <= 4)
    {
        $result = $text_two;
    }
    elseif (1 == $number)
    {
        $result = $text_one;
    }
    else
    {
        $result = $text_five;
    }

    return $result;
}