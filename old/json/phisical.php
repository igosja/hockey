<?php

/**
 * @var $auth_team_id integer
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/../include/include.php');

$result = '';

if ($phisical_id = (int) f_igosja_request_get('phisical_id'))
{
    $change_status = true;

    $result = array('available' => 0, 'list' => array());

    $sql = "SELECT `basephisical_change_count`,
                   `basephisical_level`,
                   `basephisical_tire_bonus`
            FROM `basephisical`
            LEFT JOIN `team`
            ON `basephisical_id`=`team_basephisical_id`
            WHERE `team_id`=$auth_team_id
            LIMIT 1";
    $basephisical_sql = f_igosja_mysqli_query($sql);

    $basephisical_array = $basephisical_sql->fetch_all(MYSQLI_ASSOC);

    $player_id      = (int) f_igosja_request_get('player_id');
    $schedule_id    = (int) f_igosja_request_get('schedule_id');

    $sql = "SELECT COUNT(`player_id`) AS `check`
            FROM `player`
            WHERE `player_id`=$player_id
            AND `player_team_id`=$auth_team_id
            AND `player_rent_team_id`=0";
    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

    if (0 != $check_array[0]['check'])
    {
        $sql = "DELETE FROM `phisicalchange`
                WHERE `phisicalchange_player_id`=$player_id
                AND `phisicalchange_schedule_id`>$schedule_id
                AND `phisicalchange_season_id`=$igosja_season_id";
        f_igosja_mysqli_query($sql);

        $sql = "SELECT COUNT(`phisicalchange_id`) AS `count`
                FROM `phisicalchange`
                WHERE `phisicalchange_player_id`=$player_id
                AND `phisicalchange_season_id`=$igosja_season_id
                AND `phisicalchange_schedule_id`=$schedule_id";
        $check_sql = f_igosja_mysqli_query($sql);

        $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);
        $count_check = $check_array[0]['count'];

        if ($count_check)
        {
            $sql = "DELETE FROM `phisicalchange`
                    WHERE `phisicalchange_player_id`=$player_id
                    AND `phisicalchange_season_id`=$igosja_season_id
                    AND `phisicalchange_schedule_id`=$schedule_id";
            f_igosja_mysqli_query($sql);
        }
        else
        {
            $sql = "SELECT COUNT(`phisicalchange_id`) AS `count`
                    FROM `phisicalchange`
                    WHERE `phisicalchange_team_id`=$auth_team_id
                    AND `phisicalchange_season_id`=$igosja_season_id";
            $phisical_used_sql = f_igosja_mysqli_query($sql);

            $phisical_used_array = $phisical_used_sql->fetch_all(MYSQLI_ASSOC);

            $phisical_available = $basephisical_array[0]['basephisical_change_count'] - $phisical_used_array[0]['count'];

            if ($phisical_available > 0)
            {
                $sql = "INSERT INTO `phisicalchange`
                        SET `phisicalchange_player_id`=$player_id,
                            `phisicalchange_season_id`=$igosja_season_id,
                            `phisicalchange_schedule_id`=$schedule_id,
                            `phisicalchange_team_id`=$auth_team_id";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $change_status = false;
            }
        }

        if ($change_status)
        {
            $sql = "SELECT COUNT(`phisicalchange_id`) AS `count`
                    FROM `phisicalchange`
                    WHERE `phisicalchange_player_id`=$player_id
                    AND `phisicalchange_schedule_id`>
                    (
                        SELECT `schedule_id`
                        FROM `schedule`
                        WHERE `schedule_date`>UNIX_TIMESTAMP()
                        AND `schedule_tournamenttype_id`!=" . TOURNAMENTTYPE_CONFERENCE . "
                        ORDER BY `schedule_id` ASC
                        LIMIT 1
                    )";
            $prev_sql = f_igosja_mysqli_query($sql);

            $prev_array = $prev_sql->fetch_all(MYSQLI_ASSOC);
            $count_prev = $prev_array[0]['count'];

            $sql = "SELECT `phisical_id`,
                           `phisical_opposite`,
                           `phisical_name`
                    FROM `phisical`
                    ORDER BY `phisical_id` ASC";
            $phisical_sql = f_igosja_mysqli_query($sql);

            $phisical_sql = $phisical_sql->fetch_all(MYSQLI_ASSOC);

            $phisical_array = array();

            foreach ($phisical_sql as $item)
            {
                $phisical_array[$item['phisical_id']] = array(
                    'opposite'  => (int) $item['phisical_opposite'],
                    'value'     => (int) $item['phisical_name'],
                );
            }

            $sql = "SELECT `schedule_id`
                    FROM `schedule`
                    WHERE `schedule_id`>=$schedule_id
                    AND `schedule_tournamenttype_id`!=" . TOURNAMENTTYPE_CONFERENCE . "
                    ORDER BY `schedule_id` ASC";
            $schedule_sql = f_igosja_mysqli_query($sql);

            $count_schedule = $schedule_sql->num_rows;
            $schedule_array = $schedule_sql->fetch_all(MYSQLI_ASSOC);

            for ($i=0; $i<$count_schedule; $i++)
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

                $result['list'][] = array(
                    'remove_class_1'    => 'phisical-bordered',
                    'remove_class_2'    => 'phisical-yellow',
                    'class'             => $class,
                    'id'                => $player_id . '-' . $schedule_array[$i]['schedule_id'],
                    'phisical_id'       => $phisical_id,
                    'phisical_value'    => $phisical_array[$phisical_id]['value'],
                );
            }
        }
    }

    $sql = "SELECT COUNT(`phisicalchange_id`) AS `count`
            FROM `phisicalchange`
            WHERE `phisicalchange_team_id`=$auth_team_id
            AND `phisicalchange_season_id`=$igosja_season_id";
    $phisical_used_sql = f_igosja_mysqli_query($sql);

    $phisical_used_array = $phisical_used_sql->fetch_all(MYSQLI_ASSOC);

    $phisical_available = $basephisical_array[0]['basephisical_change_count'] - $phisical_used_array[0]['count'];

    $result['available'] = $phisical_available;
}

print json_encode($result);
exit;