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

    include(__DIR__ . '/../include/filter.php');
}