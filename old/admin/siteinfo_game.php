<?php

include(__DIR__ . '/../include/include.php');

$sql = "SELECT AVG(`game_home_penalty`+`game_guest_penalty`) AS `penalty`,
               AVG(`game_home_score`+`game_guest_score`) AS `score`,
               AVG(`game_home_shot`+`game_guest_shot`) AS `shot`
        FROM `game`
        LEFT JOIN `schedule`
        ON `game_schedule_id`=`schedule_id`
        WHERE `game_played`=1
        AND `schedule_date`>UNIX_TIMESTAMP()-604800";
$game_sql = f_igosja_mysqli_query($sql);

$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = 'Игровая статистика';

include(__DIR__ . '/view/layout/main.php');