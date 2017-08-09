<?php

include(__DIR__ . '/../include/include.php');

function read_dir_to_array($file_array, $dir, $exception_array)
{
    $files = scandir($dir);
    $files = array_slice($files, 2);

    foreach ($files as $item)
    {
        $file_path          = $dir . $item;
        $dir_to_array       = str_replace(__DIR__ . '/../', '', $dir);
        $file_path_to_array = $dir_to_array . $item;

        if (is_file($file_path))
        {
            if (!in_array($file_path_to_array, $exception_array['file']))
            {
                $file_array[] = $file_path_to_array;
            }
        }
        elseif (is_dir($file_path))
        {
            if (!in_array($file_path_to_array, $exception_array['folder']))
            {
                $file_array = read_dir_to_array($file_array, $file_path . '/', $exception_array);
            }
        }
    }

    return $file_array;
}

$exception_array = array(
    'folder' => array(
        '.git',
    ),
    'file' => array(

    ),
);

$file_array = array();

$file_array = read_dir_to_array($file_array, __DIR__ . '/../', $exception_array);

$breadcrumb_array[] = 'Code review';

include(__DIR__ . '/view/layout/main.php');