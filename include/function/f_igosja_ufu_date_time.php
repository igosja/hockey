<?php

/**
 * Формат часу і дати
 * @param $date integer unix_timestamp
 * @return string час і дата гг:хх дд.мм.рррр
 */
function f_igosja_ufu_date_time($date)
{
    return date('H:i d.m.Y', $date);
}