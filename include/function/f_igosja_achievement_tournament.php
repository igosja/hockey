<?php

/**
 * Назва турніру на сторінці досягень
 * @param $achievement array дані з БД по поточному досягненню
 * @return string
 */
function f_igosja_achievement_tournament($achievement)
{
    $result = $achievement['tournamenttype_name'];

    if (TOURNAMENTTYPE_CHAMPIONSHIP == $achievement['tournamenttype_id'])
    {
        if (0 != $achievement['achievement_position'])
        {
            $result = $result . ', регулярный сезон';
        }
        else
        {
            $result = $result . ', плейофф';
        }
    }

    if ($achievement['country_id'] || $achievement['division_id'])
    {
        $additional = array();

        if ($achievement['country_id'])
        {
            $additional[] = $achievement['country_name'];
        }

        if ($achievement['division_id'])
        {
            $additional[] = $achievement['division_name'];
        }

        $result = $result . ' (' . implode(', ', $additional) . ')';
    }

    return $result;
}