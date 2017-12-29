<?php

/**
 * @var $championship_round_array array
 * @var $country_id integer
 * @var $division_id integer
 * @var $round_id integer
 * @var $season_id integer
 */

$table_link = array();

foreach ($championship_round_array as $item) {
    if ($item['round_id'] == $round_id) {
        $table_link[] = '<span class="strong">' . $item['text'] . '</span>';
    } else {
        $table_link[] = '<a href="/championship.php?country_id=' . $country_id . '&division_id=' . $division_id . '&round_id=' . $item['round_id'] . '&season_id=' . $season_id . '">' . $item['text'] . '</a>';
    }
}

$table_link = implode(' | ', $table_link);

print $table_link;