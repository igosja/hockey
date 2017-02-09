<?php

function f_igosja_player_position($player_id, $playerposition_array)
{
    $return_array = array();

    foreach ($playerposition_array as $item)
    {
        if ($item['playerposition_player_id'] == $player_id)
        {
            $return_array[] = $item['position_name'];
        }
    }

    $return = implode('/', $return_array);

    return $return;
}