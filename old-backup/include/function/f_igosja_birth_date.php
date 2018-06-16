<?php

/**
 * Формат дати народження
 * @param $item array массив з даними з таблиці user
 * @return string день нарождення д.м.рррр або 'Не указан'
 */
function f_igosja_birth_date($item)
{
    if ($item['user_birth_day'] && $item['user_birth_day'] && $item['user_birth_year'])
    {
        $result = $item['user_birth_day'] . '.' . $item['user_birth_month'] . '.' . $item['user_birth_year'];
    }
    else
    {
        $result = 'Не указан';
    }

    return $result;
}