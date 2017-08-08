<?php

include(__DIR__ . '/../include/include.php');

function read_dir_to_array($file_array, $dir, $exception_array)
{
    $files = scandir($dir);

    foreach ($files as $item)
    {
        if (!in_array($item, $exception_array))
        {
            if (is_file($dir . $item))
            {
                $dir_to_array = str_replace(__DIR__ . '/../', '', $dir);
                $file_array[] = $dir_to_array . $item;
            }
            elseif (is_dir($dir . $item))
            {
                $file_array = read_dir_to_array($file_array, $dir . $item . '/', $exception_array);
            }
        }
    }

    return $file_array;
}

$exception_array = array(
    '.',
    '..',
    '.git',
    'font-awesome',
    'favicon.ico',
    'fonts',
    'img',
    '_data',
    '_output',
    '_support',
);

$file_array = array();

$file_array = read_dir_to_array($file_array, __DIR__ . '/../', $exception_array);

$breadcrumb_array[] = 'Code review';

include(__DIR__ . '/view/layout/main.php');