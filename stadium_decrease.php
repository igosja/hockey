<?php

include (__DIR__ . '/include/include.php');

$auth_team_id = 28;

if (!isset($auth_team_id))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `stadium_capacity`,
               `stadium_name`,
               `team_finance`
        FROM `team`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        WHERE `team_id`='$auth_team_id'
        LIMIT 1";
$stadium_sql = igosja_db_query($sql);

if (0 == $stadium_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$stadium_array = $stadium_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');