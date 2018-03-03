<?php

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

$date_start = strtotime('-2months');
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

include(__DIR__ . '/view/layout/main.php');