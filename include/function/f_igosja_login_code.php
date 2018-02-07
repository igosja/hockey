<?php

/**
 * Формуюємо код для автовходу через cookie
 * @param $user_code string user_code з БД
 * @return string
 */
function f_igosja_login_code($user_code)
{
    if (isset($_SERVER['HTTP_USER_AGENT']))
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
    }
    else
    {
        $user_agent = '';
    }

    $login_code = md5($user_agent . $user_code);

    return $login_code;
}