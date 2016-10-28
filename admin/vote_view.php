<?php

include (__DIR__ . '/../include/include.php');

$num_get = (int) f_igosja_get('num');

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
$breadcrumb_array[] = $vote_array[0]['vote_name'];

include (__DIR__ . '/view/layout/main.php');