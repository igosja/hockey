<?php

/**
 * Время последнего посещения
 * @param $date integer unix_timestamp
 * @return string онлайн или n минут назад или дата чч:мм дд.мм.гггг
 */
function f_igosja_ufu_last_visit($date)
{
    $min_5  = $date + 5 * 60;
    $min_60 = $date + 60 * 60;
    $now    = time();

    if ($min_5 >= $now)
    {
        $date = '<span class="red">онлайн</span>';
    }
    elseif ($min_60 >= $now)
    {
        $difference = $now - $date;
        $difference = $difference / 60;
        $difference = round($difference, 0);
        $date       = $difference . ' минут назад';
    }
    else
    {
        $date = date('H:i d.m.Y', $date);
    }

    return $date;
}