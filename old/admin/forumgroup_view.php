<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `forumgroup_id`,
               `forumgroup_name`,
               `forumchapter_id`,
               `forumchapter_name`
        FROM `forumgroup`
        LEFT JOIN `forumchapter`
        ON `forumgroup_forumchapter_id`=`forumchapter_id`
        WHERE `forumgroup_id`=$num_get
        LIMIT 1";
$forumgroup_sql = f_igosja_mysqli_query($sql);

if (0 == $forumgroup_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$forumgroup_array = $forumgroup_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'forumgroup_list.php', 'text' => 'Группы');
$breadcrumb_array[] = $forumgroup_array[0]['forumgroup_name'];

include(__DIR__ . '/view/layout/main.php');