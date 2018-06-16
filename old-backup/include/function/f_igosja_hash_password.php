<?php

/**
 * Хешуємо введений через форму пароль
 * @param $password string введений пароль
 * @return string захешований пароль
 */
function f_igosja_hash_password($password)
{
    $password = md5($password . md5(PASSWORD_SALT));

    return $password;
}