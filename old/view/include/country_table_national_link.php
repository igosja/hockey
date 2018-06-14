<?php

/**
 * @var $file_name string
 * @var $nationaltype_get integer
 * @var $num_get integer
 */

$table_link = array();

foreach ($nationaltype_array as $item) {
    if ($item['nationaltype_id'] == $nationaltype_get) {
        $table_link[] = '<span class="strong">' . $item['nationaltype_name'] . '</span>';
    } else {
        $table_link[] = '<a href="/country_national.php?num=' . $num_get . '&nationaltype=' . $item['nationaltype_id'] . '">' . $item['nationaltype_name'] . '</a>';
    }
}

$table_link = implode(' | ', $table_link);

print $table_link;