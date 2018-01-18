<?php

/**
 * @var $auth_team_id integer
 * @var $auth_user_id integer
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

if (0 == $auth_team_id)
{
    redirect('/team_ask.php');
}

$num_get = $auth_user_id;

include(__DIR__ . '/include/sql/user_view.php');

if ($data = f_igosja_request_get('ok'))
{
    $sql = "UPDATE `team`
            SET `team_user_id`=0
            WHERE `team_id`=$auth_team_id
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    $log = array(
        'history_historytext_id' => HISTORYTEXT_USER_MANAGER_TEAM_OUT,
        'history_team_id' => $auth_team_id,
        'history_user_id' => $auth_user_id,
    );
    f_igosja_history($log);

    $_SESSION['message']['class']   = 'success';
    $_SESSION['message']['text']    = 'Изменения сохранены.';

    redirect('/team_ask.php');
}

$seo_title          = $user_array[0]['user_login'] . '. Отказ от команды';
$seo_description    = $user_array[0]['user_login'] . '. Отказ от команды на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $user_array[0]['user_login'] . ' oтказ от команды';

include(__DIR__ . '/view/layout/main.php');