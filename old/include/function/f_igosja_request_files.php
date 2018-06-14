<?php

/**
 * Обгортка для роботи з масивом $_FILES
 * @param $var string назва параметра в масиві $_FILES
 * @param $subvar string назва параметра в масиві $_FILES[$var]
 * @return mixed значення параметра
 */
function f_igosja_request_files($var, $subvar = '')
{
    if ($subvar)
    {
        if (isset($_FILES[$var][$subvar]))
        {
            $result = $_FILES[$var][$subvar];
        }
        else
        {
            $result = '';
        }
    }
    else
    {
        if (isset($_FILES[$var]))
        {
            $result = $_FILES[$var];
        }
        else
        {
            $result = '';
        }
    }

    return $result;
}