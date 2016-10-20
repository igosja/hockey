<?php

$sql = "SELECT COUNT(`teamask_id`) AS `count`
        FROM `teamask`";
$teamask_sql = igosja_db_query($sql);

$teamask_array = $teamask_sql->fetch_all(1);