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
    redirect('/wrong_page.php');
}

if ($data = f_igosja_request_post('data'))
{
    if (!isset($data['friendlystatus_id']))
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Статус выбран неправильно.';
    }

    $friendlystatus_id = (int) $data['friendlystatus_id'];

    $sql = "SELECT COUNT(`friendlystatus_id`) AS `count`
            FROM `friendlystatus`
            WHERE `friendlystatus_id`=$friendlystatus_id";
    $friendlystatus_sql = f_igosja_mysqli_query($sql);

    $friendlystatus_array = $friendlystatus_sql->fetch_all(1);

    if ($friendlystatus_array[0]['count'])
    {
        $sql = "UPDATE `user`
                SET `user_friendlystatus_id`=$friendlystatus_id
                WHERE `user_id`=$auth_user_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $_SESSION['message']['class']   = 'success';
        $_SESSION['message']['text']    = 'Изменения успешно сохранены.';
    }
    else
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Статус выбран неправильно.';
    }

    refresh();
}

$sql = "SELECT `city_name`,
               `country_name`,
               `user_friendlystatus_id`,
               `team_name`
        FROM `team`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        LEFT JOIN `user`
        ON `team_user_id`=`user_id`
        WHERE `team_id`=$auth_team_id
        LIMIT 1";
$team_sql = f_igosja_mysqli_query($sql);

$team_array = $team_sql->fetch_all(1);

$sql = "SELECT `friendlystatus_id`,
               `friendlystatus_name`
        FROM `friendlystatus`
        ORDER BY `friendlystatus_id` ASC";
$friendlystatus_sql = f_igosja_mysqli_query($sql);

$friendlystatus_array = $friendlystatus_sql->fetch_all(1);

include(__DIR__ . '/view/layout/main.php');