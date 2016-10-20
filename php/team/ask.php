<?php

$sql = "SELECT COUNT(`team_id`) AS `check`
        FROM `team`
        WHERE `team_user_id`='$auth_user_id'";
$team_sql = igosja_db_query($sql);

$team_array = $team_sql->fetch_all(1);

if ($team_array[0]['check']) {
    redirect('/team/');
}

if ($num_get) {
    $sql = "SELECT COUNT(`team_id`) AS `check`
            FROM `team`
            WHERE `team_id`='$num_get'
            AND `team_user_id`='0'";
    $team_sql = igosja_db_query($sql);

    $team_array = $team_sql->fetch_all(1);

    if (!$team_array[0]['check']) {
        $_SESSION['message']['text'] = 'Команда выбрана неправильно';
        $_SESSION['message']['class'] = 'error';
        refresh('/' . $route_path . '/' . $route_file);
    }

    $sql = "SELECT COUNT(`teamask_id`) AS `check`
            FROM `teamask`
            WHERE `teamask_user_id`='$auth_user_id'";
    $teamask_sql = igosja_db_query($sql);

    $teamask_array = $teamask_sql->fetch_all(1);

    if ($teamask_array[0]['check']) {
        $_SESSION['message']['text'] = 'Вы уже подали заявку';
        $_SESSION['message']['class'] = 'error';
        refresh('/' . $route_path . '/' . $route_file);
    }

    $sql = "INSERT INTO `teamask`
            SET `teamask_date`=UNIX_TIMESTAMP(),
                `teamask_team_id`='$num_get',
                `teamask_user_id`='$auth_user_id'";
    igosja_db_query($sql);

    $_SESSION['message']['text'] = 'Заявка успешно подана';
    $_SESSION['message']['class'] = 'success';
    refresh('/' . $route_path . '/' . $route_file);
}

$sql = "SELECT `city_name`,
               `country_id`,
               `country_name`,
               `stadium_capacity`,
               `team_id`,
               `team_base_id`,
               `team_basemedical_id`+
               `team_basephisical_id`+
               `team_baseschool_id`+
               `team_basescout_id`+
               `team_basetraining_id` AS `team_base_slot_used`,
               `team_finance`,
               `team_name`
        FROM `team`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `team_user_id`='0'
        ORDER BY `team_id`";
$team_sql = igosja_db_query($sql);

$team_array = $team_sql->fetch_all(1);