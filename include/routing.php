<?php

/**
 * @var $auth_userrole_id integer
 */

$file_name  = $_SERVER['PHP_SELF'];
$file_name  = explode('/', $file_name);
$chapter    = $file_name[1];
$file_name  = end($file_name);
$file_name  = explode('.', $file_name);
$file_name  = $file_name[0];
$tpl        = $file_name;
$controller = explode('_', $file_name);
$controller = $controller[0];

if (!in_array($controller, array('country'))) {
    $controller = '';
}

if ('admin' == $chapter)
{
    if (!isset($auth_user_id) || USERROLE_USER == $auth_userrole_id)
    {
        redirect('/admin_login.php');
    }

    include(__DIR__ . '/../include/filter.php');
}