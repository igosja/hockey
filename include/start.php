<?php

$start_time = microtime(true);

ini_set('memory_limit', '2048M');
date_default_timezone_set('Europe/Moscow');

include(__DIR__ . '/database.php');
include(__DIR__ . '/function.php');
include(__DIR__ . '/constant.php');
include(__DIR__ . '/season.php');

$file_list = scandir(__DIR__ . '/../console/folder/start/function');
$file_list = array_slice($file_list, 2);

foreach ($file_list as $item)
{
    include(__DIR__ . '/../console/folder/start/function/' . $item);
}