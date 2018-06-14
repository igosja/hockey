<?php

include(__DIR__ . '/../../include/include.php');

$sql = "SELECT COUNT(`team_id`) AS `count`
        FROM `team`
        WHERE `team_user_id`=0
        AND `team_id`!=0";
$freeteam_sql = f_igosja_mysqli_query($sql);

$freeteam_array = $freeteam_sql->fetch_all(MYSQLI_ASSOC);

$freeteam = $freeteam_array[0]['count'];

$sql = "SELECT COUNT(`teamask_id`) AS `count`
        FROM `teamask`
        LEFT JOIN
        (
            SELECT COUNT(`history_id`) AS `count_history`,
                   `history_user_id`
            FROM `history`
            WHERE `history_historytext_id`=" . HISTORYTEXT_USER_MANAGER_TEAM_IN . "
            AND `history_user_id` IN
            (
                SELECT `teamask_user_id`
                FROM `teamask`
            )
            GROUP BY `history_user_id`
        ) AS `t1`
        ON `teamask_user_id`=`history_user_id`
        WHERE `teamask_date`<UNIX_TIMESTAMP()-CEIL(IFNULL(`count_history`, 0)/5)-IFNULL(`count_history`, 0)*3600";
$teamask_sql = f_igosja_mysqli_query($sql);

$teamask_array = $teamask_sql->fetch_all(MYSQLI_ASSOC);

$teamask = $teamask_array[0]['count'];

$sql = "SELECT COUNT(`message_id`) AS `count`
        FROM `message`
        WHERE `message_support_to`=1
        AND `message_read`=0";
$support_sql = f_igosja_mysqli_query($sql);

$support_array = $support_sql->fetch_all(MYSQLI_ASSOC);

$support = $support_array[0]['count'];

$sql = "SELECT COUNT(`vote_id`) AS `count`
        FROM `vote`
        WHERE `vote_votestatus_id`=" . VOTESTATUS_NEW;
$vote_sql = f_igosja_mysqli_query($sql);

$vote_array = $vote_sql->fetch_all(MYSQLI_ASSOC);

$vote = $vote_array[0]['count'];

$sql = "SELECT COUNT(`logo_id`) AS `count`
        FROM `logo`";
$logo_sql = f_igosja_mysqli_query($sql);

$logo_array = $logo_sql->fetch_all(MYSQLI_ASSOC);

$logo = $logo_array[0]['count'];

$sql = "SELECT COUNT(`complain_id`) AS `count`
        FROM `complain`";
$complain_sql = f_igosja_mysqli_query($sql);

$complain_array = $complain_sql->fetch_all(MYSQLI_ASSOC);

$complain = $complain_array[0]['count'];

$bell = $teamask + $support + $vote + $logo + $complain;

if (0 == $teamask)
{
    $teamask = '';
}

if (0 == $support)
{
    $support = '';
}

if (0 == $vote)
{
    $vote = '';
}

if (0 == $logo)
{
    $logo = '';
}

if (0 == $complain)
{
    $complain = '';
}

if (0 == $bell)
{
    $bell = '';
}

$return = array('bell' => $bell, 'teamask' => $teamask, 'support' => $support, 'vote' => $vote, 'logo' => $logo, 'freeteam' => $freeteam, 'complain' => $complain);

print json_encode($return);
exit;