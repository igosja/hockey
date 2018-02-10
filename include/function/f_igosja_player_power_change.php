<?php

/**
 * Перевіряємо перед будівництвом чи хтось є в спортшколі
 * @param $power_change integer зміна сили хокеїста
 * @return string
 */
function f_igosja_player_power_change($power_change)
{
    $result = '';

    if ($power_change > 0)
    {
        $result = '<img alt="Получил балл силы по результатам матча" src="/img/plus.png" title="Получил балл силы по результатам матча" />';
    }
    elseif ($power_change < 0)
    {
        $result = '<img alt="Потерял балл силы по результатам матча" src="/img/minus.png" title="Потерял балл силы по результатам матча" />';
    }

    return $result;
}