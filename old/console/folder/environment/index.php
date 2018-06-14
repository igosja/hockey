<?php

/**
 * @var $argv array
 * @var $q array
 */

if (isset($argv[1]))
{
    if (in_array($argv[1], array('prod', 'dev')))
    {
        $path = __DIR__ . '/' . $argv[1];
        $file_array = scandir(__DIR__ . '/' . $argv[1]);
        $file_array = array_slice($file_array, 2);

        foreach ($file_array as $item)
        {
            $file_name = $path . '/' . $item;

            if (is_file($file_name))
            {
                copy($file_name, __DIR__ . '/../../../' . $item);
            }
        }
    }
    else
    {
        print 'Wrong command.' . "\r\n";
    }
}
else
{
    print 'Wrong command.' . "\r\n";
}