<?php

/**
 * Обертка для работы с массивом $_GET
 * @param $var string название параметра в массиве $_GET
 * @param $subvar string название параметра в массиве $_GET[$var]
 * @return mixed значение параметра
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