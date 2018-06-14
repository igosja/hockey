<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `forumchapter_id`,
               `forumchapter_name`
        FROM `forumchapter`
        WHERE `forumchapter_id`=$num_get
        LIMIT 1";
$forumchapter_sql = f_igosja_mysqli_query($sql);

if (0 == $forumchapter_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$forumchapter_array = $forumchapter_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'forumchapter_list.php', 'text' => 'Разделы');
$breadcrumb_array[] = $forumchapter_array[0]['forumchapter_name'];

include(__DIR__ . '/view/layout/main.php');