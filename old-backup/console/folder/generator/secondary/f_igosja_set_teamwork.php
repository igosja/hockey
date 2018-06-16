<?php

/**
 * Збільшуємо зігранніть хокеїстів після гри
 * @param $game_result array
 * @return array
 */
function f_igosja_set_teamwork($game_result)
{
    for ($i=0; $i<2; $i++)
    {
        if (0 == $i)
        {
            $team = TEAM_HOME;
        }
        else
        {
            $team = TEAM_GUEST;
        }

        for ($j=1; $j<=3; $j++)
        {
            $player_1_id = $game_result[$team]['player']['field']['ld_' . $j]['player_id'];
            $player_2_id = $game_result[$team]['player']['field']['rd_' . $j]['player_id'];
            $player_3_id = $game_result[$team]['player']['field']['lw_' . $j]['player_id'];
            $player_4_id = $game_result[$team]['player']['field']['c_' . $j]['player_id'];
            $player_5_id = $game_result[$team]['player']['field']['rw_' . $j]['player_id'];
    
            $sql = "SELECT COUNT(`teamwork_value`) AS `check`
                    FROM `teamwork`
                    WHERE (`teamwork_player_1_id`=$player_1_id
                    AND `teamwork_player_2_id`=$player_2_id)
                    OR (`teamwork_player_1_id`=$player_2_id
                    AND `teamwork_player_2_id`=$player_1_id)";
            $teamwork_sql = f_igosja_mysqli_query($sql);

            $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

            if ($teamwork_array[0]['check'])
            {
                $sql = "UPDATE `teamwork`
                        SET `teamwork_value`=`teamwork_value`+5
                        WHERE (`teamwork_player_1_id`=$player_1_id
                        AND `teamwork_player_2_id`=$player_2_id)
                        OR (`teamwork_player_1_id`=$player_2_id
                        AND `teamwork_player_2_id`=$player_1_id)
                        LIMIT 1";
            }
            else
            {
                $sql = "INSERT INTO `teamwork`
                        SET `teamwork_value`=5,
                            `teamwork_player_1_id`=$player_1_id,
                            `teamwork_player_2_id`=$player_2_id";
            }

            f_igosja_mysqli_query($sql);

            $sql = "SELECT COUNT(`teamwork_value`) AS `check`
                    FROM `teamwork`
                    WHERE (`teamwork_player_1_id`=$player_1_id
                    AND `teamwork_player_2_id`=$player_3_id)
                    OR (`teamwork_player_1_id`=$player_3_id
                    AND `teamwork_player_2_id`=$player_1_id)";
            $teamwork_sql = f_igosja_mysqli_query($sql);

            $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

            if ($teamwork_array[0]['check'])
            {
                $sql = "UPDATE `teamwork`
                        SET `teamwork_value`=`teamwork_value`+5
                        WHERE (`teamwork_player_1_id`=$player_1_id
                        AND `teamwork_player_2_id`=$player_3_id)
                        OR (`teamwork_player_1_id`=$player_3_id
                        AND `teamwork_player_2_id`=$player_1_id)
                        LIMIT 1";
            }
            else
            {
                $sql = "INSERT INTO `teamwork`
                        SET `teamwork_value`=5,
                            `teamwork_player_1_id`=$player_1_id,
                            `teamwork_player_2_id`=$player_3_id";
            }

            f_igosja_mysqli_query($sql);

            $sql = "SELECT COUNT(`teamwork_value`) AS `check`
                    FROM `teamwork`
                    WHERE (`teamwork_player_1_id`=$player_1_id
                    AND `teamwork_player_2_id`=$player_4_id)
                    OR (`teamwork_player_1_id`=$player_4_id
                    AND `teamwork_player_2_id`=$player_1_id)";
            $teamwork_sql = f_igosja_mysqli_query($sql);

            $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

            if ($teamwork_array[0]['check'])
            {
                $sql = "UPDATE `teamwork`
                        SET `teamwork_value`=`teamwork_value`+5
                        WHERE (`teamwork_player_1_id`=$player_1_id
                        AND `teamwork_player_2_id`=$player_4_id)
                        OR (`teamwork_player_1_id`=$player_4_id
                        AND `teamwork_player_2_id`=$player_1_id)
                        LIMIT 1";
            }
            else
            {
                $sql = "INSERT INTO `teamwork`
                        SET `teamwork_value`=5,
                            `teamwork_player_1_id`=$player_1_id,
                            `teamwork_player_2_id`=$player_4_id";
            }

            f_igosja_mysqli_query($sql);

            $sql = "SELECT COUNT(`teamwork_value`) AS `check`
                    FROM `teamwork`
                    WHERE (`teamwork_player_1_id`=$player_1_id
                    AND `teamwork_player_2_id`=$player_5_id)
                    OR (`teamwork_player_1_id`=$player_5_id
                    AND `teamwork_player_2_id`=$player_1_id)";
            $teamwork_sql = f_igosja_mysqli_query($sql);

            $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

            if ($teamwork_array[0]['check'])
            {
                $sql = "UPDATE `teamwork`
                        SET `teamwork_value`=`teamwork_value`+5
                        WHERE (`teamwork_player_1_id`=$player_1_id
                        AND `teamwork_player_2_id`=$player_5_id)
                        OR (`teamwork_player_1_id`=$player_5_id
                        AND `teamwork_player_2_id`=$player_1_id)
                        LIMIT 1";
            }
            else
            {
                $sql = "INSERT INTO `teamwork`
                        SET `teamwork_value`=5,
                            `teamwork_player_1_id`=$player_1_id,
                            `teamwork_player_2_id`=$player_5_id";
            }

            f_igosja_mysqli_query($sql);

            $sql = "SELECT COUNT(`teamwork_value`) AS `check`
                    FROM `teamwork`
                    WHERE (`teamwork_player_1_id`=$player_2_id
                    AND `teamwork_player_2_id`=$player_3_id)
                    OR (`teamwork_player_1_id`=$player_3_id
                    AND `teamwork_player_2_id`=$player_2_id)";
            $teamwork_sql = f_igosja_mysqli_query($sql);

            $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

            if ($teamwork_array[0]['check'])
            {
                $sql = "UPDATE `teamwork`
                        SET `teamwork_value`=`teamwork_value`+5
                        WHERE (`teamwork_player_1_id`=$player_2_id
                        AND `teamwork_player_2_id`=$player_3_id)
                        OR (`teamwork_player_1_id`=$player_3_id
                        AND `teamwork_player_2_id`=$player_2_id)
                        LIMIT 1";
            }
            else
            {
                $sql = "INSERT INTO `teamwork`
                        SET `teamwork_value`=5,
                            `teamwork_player_1_id`=$player_2_id,
                            `teamwork_player_2_id`=$player_3_id";
            }

            f_igosja_mysqli_query($sql);

            $sql = "SELECT COUNT(`teamwork_value`) AS `check`
                    FROM `teamwork`
                    WHERE (`teamwork_player_1_id`=$player_2_id
                    AND `teamwork_player_2_id`=$player_4_id)
                    OR (`teamwork_player_1_id`=$player_4_id
                    AND `teamwork_player_2_id`=$player_2_id)";
            $teamwork_sql = f_igosja_mysqli_query($sql);

            $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

            if ($teamwork_array[0]['check'])
            {
                $sql = "UPDATE `teamwork`
                        SET `teamwork_value`=`teamwork_value`+5
                        WHERE (`teamwork_player_1_id`=$player_2_id
                        AND `teamwork_player_2_id`=$player_4_id)
                        OR (`teamwork_player_1_id`=$player_4_id
                        AND `teamwork_player_2_id`=$player_2_id)
                        LIMIT 1";
            }
            else
            {
                $sql = "INSERT INTO `teamwork`
                        SET `teamwork_value`=5,
                            `teamwork_player_1_id`=$player_2_id,
                            `teamwork_player_2_id`=$player_4_id";
            }

            f_igosja_mysqli_query($sql);

            $sql = "SELECT COUNT(`teamwork_value`) AS `check`
                    FROM `teamwork`
                    WHERE (`teamwork_player_1_id`=$player_2_id
                    AND `teamwork_player_2_id`=$player_5_id)
                    OR (`teamwork_player_1_id`=$player_5_id
                    AND `teamwork_player_2_id`=$player_2_id)";
            $teamwork_sql = f_igosja_mysqli_query($sql);

            $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

            if ($teamwork_array[0]['check'])
            {
                $sql = "UPDATE `teamwork`
                        SET `teamwork_value`=`teamwork_value`+5
                        WHERE (`teamwork_player_1_id`=$player_2_id
                        AND `teamwork_player_2_id`=$player_5_id)
                        OR (`teamwork_player_1_id`=$player_5_id
                        AND `teamwork_player_2_id`=$player_2_id)
                        LIMIT 1";
            }
            else
            {
                $sql = "INSERT INTO `teamwork`
                        SET `teamwork_value`=5,
                            `teamwork_player_1_id`=$player_2_id,
                            `teamwork_player_2_id`=$player_5_id";
            }

            f_igosja_mysqli_query($sql);

            $sql = "SELECT COUNT(`teamwork_value`) AS `check`
                    FROM `teamwork`
                    WHERE (`teamwork_player_1_id`=$player_3_id
                    AND `teamwork_player_2_id`=$player_4_id)
                    OR (`teamwork_player_1_id`=$player_4_id
                    AND `teamwork_player_2_id`=$player_3_id)";
            $teamwork_sql = f_igosja_mysqli_query($sql);

            $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

            if ($teamwork_array[0]['check'])
            {
                $sql = "UPDATE `teamwork`
                        SET `teamwork_value`=`teamwork_value`+5
                        WHERE (`teamwork_player_1_id`=$player_3_id
                        AND `teamwork_player_2_id`=$player_4_id)
                        OR (`teamwork_player_1_id`=$player_4_id
                        AND `teamwork_player_2_id`=$player_3_id)
                        LIMIT 1";
            }
            else
            {
                $sql = "INSERT INTO `teamwork`
                        SET `teamwork_value`=5,
                            `teamwork_player_1_id`=$player_3_id,
                            `teamwork_player_2_id`=$player_4_id";
            }

            f_igosja_mysqli_query($sql);

            $sql = "SELECT COUNT(`teamwork_value`) AS `check`
                    FROM `teamwork`
                    WHERE (`teamwork_player_1_id`=$player_3_id
                    AND `teamwork_player_2_id`=$player_5_id)
                    OR (`teamwork_player_1_id`=$player_5_id
                    AND `teamwork_player_2_id`=$player_3_id)";
            $teamwork_sql = f_igosja_mysqli_query($sql);

            $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

            if ($teamwork_array[0]['check'])
            {
                $sql = "UPDATE `teamwork`
                        SET `teamwork_value`=`teamwork_value`+5
                        WHERE (`teamwork_player_1_id`=$player_3_id
                        AND `teamwork_player_2_id`=$player_5_id)
                        OR (`teamwork_player_1_id`=$player_5_id
                        AND `teamwork_player_2_id`=$player_3_id)
                        LIMIT 1";
            }
            else
            {
                $sql = "INSERT INTO `teamwork`
                        SET `teamwork_value`=5,
                            `teamwork_player_1_id`=$player_3_id,
                            `teamwork_player_2_id`=$player_5_id";
            }

            f_igosja_mysqli_query($sql);

            $sql = "SELECT COUNT(`teamwork_value`) AS `check`
                    FROM `teamwork`
                    WHERE (`teamwork_player_1_id`=$player_4_id
                    AND `teamwork_player_2_id`=$player_5_id)
                    OR (`teamwork_player_1_id`=$player_5_id
                    AND `teamwork_player_2_id`=$player_4_id)";
            $teamwork_sql = f_igosja_mysqli_query($sql);

            $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

            if ($teamwork_array[0]['check'])
            {
                $sql = "UPDATE `teamwork`
                        SET `teamwork_value`=`teamwork_value`+5
                        WHERE (`teamwork_player_1_id`=$player_4_id
                        AND `teamwork_player_2_id`=$player_5_id)
                        OR (`teamwork_player_1_id`=$player_5_id
                        AND `teamwork_player_2_id`=$player_4_id)
                        LIMIT 1";
            }
            else
            {
                $sql = "INSERT INTO `teamwork`
                        SET `teamwork_value`=5,
                            `teamwork_player_1_id`=$player_4_id,
                            `teamwork_player_2_id`=$player_5_id";
            }

            f_igosja_mysqli_query($sql);
        }
    }

    return $game_result;
}