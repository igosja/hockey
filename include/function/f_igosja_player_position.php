<?php

/**
 * Отображение позиций хоккеиста
 * @param $player_id integer id хоккеиста
 * @param $playerposition_array array массив с результатом запроса в БД (`playerposition`)
 * @return string позиции игрока
 */
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