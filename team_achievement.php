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

$sql = "SELECT `achievement_season_id`,
               `achievement_position`,
               `tournamenttype_name`
        FROM `achievement`
        LEFT JOIN `tournamenttype`
        ON `achievement_tournamenttype_id`=`tournamenttype_id`
        WHERE `achievement_team_id`=$num_get
        ORDER BY `achievement_id` DESC";
$achievement_sql = f_igosja_mysqli_query($sql);

$achievement_array = $achievement_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');