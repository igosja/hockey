<?php

include (__DIR__ . '/../include/include.php');

$num_get = (int) f_igosja_get('num');

if ($data = f_igosja_post('data'))
{
    $set_sql = f_igosja_sql_data($data);

    $sql = "UPDATE `vote`
            SET $set_sql
            WHERE `vote_id`='$num_get'
            LIMIT 1";
    igosja_db_query($sql);

    redirect('/admin/vote_view.php?num=' . $num_get);
}

$sql = "SELECT `vote_id`,
               `vote_name`
        FROM `vote`
        WHERE `vote_id`='$num_get'
        LIMIT 1";
$vote_sql = igosja_db_query($sql);

if (0 == $vote_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$vote_array = $vote_sql->fetch_all(1);

$breadcrumb_array[] = array('url' => 'vote_list.php', 'text' => 'Типы турниров');
$breadcrumb_array[] = array(
    'url' => 'vote_view.php?num=' . $vote_array[0]['vote_id'],
    'text' => $vote_array[0]['vote_name']
);
$breadcrumb_array[] = 'Редактирование';

include (__DIR__ . '/view/layout/main.php');