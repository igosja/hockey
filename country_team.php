<?php

include (__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `country_name`
        FROM `country`
        WHERE `country_id`='$num_get'
        LIMIT 1";
$country_sql = f_igosja_mysqli_query($sql);

if (0 == $country_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$country_array = $country_sql->fetch_all(1);

$sql = "SELECT `team_id`,
               `team_name`
        FROM `team`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        WHERE `city_country_id`='$num_get'
        ORDER BY `team_name` ASC";
$team_sql = f_igosja_mysqli_query($sql);

$team_array = $team_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');