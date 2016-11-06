<?php

include (__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_get('num'))
{
    redirect('/wrong_page');
}

$sql = "SELECT `user_id`,
               `user_login`,
               `vote_id`,
               `vote_text`,
               `voteanswer_text`,
               `votestatus_name`
        FROM `vote`
        LEFT JOIN `votestatus`
        ON `vote_votestatus_id`=`votestatus_id`
        LEFT JOIN `user`
        ON `vote_user_id`=`user_id`
        LEFT JOIN `voteanswer`
        ON `vote_id`=`voteanswer_vote_id`
        WHERE `vote_country_id`='0'
        AND `votestatus_id`>'" . VOTESTATUS_NEW . "'
        AND `vote_id`='$num_get'
        ORDER BY `voteanswer_id` ASC";
$vote_sql = igosja_db_query($sql);

if (0 == $vote_sql->num_rows)
{
    redirect('/wrong_page');
}

$vote_array = $vote_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');