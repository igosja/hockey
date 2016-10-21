<?php

$table_link = array();

foreach ($team_link_array as $item) {
    if ($item['url'] == $route_file) {
        $table_link[] = '<span class="strong">' . $item['text'] . '</span>';
    } else {
        $table_link[] = '<a href="/' . $route_path . '/' . $item['url'] . '/' . $num_get . '">' . $item['text'] . '</a>';
    }
}

$table_link = implode(' | ', $table_link);

print $table_link;

?>