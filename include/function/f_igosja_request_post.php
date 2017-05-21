<?php

/**
 * Обгортка для роботи з масивом $_POST
 * @param $var string назва параметра в масиві $_POST
 * @param $subvar string назва параметра в масиві $_POST[$var]
 * @return mixed значення параметра
 */
function f_igosja_request_post($var, $subvar = '')
{
    if ($subvar)
    {
        if (isset($_POST[$var][$subvar]))
        {
            $result = $_POST[$var][$subvar];
        }
        else
        {
            $result = '';
        }
    }
    else
    {
        if (isset($_POST[$var]))
        {
            $result = $_POST[$var];
        }
        else
        {
            $result = '';
        }
    }

    return $result;
}