<?php

$sql = "SELECT `rosterphrase_text`
        FROM `rosterphrase`
        ORDER BY RAND()
        LIMIT 1";
$rosterphrase_sql = f_igosja_mysqli_query($sql);

$rosterphrase_array = $rosterphrase_sql->fetch_all(1);

$sql = "SELECT `game_id`,
               IF(`game_guest_team_id`=$num_get, `game_home_score`, `game_guest_score`) AS `guest_score`,
               IF(`game_guest_team_id`=$num_get, 'Г', 'Д') AS `home_guest`,
               IF(`game_guest_team_id`=$num_get, `game_guest_score`, `game_home_score`) AS `home_score`,
               `shedule_date`,
               `team_id`,
               `team_name`,
               `tournamenttype_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `game_shedule_id`=`shedule_id`
        LEFT JOIN `tournamenttype`
        ON `shedule_tournamenttype_id`=`tournamenttype_id`
        LEFT JOIN `team`
        ON IF(`game_guest_team_id`=$num_get, `game_home_team_id`, `game_guest_team_id`)=`team_id`
        WHERE (`game_guest_team_id`=$num_get
        OR `game_home_team_id`=$num_get)
        AND `game_played`=1
        ORDER BY `shedule_date` DESC
        LIMIT 3";
$latest_sql = f_igosja_mysqli_query($sql);

$latest_array = $latest_sql->fetch_all(1);

$sql = "SELECT `game_id`,
               IF(`game_guest_team_id`=$num_get, 'Г', 'Д') AS `home_guest`,
               `shedule_date`,
               `team_id`,
               `team_name`,
               `tournamenttype_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `game_shedule_id`=`shedule_id`
        LEFT JOIN `tournamenttype`
        ON `shedule_tournamenttype_id`=`tournamenttype_id`
        LEFT JOIN `team`
        ON IF(`game_guest_team_id`=$num_get, `game_home_team_id`, `game_guest_team_id`)=`team_id`
        WHERE (`game_guest_team_id`=$num_get
        OR `game_home_team_id`=$num_get)
        AND `game_played`=0
        ORDER BY `shedule_date` ASC
        LIMIT 2";
$nearest_sql = f_igosja_mysqli_query($sql);

$nearest_array = $nearest_sql->fetch_all(1);