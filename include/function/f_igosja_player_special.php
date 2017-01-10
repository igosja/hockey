<?php

function f_igosja_player_special($playerspecial_player_id)
{
    global $special_array;

    $playerspecial_array    = explode(',', $playerspecial_player_id);
    $return_array           = array();

    foreach ($special_array as $item)
    {
        if (in_array($item['special_id'], $playerspecial_array))
        {
            $return_array[] = $item['special_name'];
        }
    }

    $return = implode('/', $return_array);

    return $return;
}