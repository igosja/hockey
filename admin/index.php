<?php

/*
SELECT FROM_UNIXTIME({date_field}, '{date_format}'), COUNT(*) AS '{value}'
FROM lm_buyer_balance_transfer
WHERE transfer_type IN (101, 127)
AND FROM_UNIXTIME({date_field}, '{date_format}') >= '{from}'
AND FROM_UNIXTIME({date_field}, '{date_format}') <= '{to}'
GROUP BY FROM_UNIXTIME({date_field}, '{date_format}')
ORDER BY {date_field} ASC
*/

include(__DIR__ . '/../include/include.php');

$sql = "SELECT COUNT(`team_id`) AS `count`
        FROM `team`
        WHERE `team_user_id`=0
        AND `team_id`!=0";
$freeteam_sql = f_igosja_mysqli_query($sql);

$freeteam_array = $freeteam_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT COUNT(`teamask_id`) AS `count`
        FROM `teamask`";
$teamask_sql = f_igosja_mysqli_query($sql);

$teamask_array = $teamask_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT COUNT(`message_id`) AS `count`
        FROM `message`
        WHERE `message_support_to`=1
        AND `message_read`=0";
$support_sql = f_igosja_mysqli_query($sql);

$support_array = $support_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT COUNT(`vote_id`) AS `count`
        FROM `vote`
        WHERE `vote_votestatus_id`=" . VOTESTATUS_NEW;
$vote_sql = f_igosja_mysqli_query($sql);

$vote_array = $vote_sql->fetch_all(MYSQLI_ASSOC);

include(__DIR__ . '/view/layout/main.php');