<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT COUNT(`teamask_id`) AS `count`
        FROM `teamask`";
$teamask_sql = igosja_db_query($sql);

$teamask_array = $teamask_sql->fetch_all(1);

$sql = "SELECT COUNT(`message_id`) AS `count`
        FROM `message`
        WHERE `message_support_to`='1'
        AND `message_read`='0'";
$support_sql = igosja_db_query($sql);

$support_array = $support_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');