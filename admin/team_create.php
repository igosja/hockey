<?php

include(__DIR__ . '/../include/include.php');

if ($data = f_igosja_request_post('data'))
{
    $set_sql = f_igosja_sql_data($data, array(
        'team_stadium_id',
        'team_name'
    ));

    $sql = "INSERT INTO `team`
            SET $set_sql";
    f_igosja_mysqli_query($sql);

    $num_get = $mysqli->insert_id;

    $log = array(
        'history_historytext_id' => HISTORYTEXT_TEAM_REGISTER,
        'history_team_id' => $num_get
    );
    f_igosja_history($log);
    f_igosja_create_team_players($num_get);
    f_igosja_create_league_players($num_get);

    redirect('/admin/team_view.php?num=' . $num_get);
}

$sql = "SELECT `stadium_id`,
               `stadium_name`
        FROM `stadium`
        ORDER BY `stadium_name` ASC, `stadium_id` ASC";
$stadium_sql = f_igosja_mysqli_query($sql);

$stadium_array = $stadium_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'team_list.php', 'text' => 'Команды');
$breadcrumb_array[] = 'Создание';

$tpl = 'team_update';

include(__DIR__ . '/view/layout/main.php');