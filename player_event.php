<?php

/**
 * @var $player_array array
 */

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

include(__DIR__ . '/include/sql/player_view.php');

$sql = "SELECT `history_date`,
               `history_season_id`,
               `historytext_name`,
               `team_id`,
               `team_name`
        FROM `history`
        LEFT JOIN `historytext`
        ON `history_historytext_id`=`historytext_id`
        LEFT JOIN `team`
        ON `history_team_id`=`team_id`
        WHERE `history_player_id`=$num_get
        ORDER BY `history_id` DESC";
$event_sql = f_igosja_mysqli_query($sql, false);

$count_event = $event_sql->num_rows;
$event_array = $event_sql->fetch_all(1);

for ($i=0; $i<$count_event; $i++)
{
    $text = $event_array[$i]['historytext_name'];
    $text = str_replace(
        '{team}',
        '<a href="/team_view.php?num=' . $event_array[$i]['team_id'] . '">' . $event_array[$i]['team_name'] . '</a>',
        $text
    );
    $text = str_replace(
        '{player}',
        '<a href="/player_view.php?num=' . $num_get . '">' . $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'] . '</a>',
        $text
    );

    $event_array[$i]['historytext_name'] = $text;
}

$seo_title          = $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'] . '. События хоккеиста';
$seo_description    = $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'] . '. События хоккеиста на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'] . ' события хоккеиста';

include(__DIR__ . '/view/layout/main.php');