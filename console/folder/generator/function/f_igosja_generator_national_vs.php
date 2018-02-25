<?php

/**
 * Рахуємо силу збірних vs
 */
function f_igosja_generator_national_vs()
{
    $sql = "SELECT `national_id`
            FROM `national`
            WHERE `national_id`!=0
            ORDER BY `national_id` ASC";
    $national_sql = f_igosja_mysqli_query($sql);

    $national_array = $national_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($national_array as $item)
    {
        $national_id = $item['national_id'];

        $sql = "SELECT SUM(`player_power_nominal_s`) AS `power_s`
                FROM
                (
                    SELECT `player_power_nominal_s`
                    FROM `player`
                    LEFT JOIN `playerposition`
                    ON `player_id`=`playerposition_player_id`
                    WHERE `player_national_id`=$national_id
                    AND `playerposition_position_id`!=" . POSITION_GK . "
                    ORDER BY `player_power_nominal` DESC, `player_id` ASC
                    LIMIT 15
                ) AS `t1`";
        $power_sql = f_igosja_mysqli_query($sql);

        $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

        $power_s = $power_array[0]['power_s'];

        $sql = "SELECT SUM(`player_power_nominal_s`) AS `power_s`
                FROM
                (
                    SELECT `player_power_nominal_s`
                    FROM `player`
                    LEFT JOIN `playerposition`
                    ON `player_id`=`playerposition_player_id`
                    WHERE `player_national_id`=$national_id
                    AND `playerposition_position_id`=" . POSITION_GK . "
                    ORDER BY `player_power_nominal` DESC, `player_id` ASC
                    LIMIT 1
                ) AS `t1`";
        $power_sql = f_igosja_mysqli_query($sql);

        $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

        $power_s_16 = $power_s + $power_array[0]['power_s'];

        $sql = "SELECT SUM(`player_power_nominal_s`) AS `power_s`
                FROM
                (
                    SELECT `player_power_nominal_s`
                    FROM `player`
                    LEFT JOIN `playerposition`
                    ON `player_id`=`playerposition_player_id`
                    WHERE `player_national_id`=$national_id
                    AND `playerposition_position_id`!=" . POSITION_GK . "
                    ORDER BY `player_power_nominal` DESC, `player_id` ASC
                    LIMIT 20
                ) AS `t1`";
        $power_sql = f_igosja_mysqli_query($sql);

        $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

        $power_s = $power_array[0]['power_s'];

        $sql = "SELECT SUM(`player_power_nominal_s`) AS `power_s`
                FROM
                (
                    SELECT `player_power_nominal_s`
                    FROM `player`
                    LEFT JOIN `playerposition`
                    ON `player_id`=`playerposition_player_id`
                    WHERE `player_national_id`=$national_id
                    AND `playerposition_position_id`=" . POSITION_GK . "
                    ORDER BY `player_power_nominal` DESC, `player_id` ASC
                    LIMIT 1
                ) AS `t1`";
        $power_sql = f_igosja_mysqli_query($sql);

        $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

        $power_s_21 = $power_s + $power_array[0]['power_s'];

        $sql = "SELECT SUM(`player_power_nominal_s`) AS `power_s`
                FROM
                (
                    SELECT `player_power_nominal_s`
                    FROM `player`
                    LEFT JOIN `playerposition`
                    ON `player_id`=`playerposition_player_id`
                    WHERE `player_national_id`=$national_id
                    AND `playerposition_position_id`!=" . POSITION_GK . "
                    ORDER BY `player_power_nominal` DESC, `player_id` ASC
                    LIMIT 25
                ) AS `t1`";
        $power_sql = f_igosja_mysqli_query($sql);

        $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

        $power_s = $power_array[0]['power_s'];

        $sql = "SELECT SUM(`player_power_nominal_s`) AS `power_s`
                FROM
                (
                    SELECT `player_power_nominal_s`
                    FROM `player`
                    LEFT JOIN `playerposition`
                    ON `player_id`=`playerposition_player_id`
                    WHERE `player_national_id`=$national_id
                    AND `playerposition_position_id`=" . POSITION_GK . "
                    ORDER BY `player_power_nominal` DESC, `player_id` ASC
                    LIMIT 2
                ) AS `t1`";
        $power_sql = f_igosja_mysqli_query($sql);

        $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

        $power_s_27 = $power_s + $power_array[0]['power_s'];

        $power_vs = round(($power_s_16 + $power_s_21 + $power_s_27) / 64 * 16);

        $sql = "UPDATE `national`
                SET `national_power_vs`=$power_vs
                WHERE `national_id`=$national_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }
}