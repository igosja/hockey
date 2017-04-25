<?php

/**
 * Обертка для работы с массивом $_POST
 * @param $var string название параметра в массиве $_POST
 * @param $subvar string название параметра в массиве $_POST[$var]
 * @return mixed значение параметра
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