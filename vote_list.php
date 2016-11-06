<?php

include (__DIR__ . '/include/include.php');

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
        ORDER BY `votestatus_id` DESC, `vote_id` DESC, `voteanswer_id` ASC";
$vote_sql = igosja_db_query($sql);

$vote_array = $vote_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');