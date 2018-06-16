<?php

/**
 * Формат вік іменниників на головній сторінці
 * @param $year integer рік народження
 * @return string рядок виду 'исполняется 20 лет'
 */
function f_igosja_birth_age($year)
{
    $age = date('Y') - $year;

    $result = $age . ' ' . f_igosja_count_case($age, 'год', 'года', 'лет');

    return $result;
}