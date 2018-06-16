<?php

/**
 * @var $file_name string
 * @var $stadium_link_array array
 */

$table_link = array();

foreach ($stadium_link_array as $item) {
    if ($item['url'] == $file_name) {
        $table_link[] = '<span class="strong">' . $item['text'] . '</span>';
    } else {
        $table_link[] = '<a href="/' . $item['url'] . '.php">' . $item['text'] . '</a>';
    }
}

$table_link = implode(' | ', $table_link);

print $table_link;