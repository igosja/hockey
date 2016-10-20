<?php

$sql = "SELECT `team_id`,
               `team_name`,
               `teamask_id`,
               `teamask_date`,
               `user_id`,
               `user_login`
        FROM `teamask`
        LEFT JOIN `team`
        ON `teamask_team_id`=`team_id`
        LEFT JOIN `user`
        ON `teamask_user_id`=`user_id`
        WHERE `teamask_id`='$num_get'
        LIMIT 1";
$teamask_sql = igosja_db_query($sql);

$teamask_array = $teamask_sql->fetch_all(1);

$breadcrumb_array[] = array('url' => $route_path, 'text' => 'Заявки на команды');
$breadcrumb_array[] = $teamask_array[0]['team_name'];