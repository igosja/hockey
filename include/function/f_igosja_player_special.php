<?php

/**
 * Отображение спесвозможностей хоккеиста с их уровнями
 * @param $player_id integer id хоккеиста
 * @param $playerspecial_array array массив с результатом запроса в БД (`playerspecial`)
 * @return string спецвозможности игрока
 */
function f_igosja_player_special($player_id, $playerspecial_array)
{
    $return_array = array();

    foreach ($playerspecial_array as $item)
    {
        if ($item['playerspecial_player_id'] == $player_id)
        {
            $return_array[] = $item['special_name'] . $item['playerspecial_level'];
        }
    }

    $return = implode(' ', $return_array);

    return $return;
}