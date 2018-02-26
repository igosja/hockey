<?php

/**
 * @var $auth_user_id integer
 * @var $auth_userrole_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

if (USERROLE_USER == $auth_userrole_id)
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `review_country_id`,
               `review_division_id`,
               `review_season_id`,
               `review_user_id`
        FROM `review`
        WHERE `review_id`=$num_get
        LIMIT 1";
$review_sql = f_igosja_mysqli_query($sql);

if (0 == $review_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$review_array = $review_sql->fetch_all(MYSQLI_ASSOC);

if (f_igosja_request_get('penalty'))
{
    $user_id = $review_array[0]['review_user_id'];
    $penalty = 100000;

    $sql = "SELECT `user_finance`
            FROM `user`
            WHERE `user_id`=$user_id
            LIMIT 1";
    $user_sql = f_igosja_mysqli_query($sql);

    $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

    $finance = array(
        'finance_financetext_id' => FINANCETEXT_OUTCOME_REVIEW,
        'finance_user_id' => $user_id,
        'finance_value' => -$penalty,
        'finance_value_after' => $user_array[0]['user_finance'] - $penalty,
        'finance_value_before' => $user_array[0]['user_finance'],
    );

    f_igosja_finance($finance);

    $sql = "UPDATE `user`
            SET `user_finance`=`user_finance`-$penalty
            WHERE `user_id`=$user_id
            LIMIT 1";
    f_igosja_mysqli_query($sql);
}

$sql = "DELETE FROM `review`
        WHERE `review_id`=$num_get
        LIMIT 1";
f_igosja_mysqli_query($sql);

f_igosja_session_front_flash_set('success', 'Обзор упешно удалён.');

redirect('/championship.php?country_id=' . $review_array[0]['review_country_id'] . '&division_id=' . $review_array[0]['review_division_id'] . '&season_id=' . $review_array[0]['review_season_id']);