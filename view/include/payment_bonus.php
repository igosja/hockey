<?php

/**
 * @var $bonus_array array
 * @var $total_sum integer
 */

$bonus = array();

foreach ($bonus_array as $key => $value) {
    if ($total_sum < $value) {
        $bonus[] = '<span class="strong">' . $key . '%</span>';
    } else {
        $bonus[] = $key . '%';
    }
}

$bonus = implode(' | ', $bonus);

print $bonus;