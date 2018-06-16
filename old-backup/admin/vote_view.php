<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `vote_id`,
               `vote_text`,
               `vote_votestatus_id`,
               `voteanswer_text`
        FROM `vote`
        LEFT JOIN `voteanswer`
        ON `vote_id`=`voteanswer_vote_id`
        WHERE `vote_id`=$num_get
        ORDER BY `voteanswer_id` ASC";
$vote_sql = f_igosja_mysqli_query($sql);

if (0 == $vote_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$vote_array = $vote_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'vote_list.php', 'text' => 'Опросы');
$breadcrumb_array[] = $vote_array[0]['vote_text'];

include(__DIR__ . '/view/layout/main.php');