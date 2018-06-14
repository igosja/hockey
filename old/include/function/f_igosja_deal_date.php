<?php

/**
 * Дата проведення торгів на ринках
 * @param $date integer timestamp коли гравця виставили на ринок
 * @return integer
 */
function f_igosja_deal_date($date)
{
    $today = strtotime(date('Y-m-d 12:00:00'));

    if ($today < $date + 86400 || $today < time())
    {
        $today = $today + 86400;
    }

    return f_igosja_ufu_date($today);
}