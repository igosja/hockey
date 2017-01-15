<?php

include (__DIR__ . '/include/include.php');

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

include (__DIR__ . '/include/sql/team_view_left.php');
include (__DIR__ . '/include/sql/team_view_right.php');

$sql = "SELECT `stadium_capacity`,
               `team_finance`,
               `team_power_c_16`,
               `team_power_c_21`,
               `team_power_c_27`,
               `team_power_s_16`,
               `team_power_s_21`,
               `team_power_s_27`,
               `team_power_v`,
               `team_power_vs`,
               `team_price_base`,
               `team_price_stadium`,
               `team_price_player`,
               `team_price_total`,
               `team_salary`,
               `team_visitor`,
               `teamrating_capacity_country`,
               `teamrating_capacity_division`,
               `teamrating_capacity_league`,
               `teamrating_power_c_16_country`,
               `teamrating_power_c_16_division`,
               `teamrating_power_c_16_league`,
               `teamrating_power_c_21_country`,
               `teamrating_power_c_21_division`,
               `teamrating_power_c_21_league`,
               `teamrating_power_c_27_country`,
               `teamrating_power_c_27_division`,
               `teamrating_power_c_27_league`,
               `teamrating_power_s_16_country`,
               `teamrating_power_s_16_division`,
               `teamrating_power_s_16_league`,
               `teamrating_power_s_21_country`,
               `teamrating_power_s_21_division`,
               `teamrating_power_s_21_league`,
               `teamrating_power_s_27_country`,
               `teamrating_power_s_27_division`,
               `teamrating_power_s_27_league`,
               `teamrating_power_v_country`,
               `teamrating_power_v_division`,
               `teamrating_power_v_league`,
               `teamrating_power_vs_country`,
               `teamrating_power_vs_division`,
               `teamrating_power_vs_league`,
               `teamrating_price_base_country`,
               `teamrating_price_base_division`,
               `teamrating_price_base_league`,
               `teamrating_price_finance_country`,
               `teamrating_price_finance_division`,
               `teamrating_price_finance_league`,
               `teamrating_price_player_country`,
               `teamrating_price_player_division`,
               `teamrating_price_player_league`,
               `teamrating_price_stadium_country`,
               `teamrating_price_stadium_division`,
               `teamrating_price_stadium_league`,
               `teamrating_price_total_country`,
               `teamrating_price_total_division`,
               `teamrating_price_total_league`,
               `teamrating_salary_country`,
               `teamrating_salary_division`,
               `teamrating_salary_league`,
               `teamrating_visitor_country`,
               `teamrating_visitor_division`,
               `teamrating_visitor_league`
        FROM `team`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `teamrating`
        ON `team_id`=`teamrating_team_id`
        WHERE `team_id`=$num_get
        LIMIT 1";
$rating_sql = f_igosja_mysqli_query($sql);

$rating_array = $rating_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');