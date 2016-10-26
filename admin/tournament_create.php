<?php

include (__DIR__ . '/../include/include.php');

if ($data = f_igosja_post('data'))
{
    $set_sql = f_igosja_sql_data($data);

    $sql = "INSERT INTO `tournament`
            SET $set_sql";
    igosja_db_query($sql);

    redirect('/admin/tournament_view.php?num=' . $mysqli->insert_id);
}

$sql = "SELECT `tournamenttype_id`,
               `tournamenttype_name`
        FROM `tournamenttype`
        ORDER BY `tournamenttype_id` ASC";
$tournamenttype_sql = igosja_db_query($sql);

$tournamenttype_array = $tournamenttype_sql->fetch_all(1);

$breadcrumb_array[] = array('url' => 'tournament_list.php', 'text' => 'Турниры');
$breadcrumb_array[] = 'Создание';

$tpl = 'tournament_update';

include (__DIR__ . '/view/layout/main.php');