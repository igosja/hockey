<?php

/**
 * @var $auth_national_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    if (!isset($auth_national_id))
    {
        redirect('/wrong_page.php');
    }

    if (0 == $auth_national_id)
    {
        redirect('/wrong_page.php');
    }

    $num_get = $auth_national_id;
}

include(__DIR__ . '/include/sql/national_view_left.php');
include(__DIR__ . '/include/sql/national_view_right.php');

$sql = "SELECT `history_date`,
               `history_season_id`,
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
        WHERE `history_national_id`=$num_get
        ORDER BY `history_id` DESC";
$event_sql = f_igosja_mysqli_query($sql);

$count_event = $event_sql->num_rows;
$event_array = $event_sql->fetch_all(1);

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

    $event_array[$i]['historytext_name'] = $text;
}

$seo_title          = $national_array[0]['country_name'] . '. События команды';
$seo_description    = $national_array[0]['country_name'] . '. События команды на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $national_array[0]['country_name'] . ' события команды';

include(__DIR__ . '/view/layout/main.php');