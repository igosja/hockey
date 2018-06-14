<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

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
        WHERE `teamask_id`=$num_get
        LIMIT 1";
$teamask_sql = f_igosja_mysqli_query($sql);

if (0 == $teamask_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$teamask_array = $teamask_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'teamask_list.php', 'text' => 'Заявки на команды');
$breadcrumb_array[] = $teamask_array[0]['team_name'];

include(__DIR__ . '/view/layout/main.php');