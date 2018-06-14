<?php

/**
 * Отримуємо массив команд для подальшої обробки в ЛЧ. Команди з однієї країни не мають перетинатись
 * @param $stage_id integer
 * @return array
 */
function f_igosja_league_lot($stage_id)
{
    $team_array = f_igosja_league_prepare($stage_id);
    $team_array = f_igosja_league($team_array, $stage_id);

    return $team_array;
}