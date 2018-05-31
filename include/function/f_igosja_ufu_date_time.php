<?php

/**
 * Формат часу і дати
 * @param $date integer unix_timestamp
 * @return string час і дата гг:хх дд.мм.рррр
 */
function f_igosja_ufu_date_time($date)
{
    if (1528707600 == $date) {
        $date = $date - 24*60*60;
    }
    return '<span class="hidden-xs">' . date('H:i', $date) . '</span> ' . date('d.m.Y', $date);
}