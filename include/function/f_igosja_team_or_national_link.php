<?php

/**
 * Формуємо посилання на команду або на збірну на основі даних з БД
 * @param $team_array array массив з даними команди
 * @param $national_array array массив з даними збірної
 * @param $full boolean назва с містом, країною чи без
 * @param $link boolean посилання на команду чи просто текстова назва
 * @return string
 */
function f_igosja_team_or_national_link($team_array, $national_array, $full = true, $link = true)
{
    if (0 != $team_array['team_id'])
    {
        $name = $team_array['team_name'];

        if (true == $full)
        {
            $name = $name
                    . ' <span class="hidden-xs">('
                    . $team_array['city_name']
                    . ', '
                    . $team_array['country_name']
                    . ')</span>';
        }

        if (true == $link)
        {
            $result = '<a href="/team_view.php?num='
                    . $team_array['team_id']
                    . '">'
                    . $name
                    . '</a>';
        }
        else
        {
            $result = $name;
        }
    }
    else
    {
        $name = $national_array['country_name'];

        if ($full)
        {
            $name = $name
                    . ' <span class="hidden-xs">('
                    . $national_array['nationaltype_name']
                    . ')</span>';
        }

        if (true == $link)
        {
            $result = '<a href="/national_view.php?num='
                    . $national_array['national_id']
                    . '">'
                    . $name
                    . '</a>';
        }
        else
        {
            $result = $name;
        }
    }

    return $result;
}