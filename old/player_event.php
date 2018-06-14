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

$sql = "SELECT `guest_city`.`city_name` AS `guest_city_name`,
               `guest_country`.`country_name` AS `guest_country_name`,
               `guest_national_country`.`country_name` AS `guest_national_name`,
               `guest_national`.`national_id` AS `guest_national_id`,
               `guest_nationaltype`.`nationaltype_name` AS `guest_nationaltype_name`,
               `guest_team`.`team_id` AS `guest_team_id`,
               `guest_team`.`team_name` AS `guest_team_name`,
               `history_date`,
               `history_game_id`,
               `history_season_id`,
               `history_value`,
               `historytext_name`,
               `home_city`.`city_name` AS `home_city_name`,
               `home_country`.`country_name` AS `home_country_name`,
               `home_national_country`.`country_name` AS `home_national_name`,
               `home_national`.`national_id` AS `home_national_id`,
               `home_nationaltype`.`nationaltype_name` AS `home_nationaltype_name`,
               `home_team`.`team_id` AS `home_team_id`,
               `home_team`.`team_name` AS `home_team_name`,
               `name_name`,
               `player_id`,
               `position_short`,
               `special_name`,
               `surname_name`,
               `history_team`.`team_id` AS `team_id`,
               `history_team`.`team_name` AS `team_name`,
               `history_team2`.`team_id` AS `team2_id`,
               `history_team2`.`team_name` AS `team2_name`,
               `user_id`,
               `user_login`
        FROM `history`
        LEFT JOIN `historytext`
        ON `history_historytext_id`=`historytext_id`
        LEFT JOIN `team` AS `history_team`
        ON `history_team_id`=`history_team`.`team_id`
        LEFT JOIN `team` AS `history_team2`
        ON `history_team_2_id`=`history_team2`.`team_id`
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
        LEFT JOIN `game`
        ON `history_game_id`=`game_id`
        LEFT JOIN `team` AS `guest_team`
        ON `game_guest_team_id`=`guest_team`.`team_id`
        LEFT JOIN `stadium` AS `guest_stadium`
        ON `guest_team`.`team_stadium_id`=`guest_stadium`.`stadium_id`
        LEFT JOIN `city` AS `guest_city`
        ON `guest_stadium`.`stadium_city_id`=`guest_city`.`city_id`
        LEFT JOIN `country` AS `guest_country`
        ON `guest_city`.`city_country_id`=`guest_country`.`country_id`
        LEFT JOIN `national` AS `guest_national`
        ON `game_guest_national_id`=`guest_national`.`national_id`
        LEFT JOIN `nationaltype` AS `guest_nationaltype`
        ON `guest_national`.`national_nationaltype_id`=`guest_nationaltype`.`nationaltype_id`
        LEFT JOIN `country` AS `guest_national_country`
        ON `guest_national`.`national_country_id`=`guest_national_country`.`country_id`
        LEFT JOIN `team` AS `home_team`
        ON `game_home_team_id`=`home_team`.`team_id`
        LEFT JOIN `stadium` AS `home_stadium`
        ON `home_team`.`team_stadium_id`=`home_stadium`.`stadium_id`
        LEFT JOIN `city` AS `home_city`
        ON `home_stadium`.`stadium_city_id`=`home_city`.`city_id`
        LEFT JOIN `country` AS `home_country`
        ON `home_city`.`city_country_id`=`home_country`.`country_id`
        LEFT JOIN `national` AS `home_national`
        ON `game_home_national_id`=`home_national`.`national_id`
        LEFT JOIN `nationaltype` AS `home_nationaltype`
        ON `home_national`.`national_nationaltype_id`=`home_nationaltype`.`nationaltype_id`
        LEFT JOIN `country` AS `home_national_country`
        ON `home_national`.`national_country_id`=`home_national_country`.`country_id`
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