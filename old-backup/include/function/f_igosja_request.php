<?php

/**
 * Обгортка для роботи з масивом $_REQUEST
 * @param $var string назва параметра в масиві $_REQUEST
 * @param $subvar string назва параметра в масиві $_REQUEST[$var]
 * @return mixed значення параметра
 */
function f_igosja_request($var, $subvar = '')
{
    if ($subvar)
    {
        if (isset($_REQUEST[$var][$subvar]))
        {
            $result = $_REQUEST[$var][$subvar];
        }
        else
        {
            $result = '';
        }
    }
    else
    {
        if (isset($_REQUEST[$var]))
        {
            $result = $_REQUEST[$var];
        }
        else
        {
            $result = '';
        }
    }

    return $result;
}