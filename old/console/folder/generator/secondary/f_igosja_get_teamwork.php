<?php

/**
 * Рахуємо зіграність хокеїстів в розрізі ліній
 * @param $game_result array
 * @return array
 */
function f_igosja_get_teamwork($game_result)
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
            $teamwork = 0;
    
            $player_1_id = $game_result[$team]['player']['field']['ld_' . $j]['player_id'];
            $player_2_id = $game_result[$team]['player']['field']['rd_' . $j]['player_id'];
            $player_3_id = $game_result[$team]['player']['field']['lw_' . $j]['player_id'];
            $player_4_id = $game_result[$team]['player']['field']['c_' . $j]['player_id'];
            $player_5_id = $game_result[$team]['player']['field']['rw_' . $j]['player_id'];

            $sql = "SELECT `teamwork_value`
                    FROM `teamwork`
                    WHERE (`teamwork_player_1_id`=$player_1_id
                    AND `teamwork_player_2_id`=$player_2_id)
                    OR (`teamwork_player_1_id`=$player_2_id
                    AND `teamwork_player_2_id`=$player_1_id)
                    LIMIT 1";
            $teamwork_sql = f_igosja_mysqli_query($sql);

            if ($teamwork_sql->num_rows)
            {
                $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

                $teamwork = $teamwork + $teamwork_array[0]['teamwork_value'];
            }

            $sql = "SELECT `teamwork_value`
                    FROM `teamwork`
                    WHERE (`teamwork_player_1_id`=$player_1_id
                    AND `teamwork_player_2_id`=$player_3_id)
                    OR (`teamwork_player_1_id`=$player_3_id
                    AND `teamwork_player_2_id`=$player_1_id)
                    LIMIT 1";
            $teamwork_sql = f_igosja_mysqli_query($sql);

            if ($teamwork_sql->num_rows)
            {
                $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

                $teamwork = $teamwork + $teamwork_array[0]['teamwork_value'];
            }

            $sql = "SELECT `teamwork_value`
                    FROM `teamwork`
                    WHERE (`teamwork_player_1_id`=$player_1_id
                    AND `teamwork_player_2_id`=$player_4_id)
                    OR (`teamwork_player_1_id`=$player_4_id
                    AND `teamwork_player_2_id`=$player_1_id)
                    LIMIT 1";
            $teamwork_sql = f_igosja_mysqli_query($sql);

            if ($teamwork_sql->num_rows)
            {
                $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

                $teamwork = $teamwork + $teamwork_array[0]['teamwork_value'];
            }

            $sql = "SELECT `teamwork_value`
                    FROM `teamwork`
                    WHERE (`teamwork_player_1_id`=$player_1_id
                    AND `teamwork_player_2_id`=$player_5_id)
                    OR (`teamwork_player_1_id`=$player_5_id
                    AND `teamwork_player_2_id`=$player_1_id)
                    LIMIT 1";
            $teamwork_sql = f_igosja_mysqli_query($sql);

            if ($teamwork_sql->num_rows)
            {
                $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

                $teamwork = $teamwork + $teamwork_array[0]['teamwork_value'];
            }

            $sql = "SELECT `teamwork_value`
                    FROM `teamwork`
                    WHERE (`teamwork_player_1_id`=$player_2_id
                    AND `teamwork_player_2_id`=$player_3_id)
                    OR (`teamwork_player_1_id`=$player_3_id
                    AND `teamwork_player_2_id`=$player_2_id)
                    LIMIT 1";
            $teamwork_sql = f_igosja_mysqli_query($sql);

            if ($teamwork_sql->num_rows)
            {
                $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

                $teamwork = $teamwork + $teamwork_array[0]['teamwork_value'];
            }

            $sql = "SELECT `teamwork_value`
                    FROM `teamwork`
                    WHERE (`teamwork_player_1_id`=$player_2_id
                    AND `teamwork_player_2_id`=$player_4_id)
                    OR (`teamwork_player_1_id`=$player_4_id
                    AND `teamwork_player_2_id`=$player_2_id)
                    LIMIT 1";
            $teamwork_sql = f_igosja_mysqli_query($sql);

            if ($teamwork_sql->num_rows)
            {
                $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

                $teamwork = $teamwork + $teamwork_array[0]['teamwork_value'];
            }

            $sql = "SELECT `teamwork_value`
                    FROM `teamwork`
                    WHERE (`teamwork_player_1_id`=$player_2_id
                    AND `teamwork_player_2_id`=$player_5_id)
                    OR (`teamwork_player_1_id`=$player_5_id
                    AND `teamwork_player_2_id`=$player_2_id)
                    LIMIT 1";
            $teamwork_sql = f_igosja_mysqli_query($sql);

            if ($teamwork_sql->num_rows)
            {
                $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

                $teamwork = $teamwork + $teamwork_array[0]['teamwork_value'];
            }

            $sql = "SELECT `teamwork_value`
                    FROM `teamwork`
                    WHERE (`teamwork_player_1_id`=$player_3_id
                    AND `teamwork_player_2_id`=$player_4_id)
                    OR (`teamwork_player_1_id`=$player_4_id
                    AND `teamwork_player_2_id`=$player_3_id)
                    LIMIT 1";
            $teamwork_sql = f_igosja_mysqli_query($sql);

            if ($teamwork_sql->num_rows)
            {
                $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

                $teamwork = $teamwork + $teamwork_array[0]['teamwork_value'];
            }

            $sql = "SELECT `teamwork_value`
                    FROM `teamwork`
                    WHERE (`teamwork_player_1_id`=$player_3_id
                    AND `teamwork_player_2_id`=$player_5_id)
                    OR (`teamwork_player_1_id`=$player_5_id
                    AND `teamwork_player_2_id`=$player_3_id)
                    LIMIT 1";
            $teamwork_sql = f_igosja_mysqli_query($sql);

            if ($teamwork_sql->num_rows)
            {
                $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

                $teamwork = $teamwork + $teamwork_array[0]['teamwork_value'];
            }

            $sql = "SELECT `teamwork_value`
                    FROM `teamwork`
                    WHERE (`teamwork_player_1_id`=$player_4_id
                    AND `teamwork_player_2_id`=$player_5_id)
                    OR (`teamwork_player_1_id`=$player_5_id
                    AND `teamwork_player_2_id`=$player_4_id)
                    LIMIT 1";
            $teamwork_sql = f_igosja_mysqli_query($sql);

            if ($teamwork_sql->num_rows)
            {
                $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

                $teamwork = $teamwork + $teamwork_array[0]['teamwork_value'];
            }

            $game_result[$team]['team']['teamwork'][$j] = round($teamwork / 10);
        }
    }

    return $game_result;
}