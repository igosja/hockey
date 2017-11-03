<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `city_id`,
               `city_name`,
               `country_id`,
               `country_name`,
               `stadium_id`,
               `stadium_capacity`,
               `stadium_name`,
               `team_id`,
               `team_name`
        FROM `team`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `team_id`=$num_get
        LIMIT 1";
$team_sql = f_igosja_mysqli_query($sql);

if (0 == $team_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'team_list.php', 'text' => 'Команды');
$breadcrumb_array[] = $team_array[0]['team_name'];

include(__DIR__ . '/view/layout/main.php');