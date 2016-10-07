<?php

$sql = "SELECT `team_name`
        FROM `team`
        WHERE `team_id`='$num_get'";
$team_sql = igosja_db_query($sql);

$team_array = $team_sql->fetch_all(1);