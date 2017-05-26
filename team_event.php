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

$sql = "SELECT `history_date`,
               `history_season_id`,
               `historytext_name`
        FROM `history`
        LEFT JOIN `historytext`
        ON `history_historytext_id`=`historytext_id`
        WHERE `history_team_id`=$num_get
        ORDER BY `history_id` DESC";
$event_sql = f_igosja_mysqli_query($sql);

$event_array = $event_sql->fetch_all(1);

include(__DIR__ . '/view/layout/main.php');