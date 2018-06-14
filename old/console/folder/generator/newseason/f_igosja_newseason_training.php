<?php

/**
 * Тренуємо граців
 */
function f_igosja_newseason_training()
{
    $sql = "UPDATE `training`
            LEFT JOIN `team`
            ON `training_team_id`=`team_id`
            LEFT JOIN `basetraining`
            ON `team_basetraining_id`=`basetraining_id`
            LEFT JOIN `player`
            ON `training_player_id`=`player_id`
            SET `training_percent`=100
            WHERE `training_ready`=0";
    f_igosja_mysqli_query($sql);

    $sql = "SELECT `training_id`,
                   `training_player_id`,
                   `training_position_id`,
                   `training_power`,
                   `training_special_id`
            FROM `training`
            WHERE `training_percent`>=100
            AND `training_ready`=0
            ORDER BY `training_id` ASC";
    $training_sql = f_igosja_mysqli_query($sql);

    $training_array = $training_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($training_array as $item)
    {
        $training_id    = $item['training_id'];
        $player_id      = $item['training_player_id'];

        if ($item['training_power'])
        {
            $sql = "UPDATE `player`
                    SET `player_power_nominal`=`player_power_nominal`+1
                    WHERE `player_id`=$player_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $log = array(
                'history_historytext_id' => HISTORYTEXT_PLAYER_TRAINING_POINT,
                'history_player_id' => $player_id,
            );
            f_igosja_history($log);
        }
        elseif ($item['training_position_id'])
        {
            $position_id = $item['training_position_id'];

            $sql = "INSERT INTO `playerposition`
                    SET `playerposition_player_id`=$player_id,
                        `playerposition_position_id`=$position_id";
            f_igosja_mysqli_query($sql);

            $log = array(
                'history_historytext_id' => HISTORYTEXT_PLAYER_TRAINING_POSITION,
                'history_player_id' => $player_id,
                'history_position_id' => $position_id,
            );
            f_igosja_history($log);
        }
        elseif ($item['training_special_id'])
        {
            $special_id = $item['training_special_id'];

            $sql = "SELECT COUNT(`playerspecial_special_id`) AS `count`
                    FROM `playerspecial`
                    WHERE `playerspecial_player_id`=$player_id
                    AND `playerspecial_special_id`=$special_id";
            $check_sql = f_igosja_mysqli_query($sql);

            $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

            if ($check_array[0]['count'])
            {
                $sql = "UPDATE `playerspecial`
                        SET `playerspecial_level`=`playerspecial_level`+1
                        WHERE `playerspecial_player_id`=$player_id
                        AND `playerspecial_special_id`=$special_id";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $sql = "INSERT INTO `playerspecial`
                        SET `playerspecial_player_id`=$player_id,
                            `playerspecial_special_id`=$special_id";
                f_igosja_mysqli_query($sql);
            }

            $log = array(
                'history_historytext_id' => HISTORYTEXT_PLAYER_TRAINING_SPECIAL,
                'history_player_id' => $player_id,
                'history_special_id' => $special_id,
            );
            f_igosja_history($log);
        }

        $sql = "UPDATE `training`
                SET `training_percent`=100,
                    `training_ready`=1
                WHERE `training_id`=$training_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }
}