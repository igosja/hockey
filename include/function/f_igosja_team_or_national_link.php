<?php

/**
 * Формуємо посилання на команду або на збірну на основі даних з БД
 * @param $team_array array массив з даними команди
 * @param $national_array array массив з даними збірної
 * @return string
 */
function f_igosja_team_or_national_link($team_array, $national_array)
{
    if (0 != $team_array['team_id'])
    {
        $result = '<a href="/team_view.php?num='
                . $team_array['team_id']
                . '">' . $team_array['team_name']
                . ' <span class="hidden-xs">('
                . $team_array['city_name']
                . ', '
                . $team_array['country_name']
                . ')</span></a>';
    }
    else
    {
        $result = '<a href="/national_view.php?num='
                . $national_array['national_id']
                . '">' . $national_array['country_name']
                . ' <span class="hidden-xs">('
                . $national_array['nationaltype_name']
                . ')</span></a>';
    }

    return $result;
}