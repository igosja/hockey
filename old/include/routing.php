<?php

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