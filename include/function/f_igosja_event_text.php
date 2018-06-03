<?php

/**
 * Виведення оформленого тексту події
 * @param $event array дані з БД
 * @return string
 */
function f_igosja_event_text($event)
{
    if (isset($event['financetext_name']))
    {
        $text = $event['financetext_name'];
    }
    else
    {
        $text = $event['historytext_name'];
    }

    if (isset($event['user_id']))
    {
        $text = str_replace(
            '{user}',
            '<a href="/user_view.php?num=' . $event['user_id'] . '">' . $event['user_login'] . '</a>',
            $text
        );
    }

    if (isset($event['team_id']))
    {
        $text = str_replace(
            '{team}',
            '<a href="/team_view.php?num=' . $event['team_id'] . '">' . $event['team_name'] . '</a>',
            $text
        );
    }

    if (isset($event['team2_id']))
    {
        $text = str_replace(
            '{team2}',
            '<a href="/team_view.php?num=' . $event['team2_id'] . '">' . $event['team2_name'] . '</a>',
            $text
        );
    }

    if (isset($event['player_id']))
    {
        $text = str_replace(
            '{player}',
            '<a href="/player_view.php?num=' . $event['player_id'] . '">' . $event['name_name'] . ' ' . $event['surname_name'] . '</a>',
            $text
        );
    }

    if (isset($event['special_name']))
    {
        $text = str_replace(
            '{special}',
            $event['special_name'],
            $text
        );
    }

    if (isset($event['position_short']))
    {
        $text = str_replace(
            '{position}',
            $event['position_short'],
            $text
        );
    }

    if (isset($event['history_value']))
    {
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
        $text = str_replace(
            '{day}',
            $event['history_value'] . ' ' . f_igosja_count_case($event['history_value'], 'день', 'дня', 'дней'),
            $text
        );
    }

    if (isset($event['finance_level']))
    {
        $text = str_replace(
            '{level}',
            $event['finance_level'],
            $text
        );
    }

    if (isset($event['finance_capacity']))
    {
        $text = str_replace(
            '{capacity}',
            $event['finance_capacity'],
            $text
        );
    }

    if (isset($event['national_id']))
    {
        $text = str_replace(
            '{national}',
            '<a href="/national_view.php?num=' . $event['national_id'] . '">' . $event['national_name'] . ' (' . $event['nationaltype_name'] . ')</a>',
            $text
        );
    }

    if (isset($event['history_country_id']))
    {
        $text = str_replace(
            '{country}',
            '<a href="/country_news.php?num=' . $event['history_country_id'] . '">' . $event['country_name'] . '</a>',
            $text
        );
    }

    if (isset($event['history_building_id']))
    {
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
    }

    if (isset($event['finance_building_id']))
    {
        $building = '';
        if (BUILDING_BASE == $event['finance_building_id']) {
            $building = 'база';
        } elseif (BUILDING_BASEMEDICAL == $event['finance_building_id']) {
            $building = 'медцентр';
        } elseif (BUILDING_BASEPHISICAL == $event['finance_building_id']) {
            $building = 'центр физподготовки';
        } elseif (BUILDING_BASESCHOOL == $event['finance_building_id']) {
            $building = 'спортшкола';
        } elseif (BUILDING_BASESCOUT == $event['finance_building_id']) {
            $building = 'скаут-центр';
        } elseif (BUILDING_BASETRAINING == $event['finance_building_id']) {
            $building = 'тренировочный центр';
        }
        $text = str_replace(
            '{building}',
            $building,
            $text
        );
    }

    if (isset($event['history_game_id']))
    {
        $text = str_replace(
            '{game}',
            '<a href="/game_view.php?num=' . $event['history_game_id'] . '">' .
            f_igosja_team_or_national_link(
                array(
                    'city_name'     => $event['home_city_name'],
                    'country_name'  => $event['home_country_name'],
                    'team_id'       => $event['home_team_id'],
                    'team_name'     => $event['home_team_name'],
                ),
                array(
                    'country_name'      => $event['home_national_name'],
                    'national_id'       => $event['home_national_id'],
                    'nationaltype_name' => $event['home_nationaltype_name'],
                ),
                false,
                false
            ) .
            ' - ' .
            f_igosja_team_or_national_link(
                array(
                    'city_name'     => $event['guest_city_name'],
                    'country_name'  => $event['guest_country_name'],
                    'team_id'       => $event['guest_team_id'],
                    'team_name'     => $event['guest_team_name'],
                ),
                array(
                    'country_name'      => $event['guest_national_name'],
                    'national_id'       => $event['guest_national_id'],
                    'nationaltype_name' => $event['guest_nationaltype_name'],
                ),
                false,
                false
            ),
            $text
        );
    }

    return $text;
}