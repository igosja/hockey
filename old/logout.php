<?php

/**
 * @var $auth_user_id integer
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/');
}

session_destroy();
setcookie('login_code', '');

redirect('/');