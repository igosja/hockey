<?php

/**
 * Назва турніру на сторінці досягень
 * @param $achievement array дані з БД по поточному досягненню
 * @return string
 */

function f_igosja_achievement_tournament($achievement)
{
    $result = $achievement['tournamenttype_name'];

    if ($achievement['country_name'] || $achievement['division_name'])
    {
        $additional = [];

        if ($achievement['country_name'])
        {
            $additional[] = $achievement['country_name'];
        }

        if ($achievement['division_name'])
        {
            $additional[] = $achievement['division_name'];
        }

        $result = $result . ' (' . implode(', ', $additional) . ')';
    }

    return $result;
}