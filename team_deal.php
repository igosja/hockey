<?php

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

$sql = "SELECT `city_name`,
               `name_name`,
               `player_country_id`,
               `player_country`.`country_name` AS `player_country_name`,
               `player_id`,
               `surname_name`,
               `team_country`.`country_name` AS `team_country_name`,
               `team_id`,
               `team_name`,
               `transfer_age`,
               `transfer_date`,
               `transfer_power`,
               `transfer_price_buyer`
        FROM `transfer`
        LEFT JOIN `player`
        ON `transfer_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `country` AS `player_country`
        ON `player_country_id`=`player_country`.`country_id`
        LEFT JOIN `team`
        ON `transfer_team_buyer_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country` AS `team_country`
        ON `city_country_id`=`team_country`.`country_id`
        WHERE `transfer_ready`=1
        AND `transfer_season_id`=$igosja_season_id
        AND `transfer_team_seller_id`=$num_get
        ORDER BY `transfer_date` DESC";
$transfer_sell_sql = f_igosja_mysqli_query($sql);

$transfer_sell_array = $transfer_sell_sql->fetch_all(1);

$sql = "SELECT `city_name`,
               `name_name`,
               `player_country_id`,
               `player_country`.`country_name` AS `player_country_name`,
               `player_id`,
               `surname_name`,
               `team_country`.`country_name` AS `team_country_name`,
               `team_id`,
               `team_name`,
               `transfer_age`,
               `transfer_date`,
               `transfer_power`,
               `transfer_price_buyer`
        FROM `transfer`
        LEFT JOIN `player`
        ON `transfer_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `country` AS `player_country`
        ON `player_country_id`=`player_country`.`country_id`
        LEFT JOIN `team`
        ON `transfer_team_seller_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country` AS `team_country`
        ON `city_country_id`=`team_country`.`country_id`
        WHERE `transfer_ready`=1
        AND `transfer_season_id`=$igosja_season_id
        AND `transfer_team_buyer_id`=$num_get
        ORDER BY `transfer_date` DESC";
$transfer_buy_sql = f_igosja_mysqli_query($sql);

$transfer_buy_array = $transfer_buy_sql->fetch_all(1);

$sql = "SELECT `city_name`,
               `name_name`,
               `player_country_id`,
               `player_country`.`country_name` AS `player_country_name`,
               `player_id`,
               `surname_name`,
               `team_country`.`country_name` AS `team_country_name`,
               `team_id`,
               `team_name`,
               `rent_age`,
               `rent_date`,
               `rent_day`,
               `rent_power`,
               `rent_price_buyer`
        FROM `rent`
        LEFT JOIN `player`
        ON `rent_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `country` AS `player_country`
        ON `player_country_id`=`player_country`.`country_id`
        LEFT JOIN `team`
        ON `rent_team_buyer_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country` AS `team_country`
        ON `city_country_id`=`team_country`.`country_id`
        WHERE `rent_ready`=1
        AND `rent_season_id`=$igosja_season_id
        AND `rent_team_seller_id`=$num_get
        ORDER BY `rent_date` DESC";
$rent_sell_sql = f_igosja_mysqli_query($sql);

$rent_sell_array = $rent_sell_sql->fetch_all(1);

$sql = "SELECT `city_name`,
               `name_name`,
               `player_country_id`,
               `player_country`.`country_name` AS `player_country_name`,
               `player_id`,
               `surname_name`,
               `team_country`.`country_name` AS `team_country_name`,
               `team_id`,
               `team_name`,
               `rent_age`,
               `rent_date`,
               `rent_day`,
               `rent_power`,
               `rent_price_buyer`
        FROM `rent`
        LEFT JOIN `player`
        ON `rent_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `country` AS `player_country`
        ON `player_country_id`=`player_country`.`country_id`
        LEFT JOIN `team`
        ON `rent_team_seller_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country` AS `team_country`
        ON `city_country_id`=`team_country`.`country_id`
        WHERE `rent_ready`=1
        AND `rent_season_id`=$igosja_season_id
        AND `rent_team_buyer_id`=$num_get
        ORDER BY `rent_date` DESC";
$rent_buy_sql = f_igosja_mysqli_query($sql);

$rent_buy_array = $rent_buy_sql->fetch_all(1);

$sql = "SELECT `position_id`,
               `position_name`
        FROM `position`
        ORDER BY `position_id` ASC";
$position_sql = f_igosja_mysqli_query($sql);

$position_array = $position_sql->fetch_all(1);

$sql = "SELECT `special_id`,
               `special_name`
        FROM `special`
        ORDER BY `special_id` ASC";
$special_sql = f_igosja_mysqli_query($sql);

$special_array = $special_sql->fetch_all(1);

include(__DIR__ . '/view/layout/main.php');