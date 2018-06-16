<?php

/**
 * Рахуємо силу команд vs + v (16, 21, 27)
 */
function f_igosja_generator_team_vs()
{
    $sql = "SELECT `team_id`
            FROM `team`
            WHERE `team_id`!=0
            ORDER BY `team_id` ASC";
    $team_sql = f_igosja_mysqli_query($sql);

    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($team_array as $item)
    {
        $team_id = $item['team_id'];

        $sql = "SELECT SUM(`player_power_nominal`) AS `power`,
                       SUM(`player_power_nominal_s`) AS `power_s`
                FROM
                (
                    SELECT `player_power_nominal`,
                           `player_power_nominal_s`
                    FROM `player`
                    LEFT JOIN `playerposition`
                    ON `player_id`=`playerposition_player_id`
                    WHERE `player_team_id`=$team_id
                    AND `playerposition_position_id`!=" . POSITION_GK . "
                    ORDER BY `player_power_nominal` DESC, `player_id` ASC
                    LIMIT 15
                ) AS `t1`";
        $power_sql = f_igosja_mysqli_query($sql);

        $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

        $power      = $power_array[0]['power'];
        $power_s    = $power_array[0]['power_s'];

        $sql = "SELECT SUM(`player_power_nominal`) AS `power`,
                       SUM(`player_power_nominal_s`) AS `power_s`
                FROM
                (
                    SELECT `player_power_nominal`,
                           `player_power_nominal_s`
                    FROM `player`
                    LEFT JOIN `playerposition`
                    ON `player_id`=`playerposition_player_id`
                    WHERE `player_team_id`=$team_id
                    AND `playerposition_position_id`=" . POSITION_GK . "
                    ORDER BY `player_power_nominal` DESC, `player_id` ASC
                    LIMIT 1
                ) AS `t1`";
        $power_sql = f_igosja_mysqli_query($sql);

        $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

        $power_c_16 = $power + $power_array[0]['power'];
        $power_s_16 = $power_s + $power_array[0]['power_s'];

        $sql = "SELECT SUM(`player_power_nominal`) AS `power`,
                       SUM(`player_power_nominal_s`) AS `power_s`
                FROM
                (
                    SELECT `player_power_nominal`,
                           `player_power_nominal_s`
                    FROM `player`
                    LEFT JOIN `playerposition`
                    ON `player_id`=`playerposition_player_id`
                    WHERE `player_team_id`=$team_id
                    AND `playerposition_position_id`!=" . POSITION_GK . "
                    ORDER BY `player_power_nominal` DESC, `player_id` ASC
                    LIMIT 20
                ) AS `t1`";
        $power_sql = f_igosja_mysqli_query($sql);

        $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

        $power      = $power_array[0]['power'];
        $power_s    = $power_array[0]['power_s'];

        $sql = "SELECT SUM(`player_power_nominal`) AS `power`,
                       SUM(`player_power_nominal_s`) AS `power_s`
                FROM
                (
                    SELECT `player_power_nominal`,
                           `player_power_nominal_s`
                    FROM `player`
                    LEFT JOIN `playerposition`
                    ON `player_id`=`playerposition_player_id`
                    WHERE `player_team_id`=$team_id
                    AND `playerposition_position_id`=" . POSITION_GK . "
                    ORDER BY `player_power_nominal` DESC, `player_id` ASC
                    LIMIT 1
                ) AS `t1`";
        $power_sql = f_igosja_mysqli_query($sql);

        $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

        $power_c_21 = $power + $power_array[0]['power'];
        $power_s_21 = $power_s + $power_array[0]['power_s'];

        $sql = "SELECT SUM(`player_power_nominal`) AS `power`,
                       SUM(`player_power_nominal_s`) AS `power_s`
                FROM
                (
                    SELECT `player_power_nominal`,
                           `player_power_nominal_s`
                    FROM `player`
                    LEFT JOIN `playerposition`
                    ON `player_id`=`playerposition_player_id`
                    WHERE `player_team_id`=$team_id
                    AND `playerposition_position_id`!=" . POSITION_GK . "
                    ORDER BY `player_power_nominal` DESC, `player_id` ASC
                    LIMIT 25
                ) AS `t1`";
        $power_sql = f_igosja_mysqli_query($sql);

        $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

        $power      = $power_array[0]['power'];
        $power_s    = $power_array[0]['power_s'];

        $sql = "SELECT SUM(`player_power_nominal`) AS `power`,
                       SUM(`player_power_nominal_s`) AS `power_s`
                FROM
                (
                    SELECT `player_power_nominal`,
                           `player_power_nominal_s`
                    FROM `player`
                    LEFT JOIN `playerposition`
                    ON `player_id`=`playerposition_player_id`
                    WHERE `player_team_id`=$team_id
                    AND `playerposition_position_id`=" . POSITION_GK . "
                    ORDER BY `player_power_nominal` DESC, `player_id` ASC
                    LIMIT 2
                ) AS `t1`";
        $power_sql = f_igosja_mysqli_query($sql);

        $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

        $power_c_27 = $power + $power_array[0]['power'];
        $power_s_27 = $power_s + $power_array[0]['power_s'];

        $power_v    = round(($power_c_16 + $power_c_21 + $power_c_27) / 64 * 16);
        $power_vs   = round(($power_s_16 + $power_s_21 + $power_s_27) / 64 * 16);

        $sql = "UPDATE `team`
                SET `team_power_c_16`=$power_c_16,
                    `team_power_c_21`=$power_c_21,
                    `team_power_c_27`=$power_c_27,
                    `team_power_s_16`=$power_s_16,
                    `team_power_s_21`=$power_s_21,
                    `team_power_s_27`=$power_s_27,
                    `team_power_v`=$power_v,
                    `team_power_vs`=$power_vs
                WHERE `team_id`=$team_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }
}