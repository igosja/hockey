<?php

function f_igosja_player_position($playerposition_player_id)
{
    global $position_array;

    $playerposition_array   = explode(',', $playerposition_player_id);
    $return_array           = array();

    foreach ($position_array as $item)
    {
        if (in_array($item['position_id'], $playerposition_array))
        {
            $return_array[] = $item['position_name'];
        }
    }

    $return = implode('/', $return_array);

    return $return;
}