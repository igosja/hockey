<?php

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

include(__DIR__ . '/include/sql/player_view.php');

$sql = "SELECT `buyer_country`.`country_name` AS `buyer_country_name`,
               `buyer_city`.`city_name` AS `buyer_city_name`,
               `buyer_team`.`team_id` AS `buyer_team_id`,
               `buyer_team`.`team_name` AS `buyer_team_name`,
               `player_id`,
               `seller_country`.`country_name` AS `seller_country_name`,
               `seller_city`.`city_name` AS `seller_city_name`,
               `seller_team`.`team_id` AS `seller_team_id`,
               `seller_team`.`team_name` AS `seller_team_name`,
               `transfer_age`,
               `transfer_date`,
               `transfer_power`,
               `transfer_price_buyer`,
               `transfer_season_id`
        FROM `transfer`
        LEFT JOIN `player`
        ON `transfer_player_id`=`player_id`
        LEFT JOIN `team` AS `buyer_team`
        ON `transfer_team_buyer_id`=`buyer_team`.`team_id`
        LEFT JOIN `stadium` AS `buyer_stadium`
        ON `buyer_team`.`team_stadium_id`=`buyer_stadium`.`stadium_id`
        LEFT JOIN `city` AS `buyer_city`
        ON `buyer_stadium`.`stadium_city_id`=`buyer_city`.`city_id`
        LEFT JOIN `country` AS `buyer_country`
        ON `buyer_city`.`city_country_id`=`buyer_country`.`country_id`
        LEFT JOIN `team` AS `seller_team`
        ON `transfer_team_seller_id`=`seller_team`.`team_id`
        LEFT JOIN `stadium` AS `seller_stadium`
        ON `seller_team`.`team_stadium_id`=`seller_stadium`.`stadium_id`
        LEFT JOIN `city` AS `seller_city`
        ON `seller_stadium`.`stadium_city_id`=`seller_city`.`city_id`
        LEFT JOIN `country` AS `seller_country`
        ON `seller_city`.`city_country_id`=`seller_country`.`country_id`
        WHERE `transfer_ready`=1
        AND `transfer_player_id`=$num_get
        ORDER BY `transfer_date` DESC";
$transfer_sql = f_igosja_mysqli_query($sql);

$transfer_array = $transfer_sql->fetch_all(1);

$sql = "SELECT `buyer_country`.`country_name` AS `buyer_country_name`,
               `buyer_city`.`city_name` AS `buyer_city_name`,
               `buyer_team`.`team_id` AS `buyer_team_id`,
               `buyer_team`.`team_name` AS `buyer_team_name`,
               `player_id`,
               `seller_country`.`country_name` AS `seller_country_name`,
               `seller_city`.`city_name` AS `seller_city_name`,
               `seller_team`.`team_id` AS `seller_team_id`,
               `seller_team`.`team_name` AS `seller_team_name`,
               `rent_age`,
               `rent_date`,
               `rent_day`,
               `rent_power`,
               `rent_price_buyer`,
               `rent_season_id`
        FROM `rent`
        LEFT JOIN `player`
        ON `rent_player_id`=`player_id`
        LEFT JOIN `team` AS `buyer_team`
        ON `rent_team_buyer_id`=`buyer_team`.`team_id`
        LEFT JOIN `stadium` AS `buyer_stadium`
        ON `buyer_team`.`team_stadium_id`=`buyer_stadium`.`stadium_id`
        LEFT JOIN `city` AS `buyer_city`
        ON `buyer_stadium`.`stadium_city_id`=`buyer_city`.`city_id`
        LEFT JOIN `country` AS `buyer_country`
        ON `buyer_city`.`city_country_id`=`buyer_country`.`country_id`
        LEFT JOIN `team` AS `seller_team`
        ON `rent_team_seller_id`=`seller_team`.`team_id`
        LEFT JOIN `stadium` AS `seller_stadium`
        ON `seller_team`.`team_stadium_id`=`seller_stadium`.`stadium_id`
        LEFT JOIN `city` AS `seller_city`
        ON `seller_stadium`.`stadium_city_id`=`seller_city`.`city_id`
        LEFT JOIN `country` AS `seller_country`
        ON `seller_city`.`city_country_id`=`seller_country`.`country_id`
        WHERE `rent_ready`=1
        AND `rent_player_id`=$num_get
        ORDER BY `rent_date` DESC";
$rent_sql = f_igosja_mysqli_query($sql);

$rent_array = $rent_sql->fetch_all(1);

$sql = "SELECT `position_id`,
               `position_name`
        FROM `position`
        ORDER BY `position_id` ASC";
$position_sql = f_igosja_mysqli_query($sql);

$position_array = $position_sql->fetch_all(1);

$seo_title          = $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'] . '. Сделки хоккеиста';
$seo_description    = $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'] . '. Сделки хоккеиста на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'] . ' сделки хоккеиста';

include(__DIR__ . '/view/layout/main.php');