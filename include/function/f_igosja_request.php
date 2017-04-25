<?php

/**
 * Обертка для работы с массивом $_REQUEST
 * @param $var string название параметра в массиве $_REQUEST
 * @param $subvar string название параметра в массиве $_REQUEST[$var]
 * @return mixed значение параметра
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