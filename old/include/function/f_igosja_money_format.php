<?php

/**
 * Формат грошових сум
 * @param $price integer сума
 * @return string сума в потрібному форматі
 */
function f_igosja_money_format($price)
{
    $price = number_format($price, 0, ',', ' ');
    $price = $price . ' $';

    return $price;
}