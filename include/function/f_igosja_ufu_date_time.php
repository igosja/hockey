<?php

/**
 * Форматирование времени
 * @param $date integer unix_timestamp
 * @return string дата чч:мм дд.мм.гггг
 */
function f_igosja_ufu_date_time($date)
{
    return date('H:i d.m.Y', $date);
}