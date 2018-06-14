<?php

/**
 * @var $country_id integer
 * @var $division_id integer
 * @var $num_get integer
 * @var $round_id integer
 * @var $season_id integer
 */

$table_link = array();

foreach ($championship_round_array as $item) {
    if ($item['round_id'] == $round_id) {
        $table_link[] = '<span class="strong">' . $item['text'] . '</span>';
    } else {
        $table_link[] = '<a href="/championship_statistic.php?country_id=' . $country_id . '&division_id=' . $division_id . '&round_id=' . $item['round_id'] . '&season_id=' . $season_id . '&num=' . $num_get . '">' . $item['text'] . '</a>';
    }
}

$table_link = implode(' | ', $table_link);

print $table_link;