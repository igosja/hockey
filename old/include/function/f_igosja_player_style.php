<?php

/**
 * Відображення стиль на сторінці команди хокеїста
 * @param $player_id integer id хокеїста
 * @param $style_id integer id стилю хокеїста
 * @param $style_name string назва стилю
 * @param $scout_array array масив с результатом запиту в БД (`scout`)
 * @return string позиції хокеїста
 */
function f_igosja_player_style($player_id, $style_id, $style_name, $scout_array)
{
    $return = '';

    foreach ($scout_array as $item)
    {
        if (isset($item['scout_player_id']) && 2 == $item['count_scout'] && $item['scout_player_id'] == $player_id)
        {
            $return = '<img
                           alt="' . $style_name . '"
                           src="/img/style/' . $style_id . '.png"
                           title="' . $style_name . '"
                       />';
        }
    }

    return $return;
}