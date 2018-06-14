<?php

/**
 * Позиція на сторінці досягень
 * @param $achievement array дані з БД по поточному досягненню
 * @return string
 */
function f_igosja_achievement_position($achievement)
{
    if ($achievement['achievement_position'])
    {
        $result = $achievement['achievement_position'];
    }
    elseif ($achievement['stage_name'])
    {
        $result = $achievement['stage_name'];
    }
    else
    {
        $result = 'Чемпион';
    }

    return $result;
}