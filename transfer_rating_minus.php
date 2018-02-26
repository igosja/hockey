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

$sql = "SELECT COUNT(`country_id`) AS `count`
        FROM `country`
        WHERE `country_president_id`=$auth_user_id
        OR `country_vice_id`=$auth_user_id";
$check_sql = f_igosja_mysqli_query($sql);

$check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

if (0 == $check_array[0]['count'])
{
    $rating = 1;
}
else
{
    $rating = 10;
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
        SET `transfervote_rating`=-$rating,
            `transfervote_transfer_id`=$num_get,
            `transfervote_user_id`=$auth_user_id";
f_igosja_mysqli_query($sql);

if ($data = f_igosja_request_post('data'))
{
    if (isset($auth_user_id) && isset($data['text']))
    {
        $text = htmlspecialchars($data['text']);
        $text = trim($text);

        if (!empty($text))
        {
            $sql = "INSERT INTO `transfercomment`
                    SET `transfercomment_date`=UNIX_TIMESTAMP(),
                        `transfercomment_transfer_id`=$num_get,
                        `transfercomment_text`=?,
                        `transfercomment_user_id`=$auth_user_id";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $text);
            $prepare->execute();
            $prepare->close();
        }
    }
}

$_SESSION['message']['class']   = 'success';
$_SESSION['message']['text']    = 'Ваш голос успешно сохранён.';

if (1 == $rating)
{
    redirect('/transfer_view.php?num=' . $num_get);
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

    redirect('/rent_view.php?num=' . $rent_array[0]['rent_id']);
}

redirect('/transfer_view.php?num=' . $num_get);