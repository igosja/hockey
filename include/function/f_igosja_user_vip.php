<?php

/**
 * Іконка VIP статусу за наявності
 * @param $user_date_vip integer timestamp завершення VIP
 * @return string
 */
function f_igosja_user_vip($user_date_vip)
{
    $result = '';

    if ($user_date_vip > time())
    {
        $result = '<img alt="VIP" src="/img/vip.png" title="VIP" />';
    }

    return $result;
}