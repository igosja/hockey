<?php

/**
 * @var $auth_user_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `bcity`.`city_name` AS `bcity_name`,
               `bcountry`.`country_name` AS `bcountry_name`,
               `bteam`.`team_id` AS `bteam_id`,
               `bteam`.`team_name` AS `bteam_name`,
               `buser`.`user_id` AS `buser_id`,
               `buser`.`user_login` AS `buser_login`,
               `name_name`,
               `pl_country`.`country_id` AS `pl_country_id`,
               `pl_country`.`country_name` AS `pl_country_name`,
               `player_id`,
               `scity`.`city_name` AS `scity_name`,
               `scountry`.`country_name` AS `scountry_name`,
               `steam`.`team_id` AS `steam_id`,
               `steam`.`team_name` AS `steam_name`,
               `suser`.`user_id` AS `suser_id`,
               `suser`.`user_login` AS `suser_login`,
               `surname_name`,
               `rent_age`,
               `rent_cancel`,
               `rent_checked`,
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
        LEFT JOIN `country` AS `pl_country`
        ON `player_country_id`=`pl_country`.`country_id`
        LEFT JOIN `team` AS `bteam`
        ON `rent_team_buyer_id`=`bteam`.`team_id`
        LEFT JOIN `stadium` AS `bstadium`
        ON `bteam`.`team_stadium_id`=`bstadium`.`stadium_id`
        LEFT JOIN `city` AS `bcity`
        ON `bstadium`.`stadium_city_id`=`bcity`.`city_id`
        LEFT JOIN `country` AS `bcountry`
        ON `bcity`.`city_country_id`=`bcountry`.`country_id`
        LEFT JOIN `user` AS `buser`
        ON `rent_user_buyer_id`=`buser`.`user_id`
        LEFT JOIN `team` AS `steam`
        ON `rent_team_seller_id`=`steam`.`team_id`
        LEFT JOIN `stadium` AS `sstadium`
        ON `steam`.`team_stadium_id`=`sstadium`.`stadium_id`
        LEFT JOIN `city` AS `scity`
        ON `sstadium`.`stadium_city_id`=`scity`.`city_id`
        LEFT JOIN `country` AS `scountry`
        ON `scity`.`city_country_id`=`scountry`.`country_id`
        LEFT JOIN `user` AS `suser`
        ON `rent_user_seller_id`=`suser`.`user_id`
        WHERE `rent_ready`=1
        AND `rent_id`=$num_get
        LIMIT 1";
$rent_sql = f_igosja_mysqli_query($sql);

if (0 == $rent_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$rent_array = $rent_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `rentposition_rent_id` AS `playerposition_player_id`,
               `position_name`,
               `position_short`
        FROM `rentposition`
        LEFT JOIN `position`
        ON `rentposition_position_id`=`position_id`
        WHERE `rentposition_rent_id`=$num_get
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
        WHERE `rentspecial_rent_id`=$num_get
        ORDER BY `rentspecial_level` DESC, `rentspecial_special_id` ASC";
$playerspecial_sql = f_igosja_mysqli_query($sql);

$playerspecial_array = $playerspecial_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `city_name`,
               `country_name`,
               `rentapplication_date`,
               `rentapplication_day`,
               `rentapplication_price`,
               `team_id`,
               `team_name`,
               `user_id`,
               `user_login`
        FROM `rentapplication`
        LEFT JOIN `team`
        ON `rentapplication_team_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        LEFT JOIN `user`
        ON `rentapplication_user_id`=`user_id`
        WHERE `rentapplication_rent_id`=$num_get
        ORDER BY `rentapplication_price`*`rentapplication_day` DESC, `rentapplication_date` DESC";
$rentapplication_sql = f_igosja_mysqli_query($sql);

$rentapplication_array = $rentapplication_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT COUNT(`rentvote_rent_id`) AS `rating`
        FROM `rentvote`
        WHERE `rentvote_rent_id`=$num_get
        AND `rentvote_rating`=1";
$rating_plus_sql = f_igosja_mysqli_query($sql);

$rating_plus_array = $rating_plus_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT COUNT(`rentvote_rent_id`) AS `rating`
        FROM `rentvote`
        WHERE `rentvote_rent_id`=$num_get
        AND `rentvote_rating`=-1";
$rating_minus_sql = f_igosja_mysqli_query($sql);

$rating_minus_array = $rating_minus_sql->fetch_all(MYSQLI_ASSOC);

$rating_my = 1;

if (0 == $rent_array[0]['rent_checked'] && isset($auth_user_id))
{
    $sql = "SELECT COUNT(`rentvote_rent_id`) AS `check`
            FROM `rentvote`
            WHERE `rentvote_rent_id`=$num_get
            AND `rentvote_user_id`=$auth_user_id";
    $rating_my_sql = f_igosja_mysqli_query($sql);

    $rating_my_array = $rating_my_sql->fetch_all(MYSQLI_ASSOC);

    $rating_my = $rating_my_array[0]['check'];
}

$seo_title          = 'Арендная сделка';
$seo_description    = 'Арендная сделка на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'арендная сделка';

include(__DIR__ . '/view/layout/main.php');