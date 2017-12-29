<?php

/**
 * Обгортка для роботи з масивом $_COOKIE
 * @param $var string назва параметра в масиві $_COOKIE
 * @return mixed значення параметра
 */
function f_igosja_cookie($var)
{
    if (isset($_COOKIE[$var]))
    {
        $result = $_COOKIE[$var];
    }
    else
    {
        $result = '';
    }

    return $result;
}