<?php

/**
 * @var $auth_admin_user_id integer
 * @var $chapter string
 */

if ('admin' == $chapter)
{
    if (!isset($auth_admin_user_id))
    {
        redirect('/admin_login.php');
    }

    if (!in_array(f_igosja_get_user_ip(), f_igosja_get_user_ip_allowed()))
    {
        unset($_SESSION['admin_user_id']);
        redirect('/admin_login.php');
    }

    include(__DIR__ . '/../include/filter.php');
}