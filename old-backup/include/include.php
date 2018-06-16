<?php

$start_time = microtime(true);

//\usr\local\php5\php.exe www\console\migrate
//\usr\local\php5\php.exe www\console\start
//\usr\local\php5\php.exe www\console\generator
//\usr\local\php5\php.exe www\console\environment dev

include(__DIR__ . '/menu.php');
include(__DIR__ . '/database.php');
include(__DIR__ . '/function.php');
include(__DIR__ . '/constant.php');
include(__DIR__ . '/breadcrumb.php');
include(__DIR__ . '/table_link.php');
include(__DIR__ . '/season.php');
include(__DIR__ . '/routing.php');
include(__DIR__ . '/session.php');
include(__DIR__ . '/autologin.php');
include(__DIR__ . '/Mail.php');
include(__DIR__ . '/admin_access.php');
include(__DIR__ . '/seo.php');
include(__DIR__ . '/site.php');