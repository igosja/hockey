<?php

/**
 * Час останнього візиту на сайт
 * @param $date integer unix_timestamp
 * @return string 'онлайн' або 'n минут назад' або дата гг:хх дд.мм.рррр
 */
function f_igosja_ufu_last_visit($date)
{
    $min_5  = $date + 5 * 60;
    $min_60 = $date + 60 * 60;
    $now    = time();

    if ($min_5 >= $now)
    {
        $date = '<span class="red">online</span>';
    }
    elseif ($min_60 >= $now)
    {
        $difference = $now - $date;
        $difference = $difference / 60;
        $difference = round($difference, 0);
        $date       = $difference . ' ' . f_igosja_count_case($difference, 'минуту', 'минуты', 'минут') . ' назад';
    }
    elseif (0 == $date)
    {
        $date = '-';
    }
    else
    {
        $date = date('H:i d.m.Y', $date);
    }

    return $date;
}