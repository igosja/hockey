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

$sql = "SELECT COUNT(`rent_id`) AS `check`
        FROM `rent`
        WHERE `rent_ready`=1
        AND `rent_id`=$num_get
        AND `rent_checked`=0
        LIMIT 1";
$rent_sql = f_igosja_mysqli_query($sql);

$rent_array = $rent_sql->fetch_all(MYSQLI_ASSOC);

if (0 == $rent_array[0]['check'])
{
    redirect('/wrong_page.php');
}

$sql = "SELECT COUNT(`rentvote_rent_id`) AS `check`
        FROM `rentvote`
        WHERE `rentvote_rent_id`=$num_get
        AND `rentvote_user_id`=$auth_user_id";
$rentvote_sql = f_igosja_mysqli_query($sql);

$rentvote_array = $rentvote_sql->fetch_all(MYSQLI_ASSOC);

if (0 != $rentvote_array[0]['check'])
{
    redirect('/wrong_page.php');
}

$sql = "INSERT INTO `rentvote`
        SET `rentvote_rating`=-1,
            `rentvote_rent_id`=$num_get,
            `rentvote_user_id`=$auth_user_id";
f_igosja_mysqli_query($sql);

$sql = "SELECT COUNT(`country_id`) AS `count`
        FROM `country`
        WHERE `country_president_id`=$auth_user_id
        OR `country_vice_id`=$auth_user_id";
$check_sql = f_igosja_mysqli_query($sql);

$check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

if (0 == $check_array[0]['count'])
{
    redirect('/rent_view.php?num=' . $num_get);
}

$sql = "SELECT `transfer_id`
        FROM `transfer`
        LEFT JOIN
        (
            SELECT `transfervote_transfer_id`
            FROM `transfervote`
            WHERE `transfervote_transfer_id` IN
            (
                SELECT `transfer_id`
                FROM `transfer`
                WHERE `transfer_ready`=1
                AND `transfer_checked`=0
            )
            AND `transfervote_user_id`=$auth_user_id
        ) AS `t1`
        ON `transfer_id`=`transfervote_transfer_id`
        WHERE `transfer_ready`=1
        AND `transfer_checked`=0
        AND `transfervote_transfer_id` IS NULL
        ORDER BY `transfer_id` ASC
        LIMIT 1";
$transfer_sql = f_igosja_mysqli_query($sql);

if (0 != $transfer_sql->num_rows)
{
    $transfer_array = $transfer_sql->fetch_all(MYSQLI_ASSOC);

    redirect('/transfer_view.php?num=' . $transfer_array[0]['transfer_id']);
}

$sql = "SELECT `rent_id`
        FROM `rent`
        LEFT JOIN
        (
            SELECT `rentvote_rent_id`
            FROM `rentvote`
            WHERE `rentvote_rent_id` IN
            (
                SELECT `rent_id`
                FROM `rent`
                WHERE `rent_ready`=1
                AND `rent_checked`=0
            )
            AND `rentvote_user_id`=$auth_user_id
        ) AS `t1`
        ON `rent_id`=`rentvote_rent_id`
        WHERE `rent_ready`=1
        AND `rent_checked`=0
        AND `rentvote_rent_id` IS NULL
        ORDER BY `rent_id` ASC
        LIMIT 1";
$rent_sql = f_igosja_mysqli_query($sql);

if (0 != $rent_sql->num_rows)
{
    $rent_array = $rent_sql->fetch_all(MYSQLI_ASSOC);

    redirect('/rent_view.php?num=' . $transfer_array[0]['transfer_id']);
}

redirect('/rent_view.php?num=' . $num_get);