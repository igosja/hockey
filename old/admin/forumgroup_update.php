<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `forumgroup_forumchapter_id`,
               `forumgroup_id`,
               `forumgroup_name`
        FROM `forumgroup`
        WHERE `forumgroup_id`=$num_get
        LIMIT 1";
$forumgroup_sql = f_igosja_mysqli_query($sql);

if (0 == $forumgroup_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$forumgroup_array = $forumgroup_sql->fetch_all(MYSQLI_ASSOC);

if ($data = f_igosja_request_post('data'))
{
    $set_sql = f_igosja_sql_data($data, array(
        'forumgroup_forumchapter_id',
        'forumgroup_name'
    ));

    $sql = "UPDATE `forumgroup`
            SET $set_sql
            WHERE `forumgroup_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    redirect('/admin/forumgroup_view.php?num=' . $num_get);
}

$sql = "SELECT `forumchapter_id`,
               `forumchapter_name`
        FROM `forumchapter`
        ORDER BY `forumchapter_name` ASC, `forumchapter_id` ASC";
$forumchapter_sql = f_igosja_mysqli_query($sql);

$forumchapter_array = $forumchapter_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'forumgroup_list.php', 'text' => 'Группы');
$breadcrumb_array[] = array(
    'url' => 'forumgroup_view.php?num=' . $forumgroup_array[0]['forumgroup_id'],
    'text' => $forumgroup_array[0]['forumgroup_name']
);
$breadcrumb_array[] = 'Редактирование';

include(__DIR__ . '/view/layout/main.php');