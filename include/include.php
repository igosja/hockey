<?php

$start_time = microtime(true);

//\usr\local\php5\php-cgi.exe www\console\migrate
//\usr\local\php5\php-cgi.exe www\console\generator

include(__DIR__ . '/menu.php');
include(__DIR__ . '/database.php');
include(__DIR__ . '/function.php');
include(__DIR__ . '/constant.php');
include(__DIR__ . '/session.php');
include(__DIR__ . '/Mail.php');
include(__DIR__ . '/routing.php');
include(__DIR__ . '/site.php');