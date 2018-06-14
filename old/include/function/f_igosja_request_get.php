<?php

/**
 * Обгортка для роботи з масивом $_GET
 * @param $var string назва параметра в масиві $_GET
 * @param $subvar string назва параметра в масиві $_GET[$var]
 * @return mixed значення параметра
 */
function f_igosja_request_get($var, $subvar = '')
{
    if ($subvar)
    {
        if (isset($_GET[$var][$subvar]))
        {
            $result = $_GET[$var][$subvar];
        }
        else
        {
            $result = '';
        }
    }
    else
    {
        if (isset($_GET[$var]))
        {
            $result = $_GET[$var];
        }
        else
        {
            $result = '';
        }
    }

    return $result;
}