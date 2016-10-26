<?php

include (__DIR__ . '/../include/include.php');

$num_get = (int) f_igosja_get('num');

$sql = "SELECT `tournament_id`,
               `tournament_name`,
               `tournamenttype_id`,
               `tournamenttype_name`
        FROM `tournament`
        LEFT JOIN `tournamenttype`
        ON `tournament_tournamenttype_id`=`tournamenttype_id`
        WHERE `tournament_id`='$num_get'
        LIMIT 1";
$tournament_sql = igosja_db_query($sql);

if (0 == $tournament_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$tournament_array = $tournament_sql->fetch_all(1);

$breadcrumb_array[] = array('url' => 'tournament_list.php', 'text' => 'Турниры');
$breadcrumb_array[] = $tournament_array[0]['tournament_name'];

include (__DIR__ . '/view/layout/main.php');