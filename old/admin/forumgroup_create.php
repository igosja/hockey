<?php

include(__DIR__ . '/../include/include.php');

if ($data = f_igosja_request_post('data'))
{
    $set_sql = f_igosja_sql_data($data, array(
        'forumgroup_forumchapter_id',
        'forumgroup_name'
    ));

    $sql = "INSERT INTO `forumgroup`
            SET $set_sql";
    f_igosja_mysqli_query($sql);

    redirect('/admin/forumgroup_view.php?num=' . $mysqli->insert_id);
}

$sql = "SELECT `forumchapter_id`,
               `forumchapter_name`
        FROM `forumchapter`
        ORDER BY `forumchapter_name` ASC, `forumchapter_id` ASC";
$forumchapter_sql = f_igosja_mysqli_query($sql);

$forumchapter_array = $forumchapter_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'forumgroup_list.php', 'text' => 'Группы');
$breadcrumb_array[] = 'Создание';

$tpl = 'forumgroup_update';

include(__DIR__ . '/view/layout/main.php');