<?php

include (__DIR__ . '/include/include.php');

$sql = "UPDATE `vote`
        SET `vote_votestatus_id`='" . VOTESTATUS_CLOSE . "'
        WHERE `vote_votestatus_id`='" . VOTESTATUS_OPEN . "'
        AND `vote_date`<UNIX_TIMESTAMP()-'604800'";
f_igosja_mysqli_query($sql);

$sql = "SELECT `count_answer`,
               `user_id`,
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
        LEFT JOIN
        (
            SELECT COUNT(`voteuser_user_id`) AS `count_answer`,
                   `voteuser_answer_id`
            FROM `voteuser`
            GROUP BY `voteuser_answer_id`
        ) AS `t1`
        ON `voteuser_answer_id`=`voteanswer_id`
        WHERE `vote_country_id`='0'
        AND `votestatus_id`>'" . VOTESTATUS_NEW . "'
        ORDER BY `votestatus_id` ASC, `vote_id` DESC, `count_answer` DESC, `voteanswer_id` ASC";
$vote_sql = f_igosja_mysqli_query($sql);

$vote_array = $vote_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');