<?php

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `city_name`,
               `country_id`,
               `country_name`,
               `name_name`,
               `player_age`,
               `player_id`,
               `player_power_nominal`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `electionnationalapplicationplayer`
        LEFT JOIN `player`
        ON `electionnationalapplicationplayer_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `electionnationalapplicationplayer_electionnationalapplication_id`=$num_get
        GROUP BY `player_id`
        ORDER BY `player_position_id` ASC";
$player_sql = f_igosja_mysqli_query($sql);

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$player_id = array();

foreach ($player_array as $item)
{
    $player_id[] = $item['player_id'];
}

if (count($player_id))
{
    $player_id = implode(', ', $player_id);

    $sql = "SELECT `playerposition_player_id`,
                   `position_name`,
                   `position_short`
            FROM `playerposition`
            LEFT JOIN `position`
            ON `playerposition_position_id`=`position_id`
            WHERE `playerposition_player_id` IN ($player_id)";
    $playerposition_sql = f_igosja_mysqli_query($sql);

    $playerposition_array = $playerposition_sql->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT `playerspecial_level`,
                   `playerspecial_player_id`,
                   `special_name`,
                   `special_short`
            FROM `playerspecial`
            LEFT JOIN `special`
            ON `playerspecial_special_id`=`special_id`
            WHERE `playerspecial_player_id` IN ($player_id)
            ORDER BY `playerspecial_level` DESC, `playerspecial_special_id` ASC";
    $playerspecial_sql = f_igosja_mysqli_query($sql);

    $playerspecial_array = $playerspecial_sql->fetch_all(MYSQLI_ASSOC);
}
else
{
    $playerposition_array   = array();
    $playerspecial_array    = array();
}

$seo_title          = 'Состав сборной в заявке тернера';
$seo_description    = 'Состав сборной в заявке тернера на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'состав сборной в заявке тернера';

include(__DIR__ . '/view/layout/main.php');