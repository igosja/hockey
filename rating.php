<?php

include(__DIR__ . '/include/include.php');

$sql = "SELECT `ratingchapter_id`,
               `ratingchapter_name`,
               `ratingtype_id`,
               `ratingtype_name`
        FROM `ratingtype`
        LEFT JOIN `ratingchapter`
        ON `ratingtype_ratingchapter_id`=`ratingchapter_id`
        ORDER BY `ratingchapter_id` ASC, `ratingtype_id` ASC";
$ratingtype_sql = f_igosja_mysqli_query($sql, false);

$count_ratingtype = $ratingtype_sql->num_rows;
$ratingtype_array = $ratingtype_sql->fetch_all(1);

if (!$num_get = f_igosja_request_get('num'))
{
    $num_get = $ratingtype_array[0]['ratingtype_id'];
}

if (RATING_TEAM_POWER == $num_get)
{
    $sql = "SELECT `city_name`,
                   `country_id`,
                   `country_name`,
                   `ratingteam_power_vs_place`,
                   `team_id`,
                   `team_name`,
                   `team_power_s_16`,
                   `team_power_s_21`,
                   `team_power_s_27`,
                   `team_power_vs`
            FROM `ratingteam`
            LEFT JOIN `team`
            ON `ratingteam_team_id`=`team_id`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`city_id`
            LEFT JOIN `country`
            ON `city_country_id`=`country_id`
            ORDER BY `ratingteam_power_vs_place` ASC, `team_id` ASC";
}
elseif (RATING_TEAM_AGE == $num_get)
{
    $sql = "SELECT `city_name`,
                   `country_id`,
                   `country_name`,
                   `ratingteam_age_place`,
                   `team_age`,
                   `team_id`,
                   `team_name`
            FROM `ratingteam`
            LEFT JOIN `team`
            ON `ratingteam_team_id`=`team_id`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`city_id`
            LEFT JOIN `country`
            ON `city_country_id`=`country_id`
            ORDER BY `ratingteam_age_place` ASC, `team_id` ASC";
}
elseif (RATING_TEAM_STADIUM == $num_get)
{
    $sql = "SELECT `city_name`,
                   `country_id`,
                   `country_name`,
                   `ratingteam_stadium_place`,
                   `stadium_capacity`,
                   `team_id`,
                   `team_name`
            FROM `ratingteam`
            LEFT JOIN `team`
            ON `ratingteam_team_id`=`team_id`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`city_id`
            LEFT JOIN `country`
            ON `city_country_id`=`country_id`
            ORDER BY `ratingteam_stadium_place` ASC, `team_id` ASC";
}
elseif (RATING_TEAM_VISITOR == $num_get)
{
    $sql = "SELECT `city_name`,
                   `country_id`,
                   `country_name`,
                   `ratingteam_visitor_place`,
                   `team_id`,
                   `team_name`,
                   `team_visitor`
            FROM `ratingteam`
            LEFT JOIN `team`
            ON `ratingteam_team_id`=`team_id`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`city_id`
            LEFT JOIN `country`
            ON `city_country_id`=`country_id`
            ORDER BY `ratingteam_visitor_place` ASC, `team_id` ASC";
}
elseif (RATING_TEAM_BASE == $num_get)
{
    $sql = "SELECT `base_level`,
                   `basemedical_level`,
                   `basephisical_level`,
                   `baseschool_level`,
                   `basescout_level`,
                   `basetraining_level`,
                   `city_name`,
                   `country_id`,
                   `country_name`,
                   `ratingteam_base_place`,
                   `team_id`,
                   `team_name`,
                   `team_visitor`
            FROM `ratingteam`
            LEFT JOIN `team`
            ON `ratingteam_team_id`=`team_id`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`city_id`
            LEFT JOIN `country`
            ON `city_country_id`=`country_id`
            LEFT JOIN `base`
            ON `team_base_id`=`base_id`
            LEFT JOIN `basemedical`
            ON `team_basemedical_id`=`basemedical_id`
            LEFT JOIN `basephisical`
            ON `team_basephisical_id`=`basephisical_id`
            LEFT JOIN `baseschool`
            ON `team_baseschool_id`=`baseschool_id`
            LEFT JOIN `basescout`
            ON `team_basescout_id`=`basescout_id`
            LEFT JOIN `basetraining`
            ON `team_basetraining_id`=`basetraining_id`
            ORDER BY `ratingteam_base_place` ASC, `team_id` ASC";
}
elseif (RATING_TEAM_PRICE_BASE == $num_get)
{
    $sql = "SELECT `city_name`,
                   `country_id`,
                   `country_name`,
                   `ratingteam_price_base_place`,
                   `team_id`,
                   `team_name`,
                   `team_price_base`
            FROM `ratingteam`
            LEFT JOIN `team`
            ON `ratingteam_team_id`=`team_id`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`city_id`
            LEFT JOIN `country`
            ON `city_country_id`=`country_id`
            ORDER BY `ratingteam_price_base_place` ASC, `team_id` ASC";
}
elseif (RATING_TEAM_PRICE_STADIUM == $num_get)
{
    $sql = "SELECT `city_name`,
                   `country_id`,
                   `country_name`,
                   `ratingteam_price_stadium_place`,
                   `team_price_stadium`,
                   `team_id`,
                   `team_name`
            FROM `ratingteam`
            LEFT JOIN `team`
            ON `ratingteam_team_id`=`team_id`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`city_id`
            LEFT JOIN `country`
            ON `city_country_id`=`country_id`
            ORDER BY `ratingteam_price_stadium_place` ASC, `team_id` ASC";
}
elseif (RATING_TEAM_PLAYER == $num_get)
{
    $sql = "SELECT `city_name`,
                   `country_id`,
                   `country_name`,
                   `ratingteam_player_place`,
                   `team_id`,
                   `team_name`,
                   `team_player`,
                   `team_price_player`,
                   `team_salary`
            FROM `ratingteam`
            LEFT JOIN `team`
            ON `ratingteam_team_id`=`team_id`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`city_id`
            LEFT JOIN `country`
            ON `city_country_id`=`country_id`
            ORDER BY `ratingteam_player_place` ASC, `team_id` ASC";
}
elseif (RATING_TEAM_PRICE_TOTAL == $num_get)
{
    $sql = "SELECT `city_name`,
                   `country_id`,
                   `country_name`,
                   `ratingteam_price_total_place`,
                   `team_finance`,
                   `team_id`,
                   `team_name`,
                   `team_price_base`,
                   `team_price_player`,
                   `team_price_stadium`,
                   `team_price_total`
            FROM `ratingteam`
            LEFT JOIN `team`
            ON `ratingteam_team_id`=`team_id`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`city_id`
            LEFT JOIN `country`
            ON `city_country_id`=`country_id`
            ORDER BY `ratingteam_price_total_place` ASC, `team_id` ASC";
}
elseif (RATING_USER_RATING == $num_get)
{
    $sql = "SELECT `country_id`,
                   `country_name`,
                   `ratinguser_rating_place`,
                   `user_id`,
                   `user_login`,
                   `user_rating`
            FROM `ratinguser`
            LEFT JOIN `user`
            ON `ratinguser_user_id`=`user_id`
            LEFT JOIN `country`
            ON `user_country_id`=`country_id`
            ORDER BY `ratinguser_rating_place` ASC, `user_id` ASC";
}
elseif (RATING_COUNTRY_STADIUM == $num_get)
{
    $sql = "SELECT `country_id`,
                   `country_name`,
                   `country_stadium`,
                   `ratingcountry_stadium_place`
            FROM `ratingcountry`
            LEFT JOIN `country`
            ON `ratingcountry_country_id`=`country_id`
            ORDER BY `ratingcountry_stadium_place` ASC, `country_id` ASC";
}
elseif (RATING_COUNTRY_AUTO == $num_get)
{
    $sql = "SELECT `country_auto`,
                   `country_game`,
                   `country_id`,
                   `country_name`,
                   `ratingcountry_auto_place`
            FROM `ratingcountry`
            LEFT JOIN `country`
            ON `ratingcountry_country_id`=`country_id`
            ORDER BY `ratingcountry_auto_place` ASC, `country_id` ASC";
}

$rating_sql = f_igosja_mysqli_query($sql, false);

$rating_array = $rating_sql->fetch_all(1);

$seo_title          = 'Рейтинги';
$seo_description    = 'Рейтинги на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'рейтинги';

include(__DIR__ . '/view/layout/main.php');