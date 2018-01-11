<?php

$start_time = microtime(true);

date_default_timezone_set('Europe/Moscow');

include(__DIR__ . '/database.php');
include(__DIR__ . '/function.php');
include(__DIR__ . '/constant.php');
include(__DIR__ . '/season.php');

$file_list = scandir(__DIR__ . '/../console/folder/generator/function');
$file_list = array_slice($file_list, 2);

foreach ($file_list as $item)
{
    include(__DIR__ . '/../console/folder/generator/function/' . $item);
}

$file_list = scandir(__DIR__ . '/../console/folder/generator/secondary');
$file_list = array_slice($file_list, 2);

foreach ($file_list as $item)
{
    include(__DIR__ . '/../console/folder/generator/secondary/' . $item);
}

$file_list = scandir(__DIR__ . '/../console/folder/generator/newseason');
$file_list = array_slice($file_list, 2);

foreach ($file_list as $item)
{
    include(__DIR__ . '/../console/folder/generator/newseason/' . $item);
}