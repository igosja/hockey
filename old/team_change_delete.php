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

if ($num_get = (int) f_igosja_request_get('num'))
{
    $sql = "DELETE FROM `teamask`
            WHERE `teamask_id`=$num_get
            AND `teamask_user_id`=$auth_user_id";
    f_igosja_mysqli_query($sql);

    f_igosja_session_front_flash_set('success', 'Заявка успешно удалена.');
}

redirect('/team_change.php');