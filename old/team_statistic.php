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

$sql = "SELECT `base_level`,
               `basemedical_level`+`basephisical_level`+`baseschool_level`+`basescout_level`+`basetraining_level` AS `base_used`,
               `player`,
               `stadium_capacity`,
               `team_age`,
               `team_power_vs`,
               `team_price_base`,
               `team_price_stadium`,
               `team_price_total`,
               `team_salary`,
               `team_visitor`,
               `ratingteam_age_place`,
               `ratingteam_age_place_country`,
               `ratingteam_base_place`,
               `ratingteam_base_place_country`,
               `ratingteam_player_place`,
               `ratingteam_player_place_country`,
               `ratingteam_power_vs_place`,
               `ratingteam_power_vs_place_country`,
               `ratingteam_price_base_place`,
               `ratingteam_price_base_place_country`,
               `ratingteam_price_stadium_place`,
               `ratingteam_price_stadium_place_country`,
               `ratingteam_price_total_place`,
               `ratingteam_price_total_place_country`,
               `ratingteam_stadium_place`,
               `ratingteam_stadium_place_country`,
               `ratingteam_visitor_place`,
               `ratingteam_visitor_place_country`
        FROM `team`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `ratingteam`
        ON `team_id`=`ratingteam_team_id`
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
        LEFT JOIN
        (
            SELECT COUNT(`player_id`) AS `player`,
                   `player_team_id`
            FROM `player`
            WHERE `player_team_id`=$num_get
        ) AS `t1`
        ON `team_id`=`player_team_id`
        WHERE `team_id`=$num_get
        LIMIT 1";
$rating_sql = f_igosja_mysqli_query($sql);

$rating_array = $rating_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = $team_array[0]['team_name'] . '. Статистика команды';
$seo_description    = $team_array[0]['team_name'] . '. Статистика команды на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $team_array[0]['team_name'] . ' статистика команды';

include(__DIR__ . '/view/layout/main.php');