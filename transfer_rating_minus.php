<?php

/**
 * @var $auth_user_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

if (!isset($auth_team_id))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT COUNT(`transfer_id`) AS `check`
        FROM `transfer`
        WHERE `transfer_ready`=1
        AND `transfer_id`=$num_get
        AND `transfer_checked`=0
        LIMIT 1";
$transfer_sql = f_igosja_mysqli_query($sql);

$transfer_array = $transfer_sql->fetch_all(MYSQLI_ASSOC);

if (0 == $transfer_array[0]['check'])
{
    redirect('/wrong_page.php');
}

$sql = "SELECT COUNT(`transfervote_transfer_id`) AS `check`
        FROM `transfervote`
        WHERE `transfervote_transfer_id`=$num_get
        AND `transfervote_user_id`=$auth_user_id";
$transfervote_sql = f_igosja_mysqli_query($sql);

$transfervote_array = $transfervote_sql->fetch_all(MYSQLI_ASSOC);

if (0 != $transfervote_array[0]['check'])
{
    redirect('/wrong_page.php');
}

$sql = "INSERT INTO `transfervote`
        SET `transfervote_rating`=-1,
            `transfervote_transfer_id`=$num_get,
            `transfervote_user_id`=$auth_user_id";
f_igosja_mysqli_query($sql);

redirect('/transfer_view.php?num=' . $num_get);