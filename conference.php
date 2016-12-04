<?php

include (__DIR__ . '/include/include.php');

$sql = "SELECT COUNT(`conference_id`) AS `count`
        FROM `conference`
        WHERE `conference_season_id`='$igosja_season_id'";
$team_sql = f_igosja_mysqli_query($sql);

$team_array = $team_sql->fetch_all(1);
$count_team = $team_array[0]['count'];

include (__DIR__ . '/view/layout/main.php');