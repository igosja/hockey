<?php

function f_igosja_user_from($item)
{
    if ($item['user_city'] && $item['country_name'])
    {
        $result = $item['user_city'] . ',' . $item['country_name'];
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