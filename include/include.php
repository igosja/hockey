<?php

$start_time = microtime(true);

//$wind_php_command = 'D:\xampp\php\php-cgi.exe D:\xampp\htdocs\fm.local.net\www\generator\generator.php';
//$denw_php_command = '\usr\local\php5\php-cgi.exe \home\hockey.local\www\console\migrate\migrate';

include(__DIR__ . '/menu.php');
include(__DIR__ . '/constant.php');
include(__DIR__ . '/database.php');
include(__DIR__ . '/function.php');
include(__DIR__ . '/session.php');
include(__DIR__ . '/Mail.php');
include(__DIR__ . '/routing.php');