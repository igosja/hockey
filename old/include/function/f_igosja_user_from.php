<?php

/**
 * Формат інформації про те, звізки наш користувач
 * @param $item array масив с данними БД (`user`)
 * @return string місто і країна або 'Не указано'
 */
function f_igosja_user_from($item)
{
    if ('VHOL' == $item['country_name'])
    {
        $item['country_name'] = '';
    }

    if ($item['user_city'] && $item['country_name'])
    {
        $result = $item['user_city'] . ', ' . $item['country_name'];
    }
    elseif ($item['user_city'])
    {
        $result = $item['user_city'];
    }
    elseif ($item['country_name'])
    {
        $result = $item['country_name'];
    }
    else
    {
        $result = 'Не указано';
    }

    return $result;
}