<?php

/**
 * Форматирование даты
 * @param $date integer unix_timestamp
 * @return string дата дд.мм.гггг
 */
function f_igosja_ufu_date($date)
{
    return date('d.m.Y', $date);
}