<?php

/**
 * Відображення спецможливостей хокеїста з їх рівнем
 * @param $player_id integer id хокеїста
 * @param $playerspecial_array array масив с результатом запиту в БД (`playerspecial`)
 * @return string спецможливості хокеїста
 */
function f_igosja_player_special($player_id, $playerspecial_array)
{
    $return_array = array();

    foreach ($playerspecial_array as $item)
    {
        if (isset($item['playerspecial_player_id']) && $item['playerspecial_player_id'] == $player_id)
        {
            $return_array[] = '<span title="' . $item['special_name'] . '">' . $item['special_short'] . $item['playerspecial_level'] . '</span>';
        }
    }

    $return = implode(' ', $return_array);

    return $return;
}