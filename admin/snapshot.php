<?php

/**
 * @var $igosja_season_id
 */
include(__DIR__ . '/../include/include.php');

if ($num_get = (int) f_igosja_request_get('num'))
{
    $num_get = 1;
}

if ($season_id = (int) f_igosja_request_get('season_id'))
{
    $season_id = $igosja_season_id;
}

if (1 == $num_get)
{
    $select = '`snapshot_base`';
}
elseif (2 == $num_get)
{
    $select = '`snapshot_base_total`';
}
elseif (3 == $num_get)
{
    $select = '`snapshot_basemedical`';
}
elseif (4 == $num_get)
{
    $select = '`snapshot_basephisical`';
}
elseif (5 == $num_get)
{
    $select = '`snapshot_baseschool`';
}
elseif (6 == $num_get)
{
    $select = '`snapshot_basescout`';
}
elseif (7 == $num_get)
{
    $select = '`snapshot_basetraining`';
}
elseif (8 == $num_get)
{
    $select = '`snapshot_country`';
}
elseif (9 == $num_get)
{
    $select = '`snapshot_manager`';
}
elseif (10 == $num_get)
{
    $select = '`snapshot_manager_vip_percent`';
}
elseif (11 == $num_get)
{
    $select = '`snapshot_manager_with_team`';
}
elseif (12 == $num_get)
{
    $select = '`snapshot_player`';
}
elseif (13 == $num_get)
{
    $select = '`snapshot_player_age`';
}
elseif (14 == $num_get)
{
    $select = '`snapshot_player_c`';
}
elseif (15 == $num_get)
{
    $select = '`snapshot_player_gk`';
}
elseif (16 == $num_get)
{
    $select = '`snapshot_player_in_team`';
}
elseif (17 == $num_get)
{
    $select = '`snapshot_player_ld`';
}
elseif (18 == $num_get)
{
    $select = '`snapshot_player_lw`';
}
elseif (19 == $num_get)
{
    $select = '`snapshot_player_rd`';
}
elseif (20 == $num_get)
{
    $select = '`snapshot_player_rw`';
}
elseif (21 == $num_get)
{
    $select = '`snapshot_player_power`';
}
elseif (22 == $num_get)
{
    $select = '`snapshot_player_special_percent_no`';
}
elseif (23 == $num_get)
{
    $select = '`snapshot_player_special_percent_one`';
}
elseif (24 == $num_get)
{
    $select = '`snapshot_player_special_percent_two`';
}
elseif (25 == $num_get)
{
    $select = '`snapshot_player_special_percent_three`';
}
elseif (26 == $num_get)
{
    $select = '`snapshot_player_special_percent_four`';
}
elseif (27 == $num_get)
{
    $select = '`snapshot_player_special_percent_athletic`';
}
elseif (28 == $num_get)
{
    $select = '`snapshot_player_special_percent_combine`';
}
elseif (29 == $num_get)
{
    $select = '`snapshot_player_special_percent_idol`';
}
elseif (30 == $num_get)
{
    $select = '`snapshot_player_special_percent_leader`';
}
elseif (31 == $num_get)
{
    $select = '`snapshot_player_special_percent_power`';
}
elseif (32 == $num_get)
{
    $select = '`snapshot_player_special_percent_reaction`';
}
elseif (33 == $num_get)
{
    $select = '`snapshot_player_special_percent_shot`';
}
elseif (34 == $num_get)
{
    $select = '`snapshot_player_special_percent_speed`';
}
elseif (35 == $num_get)
{
    $select = '`snapshot_player_special_percent_tackle`';
}
elseif (36 == $num_get)
{
    $select = '`snapshot_player_with_position_percent`';
}
elseif (37 == $num_get)
{
    $select = '`snapshot_team`';
}
elseif (38 == $num_get)
{
    $select = '`snapshot_team_finance`';
}
elseif (39 == $num_get)
{
    $select = '`snapshot_team_to_manager`';
}
elseif (40 == $num_get)
{
    $select = '`snapshot_stadium`';
}

$sql = "SELECT COUNT(`team_id`) AS `count`
        FROM `team`
        WHERE `team_user_id`=0
        AND `team_id`!=0";
$freeteam_sql = f_igosja_mysqli_query($sql);

$freeteam_array = $freeteam_sql->fetch_all(MYSQLI_ASSOC);

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

$sql = "SELECT COUNT(`logo_id`) AS `count`
        FROM `logo`";
$logo_sql = f_igosja_mysqli_query($sql);

$logo_array = $logo_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT COUNT(`complain_id`) AS `count`
        FROM `complain`";
$complain_sql = f_igosja_mysqli_query($sql);

$complain_array = $complain_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT FROM_UNIXTIME(`payment_date`, '%b %Y') AS `date`,
               SUM(`payment_sum`) AS `total`
        FROM `payment`
        WHERE `payment_status`=1
        GROUP BY FROM_UNIXTIME(`payment_date`, '%b-%Y')";
$payment_sql = f_igosja_mysqli_query($sql);

$payment_array = $payment_sql->fetch_all(MYSQLI_ASSOC);

$date_start = strtotime('-11months', strtotime(date('Y-m-01')));
$date_end   = strtotime(date('Y-m-t'));

$date_array = array();

while ($date_start < $date_end)
{
    $date_array[]   = date('M Y', $date_start);
    $date_start     = strtotime('+1month', strtotime(date('Y-m-d', $date_start)));
}

$value_array = array();

foreach ($date_array as $date)
{
    $in_array = false;

    foreach ($payment_array as $item)
    {
        if ($item['date'] == $date)
        {
            $value_array[]  = $item['total'];
            $in_array       = true;
        }
    }

    if (false == $in_array)
    {
        $value_array[] = 0;
    }
}

$payment_categories = '"' . implode('","', $date_array) . '"';
$payment_data       = implode(',', $value_array);

$sql = "SELECT `payment_date`,
               `payment_sum`,
               `user_login`,
               `user_id`
        FROM `payment`
        LEFT JOIN `user`
        ON `payment_user_id`=`user_id`
        WHERE `payment_status`=1
        ORDER BY `payment_id` DESC
        LIMIT 10";
$payment_sql = f_igosja_mysqli_query($sql);

$payment_array = $payment_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT COUNT(`forummessage_id`) AS `count`
        FROM `forummessage`
        WHERE `forummessage_check`=0";
$forummessage_sql = f_igosja_mysqli_query($sql);

$forummessage_array = $forummessage_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT COUNT(`gamecomment_id`) AS `count`
        FROM `gamecomment`
        WHERE `gamecomment_check`=0";
$gamecomment_sql = f_igosja_mysqli_query($sql);

$gamecomment_array = $gamecomment_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT COUNT(`news_id`) AS `count`
        FROM `news`
        WHERE `news_check`=0";
$news_sql = f_igosja_mysqli_query($sql);

$news_array = $news_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT COUNT(`newscomment_id`) AS `count`
        FROM `newscomment`
        WHERE `newscomment_check`=0";
$newscomment_sql = f_igosja_mysqli_query($sql);

$newscomment_array = $newscomment_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT COUNT(`rentcomment_id`) AS `count`
        FROM `rentcomment`
        WHERE `rentcomment_check`=0";
$rentcomment_sql = f_igosja_mysqli_query($sql);

$rentcomment_array = $rentcomment_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT COUNT(`transfercomment_id`) AS `count`
        FROM `transfercomment`
        WHERE `transfercomment_check`=0";
$transfercomment_sql = f_igosja_mysqli_query($sql);

$transfercomment_array = $transfercomment_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT COUNT(`review_id`) AS `count`
        FROM `review`
        WHERE `review_check`=0";
$review_sql = f_igosja_mysqli_query($sql);

$review_array = $review_sql->fetch_all(MYSQLI_ASSOC);

$count_moderation = 0;
$count_moderation = $count_moderation + $forummessage_array[0]['count'];
$count_moderation = $count_moderation + $gamecomment_array[0]['count'];
$count_moderation = $count_moderation + $news_array[0]['count'];
$count_moderation = $count_moderation + $newscomment_array[0]['count'];
$count_moderation = $count_moderation + $rentcomment_array[0]['count'];
$count_moderation = $count_moderation + $transfercomment_array[0]['count'];
$count_moderation = $count_moderation + $review_array[0]['count'];

include(__DIR__ . '/view/layout/main.php');