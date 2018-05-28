<?php

/**
 * Отримуємо список дозволених ip для адміністрування сайту
 * @return array
 */

function f_igosja_get_user_ip_allowed()
{
    $result = array(
        '62.205.148.101',
        '127.0.0.1',
        '185.38.209.242',
    );

    return $result;
}