<?php

$start_time = microtime(true);

ini_set('memory_limit', '2048M');
set_time_limit(0);
date_default_timezone_set('Europe/Moscow');

include (__DIR__ . '/database.php');
include (__DIR__ . '/function.php');
include (__DIR__ . '/constant.php');

$file_list = scandir(__DIR__ . '/../console/folder/generator/function');
$file_list = array_slice($file_list, 2);

foreach ($file_list as $item)
{
    include(__DIR__ . '/../console/folder/generator/function/' . $item);
}

//$sql = "TRUNCATE `debug`";
//$mysqli->query($sql);