<?php

/**
 * Форматирование даты рождения
 * @param $item array массив с данными пользователя после выборки из БД
 * @return string день рождения д.м.гггг или не указано
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