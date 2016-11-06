<?php

include (__DIR__ . '/include/include.php');

$sql = "SELECT `shedule_date`,
               `shedule_id`,
               `stage_name`,
               `tournamenttype_name`
        FROM `shedule`
        LEFT JOIN `tournamenttype`
        ON `shedule_tournamenttype_id`=`tournamenttype_id`
        LEFT JOIN `stage`
        ON `shedule_stage_id`=`stage_id`
        WHERE `shedule_season_id`='$igosja_season_id'
        ORDER BY `shedule_id`ASC";
$shedule_sql = igosja_db_query($sql);

$shedule_array = $shedule_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');