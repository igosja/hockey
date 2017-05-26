<?php

include(__DIR__ . '/include/include.php');

$result = '';

if ($email = f_igosja_request_post('signup_email'))
{
    $email  = trim($email);
    $result = f_igosja_check_user_by_email($email);
}
elseif ($login = f_igosja_request_post('signup_login'))
{
    $login  = trim($login);
    $result = f_igosja_check_user_by_login($login);
}
elseif ($password = f_igosja_request_post('password_old'))
{
    $result = f_igosja_check_user_password($password);
}
elseif ($phisical_id = (int) f_igosja_request_get('phisical_id'))
{
    $player_id  = (int) f_igosja_request_get('player_id');
    $shedule_id = (int) f_igosja_request_get('shedule_id');

    $sql = "DELETE FROM `phisicalchange`
            WHERE `phisicalchange_player_id`=$player_id
            AND `phisicalchange_shedule_id`>$shedule_id";
    f_igosja_mysqli_query($sql);

    $sql = "SELECT COUNT(`phisicalchange_id`) AS `count`
            FROM `phisicalchange`
            WHERE `phisicalchange_player_id`=$player_id
            AND `phisicalchange_shedule_id`=$shedule_id";
    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(1);
    $count_check = $check_array[0]['count'];

    if ($count_check)
    {
        $sql = "DELETE FROM `phisicalchange`
                WHERE `phisicalchange_player_id`=$player_id
                AND `phisicalchange_shedule_id`=$shedule_id";
        f_igosja_mysqli_query($sql);
    }
    else
    {
        $sql = "INSERT INTO `phisicalchange`
                SET `phisicalchange_player_id`=$player_id,
                    `phisicalchange_shedule_id`=$shedule_id,
                    `phisicalchange_team_id`=$auth_team_id";
        f_igosja_mysqli_query($sql);
    }

    $sql = "SELECT COUNT(`phisicalchange_id`) AS `count`
            FROM `phisicalchange`
            WHERE `phisicalchange_player_id`=$player_id
            AND `phisicalchange_shedule_id`>
            (
                SELECT `shedule_id`
                FROM `shedule`
                WHERE `shedule_date`>UNIX_TIMESTAMP()
                AND `shedule_tournamenttype_id`!='" . TOURNAMENTTYPE_CONFERENCE . "'
                ORDER BY `shedule_id` ASC
                LIMIT 1
            )";
    $prev_sql = f_igosja_mysqli_query($sql);

    $prev_array = $prev_sql->fetch_all(1);
    $count_prev = $prev_array[0]['count'];

    $sql = "SELECT `phisical_id`,
                   `phisical_opposite`,
                   `phisical_value`
            FROM `phisical`
            ORDER BY `phisical_id` ASC";
    $phisical_sql = f_igosja_mysqli_query($sql);

    $phisical_sql = $phisical_sql->fetch_all(1);

    $phisical_array = array();

    foreach ($phisical_sql as $item)
    {
        $phisical_array[$item['phisical_id']] = array(
            'opposite'  => (int) $item['phisical_opposite'],
            'value'     => (int) $item['phisical_value'],
        );
    }

    $sql = "SELECT `shedule_id`
            FROM `shedule`
            WHERE `shedule_id`>='$shedule_id'
            AND `shedule_tournamenttype_id`!='" . TOURNAMENTTYPE_CONFERENCE . "'
            ORDER BY `shedule_id` ASC";
    $shedule_sql = f_igosja_mysqli_query($sql);

    $count_shedule = $shedule_sql->num_rows;
    $shedule_array = $shedule_sql->fetch_all(1);

    $result = array();

    for ($i=0; $i<$count_shedule; $i++)
    {
        if (0 == $i)
        {
            if ($count_check && 0 == $count_prev)
            {
                $class = '';
            }
            elseif ($count_check && $count_prev)
            {
                $class = 'phisical-yellow';
            }
            else
            {
                $class = 'phisical-bordered';
            }

            $phisical_id    = $phisical_array[$phisical_id]['opposite'];
        }
        else
        {
            if ($count_check && 0 == $count_prev)
            {
                $class = '';
            }
            else
            {
                $class = 'phisical-yellow';
            }

            $phisical_id++;

            if (20 < $phisical_id)
            {
                $phisical_id = $phisical_id - 20;
            }
        }

        $result[] = array(
            'remove_class_1'    => 'phisical-bordered',
            'remove_class_2'    => 'phisical-yellow',
            'class'             => $class,
            'id'                => $player_id . '-' . $shedule_array[$i]['shedule_id'],
            'phisical_id'       => $phisical_id,
            'phisical_value'    => $phisical_array[$phisical_id]['value'],
        );
    }
}

print json_encode($result);
exit;