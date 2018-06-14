<?php

/**
 * @var $auth_country_id integer
 * @var $auth_national_id integer
 * @var $auth_nationalvice_id integer
 * @var $auth_user_id integer
 * @var $country_array array
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

if (!$num_get = (int) f_igosja_request_get('num'))
{
    if (!isset($auth_national_id))
    {
        redirect('/wrong_page.php');
    }

    if (0 == $auth_national_id && 0 == $auth_nationalvice_id)
    {
        redirect('/wrong_page.php');
    }

    if (!$num_get = $auth_national_id)
    {
        $num_get = $auth_nationalvice_id;
    }
}

include(__DIR__ . '/include/sql/national_view_left.php');
include(__DIR__ . '/include/sql/national_view_right.php');

if (!in_array($auth_user_id, array($national_array[0]['user_id'], $national_array[0]['vice_user_id'])))
{
    redirect('/wrong_page.php');
}

if (0 == $national_array[0]['vice_user_id'])
{
    redirect('/wrong_page.php');
}

if (f_igosja_request_get('ok'))
{
    if ($auth_user_id == $national_array[0]['user_id'])
    {
        $log = array(
            'history_historytext_id' => HISTORYTEXT_USER_MANAGER_NATIONAL_OUT,
            'history_national_id' => $num_get,
            'history_user_id' => $national_array[0]['user_id'],
        );
        f_igosja_history($log);

        $log = array(
            'history_historytext_id' => HISTORYTEXT_USER_VICE_NATIONAL_OUT,
            'history_national_id' => $num_get,
            'history_user_id' => $national_array[0]['vice_user_id'],
        );
        f_igosja_history($log);

        $log = array(
            'history_historytext_id' => HISTORYTEXT_USER_MANAGER_NATIONAL_IN,
            'history_national_id' => $num_get,
            'history_user_id' => $national_array[0]['vice_user_id'],
        );
        f_igosja_history($log);

        $sql = "UPDATE `national`
                SET `national_user_id`=`national_vice_id`,
                    `national_vice_id`=0
                WHERE `national_id`=$num_get
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `team`
                LEFT JOIN `stadium`
                ON `team_stadium_id`=`stadium_id`
                LEFT JOIN `city`
                ON `stadium_city_id`=`city_id`
                SET `team_vote_national`=" . VOTERATING_NEUTRAL . "
                WHERE `city_country_id`=$num_get";
        f_igosja_mysqli_query($sql);
    }
    elseif ($auth_user_id == $national_array[0]['vice_user_id'])
    {
        $log = array(
            'history_historytext_id' => HISTORYTEXT_USER_VICE_NATIONAL_OUT,
            'history_national_id' => $num_get,
            'history_user_id' => $national_array[0]['vice_user_id'],
        );
        f_igosja_history($log);

        $sql = "UPDATE `national`
                SET `national_vice_id`=0
                WHERE `national_id`=$num_get
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }

    f_igosja_session_front_flash_set('success', 'Вы успешно отказались от должности.');

    redirect('/national_view.php?num=' . $num_get);
}

$seo_title          = $national_array[0]['country_name'] . '. Отказ от должности';
$seo_description    = $national_array[0]['country_name'] . '. Отказ от должности на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $national_array[0]['country_name'] . ' отказ от должности';

include(__DIR__ . '/view/layout/main.php');