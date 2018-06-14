<?php

/**
 * Генеруємо текст новини на основі данних з БД
 * @param $schedule_array array
 * @param $team string home або guest
 * @return string
 */
function f_igosja_news_text($schedule_array)
{
    $result = array();

    foreach ($schedule_array as $item)
    {
        if (TOURNAMENTTYPE_NATIONAL == $item['schedule_tournamenttype_id'])
        {
            $result[] = $item['stage_name'] . 'а Чемпионата мира среди сборных';
        }
        elseif (TOURNAMENTTYPE_LEAGUE == $item['schedule_tournamenttype_id'])
        {
            if ($item['stage_id'] <= STAGE_6_TOUR)
            {
                $result[] = 'матчи ' . $item['stage_name'] . 'а Лиги чемпионов';
            }
            elseif ($item['stage_id'] < STAGE_QUATER)
            {
                $result[] = 'матчи ' . $item['stage_name'] . ' Лиги чемпионов';
            }
            elseif ($item['stage_id'] < STAGE_FINAL)
            {
                $result[] = 'матчи ' . $item['stage_name'] . ' финала Лиги чемпионов';
            }
            elseif (STAGE_FINAL == $item['stage_id'])
            {
                $result[] = 'матчи ' . $item['stage_name'] . 'а Лиги чемпионов';
            }
        }
        elseif (TOURNAMENTTYPE_CHAMPIONSHIP == $item['schedule_tournamenttype_id'])
        {
            if ($item['stage_id'] <= STAGE_30_TOUR)
            {
                $result[] = 'матчи ' . $item['stage_name'] . 'а национальных чемпионатов';
            }
            elseif ($item['stage_id'] <= STAGE_FINAL)
            {
                $result[] = 'матчи ' . $item['stage_name'] . ' финала национальных чемпионатов';
            }
            elseif (STAGE_FINAL == $item['stage_id'])
            {
                $result[] = 'матчи ' . $item['stage_name'] . 'а национальных чемпионатов';
            }
        }
        elseif (TOURNAMENTTYPE_CONFERENCE == $item['schedule_tournamenttype_id'])
        {
            $result[] = 'матчи ' . $item['stage_name'] . 'а конференции любительских клубов';
        }
        elseif (TOURNAMENTTYPE_OFFSEASON == $item['schedule_tournamenttype_id'])
        {
            $result[] = 'матчи ' . $item['stage_name'] . 'а кубка межсезонья';
        }
        elseif (TOURNAMENTTYPE_FRIENDLY == $item['schedule_tournamenttype_id'])
        {
            $result[] = 'товарищеские матчи';
        }
    }

    $result = implode(' и ', $result);

    return $result;
}