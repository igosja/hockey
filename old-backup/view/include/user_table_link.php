<?php

/**
 * @var $auth_user_id integer
 * @var $file_name string
 * @var $num_get integer
 * @var $user_link_array array
 */

$table_link = array();

foreach ($user_link_array as $item)
{
    if (($item['auth'] && isset($auth_user_id) && $auth_user_id == $num_get) || !$item['auth'])
    {
        if ($item['url'] == $file_name)
        {
            $table_link[] = '<span class="strong">' . $item['text'] . '</span>';
        }
        else
        {
            $table_link[] = '<a href="/' . $item['url'] . '.php?num=' . $num_get . '">' . $item['text'] . '</a>';
        }
    }
}

$table_link = implode(' | ', $table_link);

print $table_link;