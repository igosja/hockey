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

$sql = "SELECT `log_date`,
               `log_season_id`,
               `logtext_name`
        FROM `log`
        LEFT JOIN `logtext`
        ON `log_logtext_id`=`logtext_id`
        WHERE `log_team_id`=$num_get
        ORDER BY `log_id` DESC";
$event_sql = f_igosja_mysqli_query($sql);

$event_array = $event_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');