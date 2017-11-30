<?php

include(__DIR__ . '/include/include.php');

$sql = "SELECT `city_name`,
               `name_name`,
               `pl_country`.`country_id` AS `pl_country_id`,
               `pl_country`.`country_name` AS `pl_country_name`,
               `player_age`,
               `player_id`,
               `player_power_nominal`,
               `rent_day_max`,
               `rent_day_min`,
               `rent_price_seller`,
               `surname_name`,
               `t_country`.`country_name` AS `t_country_name`,
               `team_id`,
               `team_name`
        FROM `rent`
        LEFT JOIN `player`
        ON `rent_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `country` AS `pl_country`
        ON `player_country_id`=`pl_country`.`country_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country` AS `t_country`
        ON `city_country_id`=`t_country`.`country_id`
        WHERE `rent_ready`=0
        ORDER BY `rent_id` ASC";
$rent_sql = f_igosja_mysqli_query($sql);

$count_rent = $rent_sql->num_rows;
$rent_array = $rent_sql->fetch_all(MYSQLI_ASSOC);

$player_id = array();

foreach ($rent_array as $item)
{
    $player_id[] = $item['player_id'];
}

if (count($player_id))
{
    $player_id = implode(', ', $player_id);

    $sql = "SELECT `playerposition_player_id`,
                   `position_name`
            FROM `playerposition`
            LEFT JOIN `position`
            ON `playerposition_position_id`=`position_id`
            WHERE `playerposition_player_id` IN ($player_id)
            ORDER BY `playerposition_position_id` ASC";
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

$seo_title          = 'Аренда хоккеистов';
$seo_description    = 'Аренда хоккеистов на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'аренда хоккеистов';

include(__DIR__ . '/view/layout/main.php');