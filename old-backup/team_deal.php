<?php

/**
 * @var $auth_team_id integer
 * @var $igosja_season_id integer
 */

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
        AND `transfer_team_seller_id`=$num_get
        ORDER BY `transfer_date` DESC";
$transfer_sell_sql = f_igosja_mysqli_query($sql);

$transfer_sell_array = $transfer_sell_sql->fetch_all(MYSQLI_ASSOC);

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
        AND `transfer_team_buyer_id`=$num_get
        ORDER BY `transfer_date` DESC";
$transfer_buy_sql = f_igosja_mysqli_query($sql);

$transfer_buy_array = $transfer_buy_sql->fetch_all(MYSQLI_ASSOC);

$transfer_id = array();

foreach ($transfer_sell_array as $item)
{
    $transfer_id[] = $item['transfer_id'];
}

foreach ($transfer_buy_array as $item)
{
    $transfer_id[] = $item['transfer_id'];
}

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
        AND `rent_team_seller_id`=$num_get
        ORDER BY `rent_date` DESC";
$rent_sell_sql = f_igosja_mysqli_query($sql);

$rent_sell_array = $rent_sell_sql->fetch_all(MYSQLI_ASSOC);

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
        AND `rent_team_buyer_id`=$num_get
        ORDER BY `rent_date` DESC";
$rent_buy_sql = f_igosja_mysqli_query($sql);

$rent_buy_array = $rent_buy_sql->fetch_all(MYSQLI_ASSOC);

$rent_id = array();

foreach ($rent_sell_array as $item)
{
    $rent_id[] = $item['rent_id'];
}

foreach ($rent_buy_array as $item)
{
    $rent_id[] = $item['rent_id'];
}

if (count($transfer_id) || count($rent_id))
{
    if (count($transfer_id))
    {
        $transfer_id = implode(', ', $transfer_id);

        $sql = "SELECT `transferposition_transfer_id` AS `playerposition_player_id`,
                       `position_name`,
                       `position_short`
                FROM `transferposition`
                LEFT JOIN `position`
                ON `transferposition_position_id`=`position_id`
                WHERE `transferposition_transfer_id` IN ($transfer_id)
                ORDER BY `transferposition_position_id` ASC";
        $playerposition_sql = f_igosja_mysqli_query($sql);

        $playerposition_1_array = $playerposition_sql->fetch_all(MYSQLI_ASSOC);

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

        $playerspecial_1_array = $playerspecial_sql->fetch_all(MYSQLI_ASSOC);
    }

    if (count($rent_id))
    {
        $rent_id = implode(', ', $rent_id);

        $sql = "SELECT `rentposition_rent_id` AS `playerposition_player_id`,
                       `position_name`,
                       `position_short`
                FROM `rentposition`
                LEFT JOIN `position`
                ON `rentposition_position_id`=`position_id`
                WHERE `rentposition_rent_id` IN ($rent_id)
                ORDER BY `rentposition_position_id` ASC";
        $playerposition_sql = f_igosja_mysqli_query($sql);

        $playerposition_2_array = $playerposition_sql->fetch_all(MYSQLI_ASSOC);

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

        $playerspecial_2_array = $playerspecial_sql->fetch_all(MYSQLI_ASSOC);
    }

    if (isset($playerposition_1_array) && isset($playerposition_2_array))
    {
        $playerposition_array   = array_merge($playerposition_1_array, $playerposition_2_array);
        $playerspecial_array    = array_merge($playerspecial_1_array, $playerspecial_2_array);
    }
    elseif (isset($playerposition_1_array))
    {
        $playerposition_array   = $playerposition_1_array;
        $playerspecial_array    = $playerspecial_1_array;
    }
    else
    {
        $playerposition_array   = $playerposition_2_array;
        $playerspecial_array    = $playerspecial_2_array;
    }
}
else
{
    $playerposition_array   = array();
    $playerspecial_array    = array();
}

$seo_title          = $team_array[0]['team_name'] . '. Сделки команды';
$seo_description    = $team_array[0]['team_name'] . '. Сделки команды на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $team_array[0]['team_name'] . ' сделки команды';

include(__DIR__ . '/view/layout/main.php');