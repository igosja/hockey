<?php

include (__DIR__ . '/../include/include.php');

$num_get = (int) f_igosja_get('num');

if ($data = f_igosja_post('data'))
{
    $set_sql = f_igosja_sql_data($data);

    $sql = "UPDATE `tournament`
            SET $set_sql
            WHERE `tournament_id`='$num_get'
            LIMIT 1";
    igosja_db_query($sql);

    redirect('/admin/tournament_view.php?num=' . $num_get);
}

$sql = "SELECT `tournament_id`,
               `tournament_name`,
               `tournament_tournamenttype_id`
        FROM `tournament`
        WHERE `tournament_id`='$num_get'
        LIMIT 1";
$tournament_sql = igosja_db_query($sql);

if (0 == $tournament_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$tournament_array = $tournament_sql->fetch_all(1);

$sql = "SELECT `tournamenttype_id`,
               `tournamenttype_name`
        FROM `tournamenttype`
        ORDER BY `tournamenttype_id` ASC";
$tournamenttype_sql = igosja_db_query($sql);

$tournamenttype_array = $tournamenttype_sql->fetch_all(1);

$breadcrumb_array[] = array('url' => 'tournament_list.php', 'text' => 'Турниры');
$breadcrumb_array[] = array(
    'url' => 'tournament_view.php?num=' . $tournament_array[0]['tournament_id'],
    'text' => $tournament_array[0]['tournament_name']
);
$breadcrumb_array[] = 'Редактирование';

include (__DIR__ . '/view/layout/main.php');