<?php

/**
 * Відображення оцінки трансферу/оренди
 * @param $deal_id integer id угоди
 * @param $plus_array array масив с результатом запиту в БД (`transfervote`|`rentvote`), голоси "за"
 * @param $minus_array array масив с результатом запиту в БД (`transfervote`|`rentvote`), голоси "проти"
 * @param $deal_type string тип угоди (`transfer`|`rent`)
 * @return string позиції хокеїста
 */
function f_igosja_deal_rating($deal_id, $plus_array, $minus_array, $deal_type)
{
    $return_array = array();

    foreach ($plus_array as $item)
    {
        if (isset($item[$deal_type . 'vote_' . $deal_type . '_id']) && $item[$deal_type . 'vote_' . $deal_type . '_id'] == $deal_id)
        {
            $return_array[] = '<span class="font-green">' . $item['rating'] . '</span>';
        }
    }

    if (0 == count($return_array))
    {
        $return_array[] = '<span class="font-green">0</span>';
    }

    foreach ($minus_array as $item)
    {
        if (isset($item[$deal_type . 'vote_' . $deal_type . '_id']) && $item[$deal_type . 'vote_' . $deal_type . '_id'] == $deal_id)
        {
            $return_array[] = '<span class="font-red">' . -$item['rating'] . '</span>';
        }
    }

    if (1 == count($return_array))
    {
        $return_array[] = '<span class="font-red">0</span>';
    }

    $return = implode(' | ', $return_array);

    return $return;
}