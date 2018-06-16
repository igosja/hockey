<?php

/**
 * Отримуємо список файлів проекту
 * @param $file_array array масив файлів
 * @param $dir string папка проекту
 * @param $exception_array array масив в винятками, котрі не будуть записуватись в масив файлів
 * @return array масив файлів
 */
function f_igosja_read_dir_to_array($file_array, $dir, $exception_array)
{
    $files = scandir($dir);
    $files = array_slice($files, 2);

    foreach ($files as $item)
    {
        $file_path          = $dir . $item;
        $dir_to_array       = str_replace(str_replace('include/function', 'admin/../',__DIR__), '', $dir);
        $dir_to_array       = str_replace(str_replace('include\function', 'admin/../',__DIR__), '', $dir_to_array);
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
                $file_array = f_igosja_read_dir_to_array($file_array, $file_path . '/', $exception_array);
            }
        }
    }

    return $file_array;
}