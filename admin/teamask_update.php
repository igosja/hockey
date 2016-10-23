<?php

include (__DIR__ . '/../include/include.php');

$num_get = (int) f_igosja_get('num');

$sql = "SELECT `teamask_team_id`,
               `teamask_user_id`
        FROM `teamask`
        WHERE `teamask_id`='$num_get'
        LIMIT 1";
$teamask_sql = igosja_db_query($sql);

if (0 == $teamask_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$teamask_array = $teamask_sql->fetch_all(1);

$team_id = $teamask_array[0]['teamask_team_id'];
$user_id = $teamask_array[0]['teamask_user_id'];

$sql = "SELECT COUNT(`team_id`) AS `check`
        FROM `team`
        WHERE `team_id`='$team_id'
        AND `team_user_id`='0'";
$team_sql = igosja_db_query($sql);

$team_array = $team_sql->fetch_all(1);

if (!$team_array[0]['check'])
{
    $sql = "DELETE FROM `teamask`
            WHERE `teamask_team_id`='$team_id'";
    igosja_db_query($sql);

    redirect('/admin/teamask.php');
}

$sql = "SELECT COUNT(`team_id`) AS `check`
        FROM `team`
        WHERE `team_user_id`='$user_id'";
$team_sql = igosja_db_query($sql);

$team_array = $team_sql->fetch_all(1);

if ($team_array[0]['check'])
{
    $sql = "DELETE FROM `teamask`
            WHERE `teamask_user_id`='$user_id'";
    igosja_db_query($sql);

    redirect('/admin/teamask.php');
}

$sql = "UPDATE `team`
        SET `team_user_id`='$user_id'
        WHERE `team_id`='$team_id'
        LIMIT 1";
igosja_db_query($sql);

$sql = "DELETE FROM `teamask`
        WHERE `teamask_user_id`='$user_id'";
igosja_db_query($sql);

$sql = "DELETE FROM `teamask`
        WHERE `teamask_team_id`='$team_id'";
igosja_db_query($sql);

$log = array(
    'log_logtext_id' => LOGTEXT_USER_MANAGER_TEAM_IN,
    'log_team_id' => $team_id,
    'log_user_id' => $user_id,
);
f_igosja_log($log);

redirect('/admin/teamask.php');