<?php

/**
 * @var $auth_team_id integer
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    if (!isset($auth_team_id))
    {
        redirect('/wrong_page.php');
    }

    if (0 == $auth_team_id)
    {
        redirect('/team_ask.php');
    }

    $num_get = $auth_team_id;
}

include(__DIR__ . '/include/sql/team_view_left.php');
include(__DIR__ . '/include/sql/team_view_right.php');

if (!$season_id = (int) f_igosja_request_get('season_id'))
{
    $season_id = $igosja_season_id;
}

if ($season_id > $igosja_season_id)
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `season_id`
        FROM `season`
        ORDER BY `season_id` DESC";
$season_sql = f_igosja_mysqli_query($sql);

$season_array = $season_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `history_building_id`,
               `history_date`,
               `history_value`,
               `historytext_name`,
               `name_name`,
               `player_id`,
               `surname_name`,
               `team_id`,
               `team_name`,
               `user_id`,
               `user_login`
        FROM `history`
        LEFT JOIN `historytext`
        ON `history_historytext_id`=`historytext_id`
        LEFT JOIN `team`
        ON `history_team_id`=`team_id`
        LEFT JOIN `user`
        ON `history_user_id`=`user_id`
        LEFT JOIN `player`
        ON `history_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        WHERE `history_team_id`=$num_get
        AND `history_season_id`=$season_id
        ORDER BY `history_id` DESC";
$event_sql = f_igosja_mysqli_query($sql);

$count_event = $event_sql->num_rows;
$event_array = $event_sql->fetch_all(MYSQLI_ASSOC);

for ($i=0; $i<$count_event; $i++)
{
    $text = $event_array[$i]['historytext_name'];
    $text = str_replace(
        '{user}',
        '<a href="/user_view.php?num=' . $event_array[$i]['user_id'] . '">' . $event_array[$i]['user_login'] . '</a>',
        $text
    );
    $text = str_replace(
        '{team}',
        '<a href="/team_view.php?num=' . $event_array[$i]['team_id'] . '">' . $event_array[$i]['team_name'] . '</a>',
        $text
    );
    $text = str_replace(
        '{player}',
        '<a href="/player_view.php?num=' . $event_array[$i]['player_id'] . '">' . $event_array[$i]['name_name'] . ' ' . $event_array[$i]['surname_name'] . '</a>',
        $text
    );
    $text = str_replace(
        '{level}',
        $event_array[$i]['history_value'],
        $text
    );
    $text = str_replace(
        '{capacity}',
        $event_array[$i]['history_value'],
        $text
    );
    $building = '';
    if (BUILDING_BASE == $event_array[$i]['history_building_id']) {
        $building = 'база';
    } elseif (BUILDING_BASEMEDICAL == $event_array[$i]['history_building_id']) {
        $building = 'медцентр';
    } elseif (BUILDING_BASEPHISICAL == $event_array[$i]['history_building_id']) {
        $building = 'центр физподготовки';
    } elseif (BUILDING_BASESCHOOL == $event_array[$i]['history_building_id']) {
        $building = 'спортшкола';
    } elseif (BUILDING_BASESCOUT == $event_array[$i]['history_building_id']) {
        $building = 'скаут-центр';
    } elseif (BUILDING_BASETRAINING == $event_array[$i]['history_building_id']) {
        $building = 'тренировочный центр';
    }
    $text = str_replace(
        '{building}',
        $building,
        $text
    );

    $event_array[$i]['historytext_name'] = $text;
}

$seo_title          = $team_array[0]['team_name'] . '. События команды';
$seo_description    = $team_array[0]['team_name'] . '. События команды на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $team_array[0]['team_name'] . ' события команды';

include(__DIR__ . '/view/layout/main.php');