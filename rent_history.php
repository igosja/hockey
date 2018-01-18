<?php

include(__DIR__ . '/include/include.php');

$sql = "SELECT `bteam`.`team_id` AS `bteam_id`,
               `bteam`.`team_name` AS `bteam_name`,
               `name_name`,
               `pl_country`.`country_id` AS `pl_country_id`,
               `pl_country`.`country_name` AS `pl_country_name`,
               `steam`.`team_id` AS `steam_id`,
               `steam`.`team_name` AS `steam_name`,
               `surname_name`,
               `rent_age`,
               `rent_id`,
               `rent_power`,
               `rent_price_buyer`
        FROM `rent`
        LEFT JOIN `player`
        ON `rent_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `country` AS `pl_country`
        ON `player_country_id`=`pl_country`.`country_id`
        LEFT JOIN `team` AS `bteam`
        ON `rent_team_buyer_id`=`bteam`.`team_id`
        LEFT JOIN `team` AS `steam`
        ON `rent_team_seller_id`=`steam`.`team_id`
        WHERE `rent_ready`=1
        ORDER BY `rent_id` ASC";
$rent_sql = f_igosja_mysqli_query($sql);

$count_rent = $rent_sql->num_rows;
$rent_array = $rent_sql->fetch_all(MYSQLI_ASSOC);

$rent_id = array();

foreach ($rent_array as $item)
{
    $rent_id[] = $item['rent_id'];
}

if (count($rent_id))
{
    $rent_id = implode(', ', $rent_id);

    $sql = "SELECT `rentposition_rent_id` AS `playerposition_player_id`,
                   `position_short`
            FROM `rentposition`
            LEFT JOIN `position`
            ON `rentposition_position_id`=`position_id`
            WHERE `rentposition_rent_id` IN ($rent_id)
            ORDER BY `rentposition_position_id` ASC";
    $playerposition_sql = f_igosja_mysqli_query($sql);

    $playerposition_array = $playerposition_sql->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT `rentspecial_level` AS `playerspecial_level`,
                   `rentspecial_rent_id` AS `playerspecial_player_id`,
                   `special_name`,
                   `special_short`
            FROM `rentspecial`
            LEFT JOIN `special`
            ON `rentspecial_special_id`=`special_id`
            WHERE `rentspecial_rent_id` IN ($rent_id)
            ORDER BY `rentspecial_level` DESC, `rentspecial_special_id` ASC";
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