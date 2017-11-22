<?php

/**
 * @var $file_name string
 * @var $register_link_array array
 */

$table_link = array();

foreach ($register_link_array as $item)
{
    if (in_array($file_name, array($item['url'], $item['url2'])))
    {
        $table_link[] = '<span class="strong">' . $item['text'] . '</span>';
    }
    else
    {
        $table_link[] = '<a href="/' . $item['url'] . '.php">' . $item['text'] . '</a>';
    }
}

$table_link = implode(' | ', $table_link);

print $table_link;