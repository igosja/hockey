<?php

include (__DIR__ . '/include/include.php');

if (!isset($auth_team_id))
{
    redirect('/wrong_page.php');
}

if ($data = f_igosja_request_post('data'))
{
    $confirm_data = array('position' => array());

    if (isset($data['position_id']))
    {
        $position_id = (int) $data['position_id'];

        $sql = "SELECT `position_name`
                FROM `position`
                WHERE `position_id`=$position_id
                LIMIT 1";
        $position_sql = f_igosja_mysqli_query($sql);

        if ($position_sql->num_rows)
        {
            $sql = "SELECT COUNT(`school_id`) AS `count`
                    FROM `school`
                    WHERE `school_team_id`=$auth_team_id";
            $check_sql = f_igosja_mysqli_query($sql);

            $check_array = $check_sql->fetch_all(1);
            $count_check = $check_array[0]['count'];

            if (0 == $count_check)
            {
                $position_array = $position_sql->fetch_all(1);

                $confirm_data['position'] = array(
                    'id' => $position_id,
                    'name' => $position_array[0]['position_name'],
                );
            }
        }
    }

    if (isset($data['ok']))
    {
        foreach($confirm_data as $item)
        {
            $position_id = $item['id'];

            $sql = "INSERT INTO `school`
                    SET `school_day`=10,
                        `school_team_id`=$auth_team_id,
                        `school_season_id`=$igosja_season_id,
                        `school_position_id`=$position_id";
            f_igosja_mysqli_query($sql);
        }

        $_SESSION['message']['class']   = 'success';
        $_SESSION['message']['text']    = 'Изменения успешно сохранены.';

        refresh();
    }
}

$sql = "SELECT `country_id`,
               `country_name`
        FROM `team`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `team_id`=$auth_team_id
        LIMIT 1";
$team_sql = f_igosja_mysqli_query($sql);

$team_array = $team_sql->fetch_all(1);

$sql = "SELECT `position_id`,
               `position_name`
        FROM `position`
        ORDER BY `position_id` ASC";
$position_sql = f_igosja_mysqli_query($sql);

$position_array = $position_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');