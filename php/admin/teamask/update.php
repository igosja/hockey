<?php

if ($data = f_igosja_post('data')) {
    $set_sql = f_igosja_sql_data($data);

    if (0 == $num_get) {
        $sql = "INSERT INTO `team`
                SET $set_sql";
    } else {
        $sql = "UPDATE `team`
                SET $set_sql
                WHERE `team_id`='$num_get'
                LIMIT 1";
    }

    igosja_db_query($sql);

    if (0 == $num_get) {
        $num_get = $mysqli->insert_id;
        $log = array(
            'log_logtext_id' => LOGTEXT_TEAM_REGISTER,
            'log_team_id' => $num_get
        );
        f_igosja_log($log);
        f_igosja_create_team_players($num_get);
    }

    redirect('/admin/' . $route_path . '/view/' . $num_get);
}

$sql = "SELECT `stadium_id`,
               `stadium_name`
        FROM `stadium`
        ORDER BY `stadium_name` ASC";
$stadium_sql = igosja_db_query($sql);

$stadium_array = $stadium_sql->fetch_all(1);

if (0 != $num_get) {
    $sql = "SELECT `team_stadium_id`,
                   `team_id`,
                   `team_name`
            FROM `team`
            WHERE `team_id`='$num_get'
            LIMIT 1";
    $team_sql = igosja_db_query($sql);

    $team_array = $team_sql->fetch_all(1);
}

$breadcrumb_array[] = array('url' => $route_path, 'text' => 'Команды');

if (isset($team_array)) {
    $breadcrumb_array[] = array(
        'url' => $route_path . '/view/' . $team_array[0]['team_id'],
        'text' => $team_array[0]['team_name']
    );
    $breadcrumb_array[] = 'Редактирование';
} else {
    $breadcrumb_array[] = 'Создание';
}