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
               `transfer_age`,
               `transfer_cancel`,
               `transfer_id`,
               `transfer_power`,
               `transfer_price_buyer`
        FROM `transfer`
        LEFT JOIN `player`
        ON `transfer_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `country` AS `pl_country`
        ON `player_country_id`=`pl_country`.`country_id`
        LEFT JOIN `team` AS `bteam`
        ON `transfer_team_buyer_id`=`bteam`.`team_id`
        LEFT JOIN `team` AS `steam`
        ON `transfer_team_seller_id`=`steam`.`team_id`
        WHERE `transfer_ready`=1
        ORDER BY `transfer_date` DESC";
$transfer_sql = f_igosja_mysqli_query($sql);

$count_transfer = $transfer_sql->num_rows;
$transfer_array = $transfer_sql->fetch_all(MYSQLI_ASSOC);

$transfer_id = array();

foreach ($transfer_array as $item)
{
    $transfer_id[] = $item['transfer_id'];
}

if (count($transfer_id))
{
    $transfer_id = implode(', ', $transfer_id);

    $sql = "SELECT `transferposition_transfer_id` AS `playerposition_player_id`,
                   `position_short`
            FROM `transferposition`
            LEFT JOIN `position`
            ON `transferposition_position_id`=`position_id`
            WHERE `transferposition_transfer_id` IN ($transfer_id)
            ORDER BY `transferposition_position_id` ASC";
    $playerposition_sql = f_igosja_mysqli_query($sql);

    $playerposition_array = $playerposition_sql->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT `transferspecial_level` AS `playerspecial_level`,
                   `transferspecial_transfer_id` AS `playerspecial_player_id`,
                   `special_name`,
                   `special_short`
            FROM `transferspecial`
            LEFT JOIN `special`
            ON `transferspecial_special_id`=`special_id`
            WHERE `transferspecial_transfer_id` IN ($transfer_id)
            ORDER BY `transferspecial_level` DESC, `transferspecial_special_id` ASC";
    $playerspecial_sql = f_igosja_mysqli_query($sql);

    $playerspecial_array = $playerspecial_sql->fetch_all(MYSQLI_ASSOC);
}
else
{
    $playerposition_array   = array();
    $playerspecial_array    = array();
}

$seo_title          = 'Трансфер хоккеистов';
$seo_description    = 'Трансфер хоккеистов на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'трансфер хоккеистов';

include(__DIR__ . '/view/layout/main.php');