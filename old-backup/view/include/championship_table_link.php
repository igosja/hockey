<?php

/**
 * @var $conference_array array
 * @var $country_id integer
 * @var $division_array array
 * @var $division_id integer
 * @var $season_id integer
 */

$table_link = array();

foreach ($division_array as $item) {
    if ($item['division_id'] == $division_id) {
        $table_link[] = '<span class="strong">' . $item['division_name'] . '</span>';
    } else {
        $table_link[] = '<a href="/championship.php?country_id=' . $country_id . '&division_id=' . $item['division_id'] . '&season_id=' . $season_id . '">' . $item['division_name'] . '</a>';
    }
}

if ($conference_array[0]['count'])
{
    $table_link[] = '<a href="/conference_table.php?season_id=' . $season_id . '&country_id=' . $country_id . '">КЛК</a>';
}

$table_link = implode(' | ', $table_link);

print $table_link;