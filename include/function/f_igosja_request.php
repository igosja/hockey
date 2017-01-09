<?php

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