<?php

/**
 * Формат дати
 * @param $date integer unix_timestamp
 * @return string дата дд.мм.рррр
 */
function f_igosja_ufu_date($date)
{
    if (1528707600 == $date) {
        $date = $date - 24*60*60;
    }
    return date('d.m.Y', $date);
}