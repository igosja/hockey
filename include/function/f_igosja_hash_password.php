<?php

/**
 * Хешируем введенный через форму пароль
 * @param $password string введенный пароль
 * @return string захешированный пароль
 */
function f_igosja_hash_password($password)
{
    $password = md5($password . md5(PASSWORD_SALT));

    return $password;
}