<?php

/**
 * Відображення статистики хокеїста на сторінці команди
 * @param $player_id integer id хокеїста
 * @param $playerstatistic_array array масив с результатом запиту в БД (`playerstatistic`)
 * @param $field string назва поля в БД
 * @return string статисничний показник хокеїста
 */
function f_igosja_player_statistic($player_id, $playerstatistic_array, $field)
{
    foreach ($playerstatistic_array as $item)
    {
        if ($item['statisticplayer_player_id'] == $player_id)
        {
            return $item[$field];
        }
    }

    return 0;
}