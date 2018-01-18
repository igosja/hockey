<?php

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    if (!isset($auth_user_id))
    {
        redirect('/wrong_page.php');
    }

    $num_get = $auth_user_id;
}

include(__DIR__ . '/include/sql/user_view.php');

$sql = "SELECT `championship_place`,
               `city_name`,
               `conference_place`,
               `country_id`,
               `country_name`,
               `division_id`,
               `division_name`,
               `team_id`,
               `team_name`,
               `team_power_vs`,
               `team_price_total`
        FROM `team`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        LEFT JOIN
        (
            SELECT `championship_place`,
                   `championship_team_id`,
                   `division_id`,
                   `division_name`
            FROM `championship`
            LEFT JOIN `division`
            ON `championship_division_id`=`division_id`
            WHERE `championship_team_id` IN
            (
                SELECT `team_id`
                FROM `team`
                WHERE `team_user_id`=$num_get
            )
            AND `championship_season_id`=$igosja_season_id
        ) AS `t1`
        ON `team_id`=`championship_team_id`
        LEFT JOIN
        (
            SELECT `conference_place`,
                   `conference_team_id`
            FROM `conference`
            WHERE `conference_team_id` IN
            (
                SELECT `team_id`
                FROM `team`
                WHERE `team_user_id`=$num_get
            )
            AND `conference_season_id`=$igosja_season_id
        ) AS `t2`
        ON `team_id`=`conference_team_id`
        WHERE `team_user_id`=$num_get
        ORDER BY `team_id` ASC";
$team_sql = f_igosja_mysqli_query($sql);

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `buyer_country`.`country_name` AS `buyer_country_name`,
               `buyer_city`.`city_name` AS `buyer_city_name`,
               `buyer_team`.`team_id` AS `buyer_team_id`,
               `buyer_team`.`team_name` AS `buyer_team_name`,
               `name_name`,
               `player_country_id`,
               `player_country`.`country_name` AS `player_country_name`,
               `player_id`,
               `seller_country`.`country_name` AS `seller_country_name`,
               `seller_city`.`city_name` AS `seller_city_name`,
               `seller_team`.`team_id` AS `seller_team_id`,
               `seller_team`.`team_name` AS `seller_team_name`,
               `surname_name`,
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
        AND `transfer_season_id`=$igosja_season_id
        AND `transfer_user_seller_id`=$num_get
        ORDER BY `transfer_date` DESC";
$transfer_sell_sql = f_igosja_mysqli_query($sql);

$transfer_sell_array = $transfer_sell_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `buyer_country`.`country_name` AS `buyer_country_name`,
               `buyer_city`.`city_name` AS `buyer_city_name`,
               `buyer_team`.`team_id` AS `buyer_team_id`,
               `buyer_team`.`team_name` AS `buyer_team_name`,
               `name_name`,
               `player_country_id`,
               `player_country`.`country_name` AS `player_country_name`,
               `player_id`,
               `seller_country`.`country_name` AS `seller_country_name`,
               `seller_city`.`city_name` AS `seller_city_name`,
               `seller_team`.`team_id` AS `seller_team_id`,
               `seller_team`.`team_name` AS `seller_team_name`,
               `surname_name`,
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
        AND `transfer_season_id`=$igosja_season_id
        AND `transfer_user_buyer_id`=$num_get
        ORDER BY `transfer_date` DESC";
$transfer_buy_sql = f_igosja_mysqli_query($sql);

$transfer_buy_array = $transfer_buy_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `buyer_country`.`country_name` AS `buyer_country_name`,
               `buyer_city`.`city_name` AS `buyer_city_name`,
               `buyer_team`.`team_id` AS `buyer_team_id`,
               `buyer_team`.`team_name` AS `buyer_team_name`,
               `name_name`,
               `player_country_id`,
               `player_country`.`country_name` AS `player_country_name`,
               `player_id`,
               `seller_country`.`country_name` AS `seller_country_name`,
               `seller_city`.`city_name` AS `seller_city_name`,
               `seller_team`.`team_id` AS `seller_team_id`,
               `seller_team`.`team_name` AS `seller_team_name`,
               `surname_name`,
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
        AND `rent_season_id`=$igosja_season_id
        AND `rent_user_seller_id`=$num_get
        ORDER BY `rent_date` DESC";
$rent_sell_sql = f_igosja_mysqli_query($sql);

$rent_sell_array = $rent_sell_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `buyer_country`.`country_name` AS `buyer_country_name`,
               `buyer_city`.`city_name` AS `buyer_city_name`,
               `buyer_team`.`team_id` AS `buyer_team_id`,
               `buyer_team`.`team_name` AS `buyer_team_name`,
               `name_name`,
               `player_country_id`,
               `player_country`.`country_name` AS `player_country_name`,
               `player_id`,
               `seller_country`.`country_name` AS `seller_country_name`,
               `seller_city`.`city_name` AS `seller_city_name`,
               `seller_team`.`team_id` AS `seller_team_id`,
               `seller_team`.`team_name` AS `seller_team_name`,
               `surname_name`,
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
        AND `rent_season_id`=$igosja_season_id
        AND `rent_user_buyer_id`=$num_get
        ORDER BY `rent_date` DESC";
$rent_buy_sql = f_igosja_mysqli_query($sql);

$rent_buy_array = $rent_buy_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `position_id`,
               `position_short`
        FROM `position`
        ORDER BY `position_id` ASC";
$position_sql = f_igosja_mysqli_query($sql);

$position_array = $position_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `special_id`,
               `special_name`
        FROM `special`
        ORDER BY `special_id` ASC";
$special_sql = f_igosja_mysqli_query($sql);

$special_array = $special_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = $user_array[0]['user_login'] . '. Сделки менеджера';
$seo_description    = $user_array[0]['user_login'] . '. Сделки менеджера на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $user_array[0]['user_login'] . ' сделки менеджера';

include(__DIR__ . '/view/layout/main.php');