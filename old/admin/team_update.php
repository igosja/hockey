<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `team_id`,
               `team_name`,
               `team_stadium_id`
        FROM `team`
        WHERE `team_id`=$num_get
        LIMIT 1";
$team_sql = f_igosja_mysqli_query($sql);

if (0 == $team_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

if ($data = f_igosja_request_post('data'))
{
    $set_sql = f_igosja_sql_data($data, array(
        'team_stadium_id',
        'team_name'
    ));

    $sql = "UPDATE `team`
            SET $set_sql
            WHERE `team_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    redirect('/admin/team_view.php?num=' . $num_get);
}

$sql = "SELECT `stadium_id`,
               `stadium_name`
        FROM `stadium`
        ORDER BY `stadium_name` ASC, `stadium_id` ASC";
$stadium_sql = f_igosja_mysqli_query($sql);

$stadium_array = $stadium_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'team_list.php', 'text' => 'Команды');
$breadcrumb_array[] = array(
    'url' => 'team_view.php?num=' . $team_array[0]['team_id'],
    'text' => $team_array[0]['team_name']
);
$breadcrumb_array[] = 'Редактирование';

include(__DIR__ . '/view/layout/main.php');