<?php

/**
 * Виведення оформленого тексту події
 * @param $event array дані з БД
 */
function f_igosja_event_text($event)
{
    $text = $event['historytext_name'];
    $text = str_replace(
        '{user}',
        '<a href="/user_view.php?num=' . $event['user_id'] . '">' . $event['user_login'] . '</a>',
        $text
    );
    $text = str_replace(
        '{team}',
        '<a href="/team_view.php?num=' . $event['team_id'] . '">' . $event['team_name'] . '</a>',
        $text
    );
    $text = str_replace(
        '{player}',
        '<a href="/player_view.php?num=' . $event['player_id'] . '">' . $event['name_name'] . ' ' . $event['surname_name'] . '</a>',
        $text
    );
    $text = str_replace(
        '{special}',
        $event['special_name'],
        $text
    );
    $text = str_replace(
        '{position}',
        $event['position_short'],
        $text
    );
    $text = str_replace(
        '{level}',
        $event['history_value'],
        $text
    );
    $text = str_replace(
        '{capacity}',
        $event['history_value'],
        $text
    );
    $building = '';
    if (BUILDING_BASE == $event['history_building_id']) {
        $building = 'база';
    } elseif (BUILDING_BASEMEDICAL == $event['history_building_id']) {
        $building = 'медцентр';
    } elseif (BUILDING_BASEPHISICAL == $event['history_building_id']) {
        $building = 'центр физподготовки';
    } elseif (BUILDING_BASESCHOOL == $event['history_building_id']) {
        $building = 'спортшкола';
    } elseif (BUILDING_BASESCOUT == $event['history_building_id']) {
        $building = 'скаут-центр';
    } elseif (BUILDING_BASETRAINING == $event['history_building_id']) {
        $building = 'тренировочный центр';
    }
    $text = str_replace(
        '{building}',
        $building,
        $text
    );

    return $text;
}