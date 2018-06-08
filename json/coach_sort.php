<?php

/**
 * @var $auth_team_id integer
 */

include(__DIR__ . '/../include/include.php');

if ($player_array = f_igosja_request_post('player_array'))
{
    $player_array = explode(',', $player_array);

    foreach ($player_array as $item)
    {
        $player     = explode(':', $item);
        $player_id  = $player[0];
        $order      = $player[1];

        $sql = "UPDATE `player`
                SET `player_order`=$order
                WHERE `player_id`=$player_id
                AND `player_team_id`=$auth_team_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }
}