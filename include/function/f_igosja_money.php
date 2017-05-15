<?php

/**
 * Форматирование денежных сумм
 * @param $price integer сумма
 * @return string отформатированная сумма
 */
function f_igosja_money($price)
{
    $price = number_format($price, 0, ',', ' ');
    $price = $price . ' $';

    return $price;
}