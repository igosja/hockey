<?php

/**
 * @var $country_link_array array
 * @var $file_name string
 * @var $num_get integer
 */

$table_link = array();

foreach ($country_link_array as $item) {
    if ($item['url'] == $file_name) {
        $table_link[] = '<span class="strong">' . $item['text'] . '</span>';
    } else {
        $table_link[] = '<a href="/' . $item['url'] . '.php?num=' . $num_get . '">' . $item['text'] . '</a>';
    }
}

$table_link = implode(' | ', $table_link);

print $table_link;