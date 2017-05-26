<?php

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

include(__DIR__ . '/include/sql/country_view.php');

$sql = "SELECT `team_id`,
               `team_name`,
               `user_date_login`,
               `user_id`,
               `user_login`,
               `user_name`,
               `user_surname`
        FROM `team`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `user`
        ON `team_user_id`=`user_id`
        WHERE `city_country_id`=$num_get
        ORDER BY `team_name` ASC";
$team_sql = f_igosja_mysqli_query($sql);

$team_array = $team_sql->fetch_all(1);

include(__DIR__ . '/view/layout/main.php');