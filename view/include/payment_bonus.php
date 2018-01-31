<?php

/**
 * @var $auth_user_id integer
 * @var $bonus_array array
 */

$user_bonus = f_igosja_get_user_payment_bonus($auth_user_id, $bonus_array);

$bonus = array();

foreach ($bonus_array as $item) {
    if ($user_bonus == $item) {
        $bonus[] = '<span class="strong">' . $item . '%</span>';
    } else {
        $bonus[] = $item . '%';
    }
}

$bonus = implode(' | ', $bonus);

print $bonus;