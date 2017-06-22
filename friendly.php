<?php

/**
 * @var $auth_team_id integer
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_team_id))
{
    redirect('/wrong_page.php');
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
$team_sql = f_igosja_mysqli_query($sql);

$team_array = $team_sql->fetch_all(1);

$sql = "SELECT `shedule_date`,
               `shedule_id`
        FROM `shedule`
        WHERE `shedule_date`>UNIX_TIMESTAMP()
        AND `shedule_date`<UNIX_TIMESTAMP()+1209600
        AND `shedule_tournamenttype_id`=" . TOURNAMENTTYPE_FRIENDLY . "
        ORDER BY `shedule_date` ASC";
$shedule_sql = f_igosja_mysqli_query($sql);

$shedule_array = $shedule_sql->fetch_all(1);

include(__DIR__ . '/view/layout/main.php');