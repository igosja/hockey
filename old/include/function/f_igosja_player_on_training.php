<?php

/**
 * Відображення позицій хокеїста
 * @param $player_id integer id хокеїста
 * @param $training_array array масив с результатом запиту в БД (`training`)
 * @return string позиції хокеїста
 */
function f_igosja_player_on_training($player_id, $training_array)
{
    $return = '';

    foreach ($training_array as $item)
    {
        if (isset($item['training_player_id']) && $item['training_player_id'] == $player_id)
        {
            $return = '<img
                           alt="На тренировке"
                           src="/img/training.png"
                           title="На тренировке"
                       />';
        }
    }

    return $return;
}