<?php

function f_igosja_money($price)
{
    $price = number_format($price, 0, ',', ' ');
    $price = $price . ' $';

    return $price;
}