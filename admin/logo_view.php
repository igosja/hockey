<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `logo_id`,
               `logo_date`,
               `logo_text`,
               `team_id`,
               `team_name`,
               `user_id`,
               `user_login`
        FROM `logo`
        LEFT JOIN `team`
        ON `logo_team_id`=`team_id`
        LEFT JOIN `user`
        ON `logo_user_id`=`user_id`
        WHERE `logo_id`=$num_get
        LIMIT 1";
$logo_sql = f_igosja_mysqli_query($sql);

if (0 == $logo_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$logo_array = $logo_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'logo_list.php', 'text' => 'Логотипы команд');
$breadcrumb_array[] = $logo_array[0]['team_name'];

include(__DIR__ . '/view/layout/main.php');