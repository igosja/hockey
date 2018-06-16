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
               `transfer_id`,
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

$transfer_array = $transfer_sql->fetch_all(MYSQLI_ASSOC);

$transfer_id = array();

foreach ($transfer_array as $item)
{
    $transfer_id[] = $item['transfer_id'];
}

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
               `rent_id`,
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

$rent_array = $rent_sql->fetch_all(MYSQLI_ASSOC);

$rent_id = array();

foreach ($rent_array as $item)
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

$seo_title          = $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'] . '. Сделки хоккеиста';
$seo_description    = $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'] . '. Сделки хоккеиста на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'] . ' сделки хоккеиста';

include(__DIR__ . '/view/layout/main.php');