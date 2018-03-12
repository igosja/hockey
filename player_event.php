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

$sql = "SELECT `history_building_id`,
               `history_date`,
               `history_value`,
               `historytext_name`,
               `name_name`,
               `player_id`,
               `position_short`,
               `special_name`,
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
        LEFT JOIN `special`
        ON `history_special_id`=`special_id`
        LEFT JOIN `position`
        ON `history_position_id`=`position_id`
        LEFT JOIN `player`
        ON `history_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        WHERE `history_player_id`=$num_get
        ORDER BY `history_id` DESC";
$event_sql = f_igosja_mysqli_query($sql);

$count_event = $event_sql->num_rows;
$event_array = $event_sql->fetch_all(MYSQLI_ASSOC);

for ($i=0; $i<$count_event; $i++)
{
    $event_array[$i]['historytext_name'] = f_igosja_event_text($event_array[$i]);
}

$seo_title          = $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'] . '. События хоккеиста';
$seo_description    = $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'] . '. События хоккеиста на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'] . ' события хоккеиста';

include(__DIR__ . '/view/layout/main.php');