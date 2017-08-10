<?php

include(__DIR__ . '/../include/include.php');

$sql = "SELECT COUNT(`team_id`) AS `count`
        FROM `team`
        WHERE `team_user_id`=0";
$freeteam_sql = f_igosja_mysqli_query($sql, false);

$freeteam_array = $freeteam_sql->fetch_all(1);

$sql = "SELECT COUNT(`teamask_id`) AS `count`
        FROM `teamask`";
$teamask_sql = f_igosja_mysqli_query($sql, false);

$teamask_array = $teamask_sql->fetch_all(1);

$sql = "SELECT COUNT(`message_id`) AS `count`
        FROM `message`
        WHERE `message_support_to`=1
        AND `message_read`=0";
$support_sql = f_igosja_mysqli_query($sql, false);

$support_array = $support_sql->fetch_all(1);

include(__DIR__ . '/view/layout/main.php');