<?php

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