<?php

/**
 * Формат дати
 * @param $date integer unix_timestamp
 * @return string дата дд.мм.рррр
 */
function f_igosja_ufu_date($date)
{
    return date('d.m.Y', $date);
}