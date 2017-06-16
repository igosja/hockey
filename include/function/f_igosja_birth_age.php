<?php

/**
 * Формат вік іменниників на головній сторінці
 * @param $year integer рік народження
 * @return string рядок виду 'исполняется 20 лет'
 */
function f_igosja_birth_age($year)
{
    $age = date('Y') - $year;

    $last_number = $age % 10;

    if (($age > 10 && $age < 20) || in_array($last_number, array(0, 5, 6, 7, 8, 9)))
    {
        $end = ' лет';
    }
    elseif (in_array($last_number, array(2, 3, 4)))
    {
        $end = ' года';
    }
    else
    {
        $end = ' год';
    }

    $result = $age . $end;

    return $result;
}