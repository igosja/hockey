<?php

/**
 * @var $auth_team_id integer
 * @var $auth_user_id integer
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

if (0 == $auth_team_id)
{
    redirect('/wrong_page.php');
}

if (!$num_get = (int) f_igosja_request_get('num'))
{
    $sql = "SELECT `shedule_date`,
                   `shedule_id`
            FROM `shedule`
            WHERE `shedule_date`>UNIX_TIMESTAMP()
            AND `shedule_tournamenttype_id`=" . TOURNAMENTTYPE_FRIENDLY . "
            ORDER BY `shedule_date` ASC
            LIMIT 1";
    $shedule_sql = f_igosja_mysqli_query($sql);

    if (0 == $shedule_sql->num_rows)
    {
        $num_get = 0;
    }
    else
    {
        $shedule_array = $shedule_sql->fetch_all(1);

        $num_get        = $shedule_array[0]['shedule_id'];
        $selected_date  = $shedule_array[0]['shedule_date'];
    }
}
else
{
    $sql = "SELECT `shedule_date`
            FROM `shedule`
            WHERE `shedule_id`=$num_get
            LIMIT 1";
    $shedule_sql = f_igosja_mysqli_query($sql);

    $shedule_array = $shedule_sql->fetch_all(1);

    $selected_date = $shedule_array[0]['shedule_date'];
}

$sql = "SELECT `city_name`,
               `country_name`,
               `friendlystatus_name`,
               `team_name`
        FROM `team`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        LEFT JOIN `user`
        ON `team_user_id`=`user_id`
        LEFT JOIN `friendlystatus`
        ON `user_friendlystatus_id`=`friendlystatus_id`
        WHERE `team_id`=$auth_team_id
        LIMIT 1";
$myteam_sql = f_igosja_mysqli_query($sql);

$myteam_array = $myteam_sql->fetch_all(1);

$sql = "SELECT `shedule_date`,
               `shedule_id`
        FROM `shedule`
        WHERE `shedule_date`>UNIX_TIMESTAMP()
        AND `shedule_date`<UNIX_TIMESTAMP()+1209600
        AND `shedule_tournamenttype_id`=" . TOURNAMENTTYPE_FRIENDLY . "
        ORDER BY `shedule_date` ASC";
$shedule_sql = f_igosja_mysqli_query($sql);

$shedule_array = $shedule_sql->fetch_all(1);

$sql = "SELECT *
        FROM `friendlyinvite`
        WHERE `friendlyinvite_shedule_id`=$num_get
        AND `friendlyinvite_home_team_id`=$auth_team_id
        AND `friendlyinvite_home_user_id`=$auth_user_id
        ORDER BY `friendlyinvite_id` ASC";
$invite_send_sql = f_igosja_mysqli_query($sql);

$invite_send_array = $invite_send_sql->fetch_all(1);

$sql = "SELECT *
        FROM `friendlyinvite`
        WHERE `friendlyinvite_shedule_id`=$num_get
        AND `friendlyinvite_guest_team_id`=$auth_team_id
        ORDER BY `friendlyinvite_id` ASC";
$invite_send_sql = f_igosja_mysqli_query($sql);

$invite_send_array = $invite_send_sql->fetch_all(1);

$sql = "SELECT `team_id`
        FROM `team`
        LEFT JOIN `user`
        ON `team_user_id`=`user_id`
        WHERE `user_friendlystatus_id`!=" . FRIENDLY_STATUS_NONE . "
        ORDER BY `team_power_vs` DESC";
$team_sql = f_igosja_mysqli_query($sql);

$team_array = $team_sql->fetch_all(1);

include(__DIR__ . '/view/layout/main.php');