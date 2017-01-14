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
               `team_visitor`
        FROM `team`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        WHERE `team_id`=$num_get
        LIMIT 1";
$rating_sql = f_igosja_mysqli_query($sql);

$rating_array = $rating_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');