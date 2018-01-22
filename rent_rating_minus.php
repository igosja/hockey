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

redirect('/rent_view.php?num=' . $num_get);