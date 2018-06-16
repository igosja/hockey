<?php

/**
 * Відображення позицій хокеїста
 * @param $player_id integer id хокеїста
 * @param $playerposition_array array масив с результатом запиту в БД (`playerposition`)
 * @return string позиції хокеїста
 */
function f_igosja_player_position($player_id, $playerposition_array)
{
    $return_array = array();

    foreach ($playerposition_array as $item)
    {
        if (isset($item['playerposition_player_id']) && $item['playerposition_player_id'] == $player_id)
        {
            $return_array[] = '<span title="' . $item['position_name'] . '">' . $item['position_short'] . '</span>';
        }
    }

    $return = implode('/', $return_array);

    return $return;
}