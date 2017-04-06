<?php

function f_igosja_get_teamwork($game_result, $team)
{
    for ($i=1; $i<=3; $i++)
    {
        $teamwork = 0;

        $player_1_id = $game_result[$team]['player']['field']['ld_' . $i]['player_id'];
        $player_2_id = $game_result[$team]['player']['field']['rd_' . $i]['player_id'];
        $player_3_id = $game_result[$team]['player']['field']['lw_' . $i]['player_id'];
        $player_4_id = $game_result[$team]['player']['field']['c_' . $i]['player_id'];
        $player_5_id = $game_result[$team]['player']['field']['rw_' . $i]['player_id'];

        $sql = "SELECT `teamwork_value`
                FROM `teamwork`
                WHERE (`teamwork_player_1_id`='$player_1_id'
                AND `teamwork_player_2_id`='$player_2_id')
                OR (`teamwork_player_1_id`='$player_2_id'
                AND `teamwork_player_2_id`='$player_1_id')
                LIMIT 1";
        $teamwork_sql = f_igosja_mysqli_query($sql);

        if ($teamwork_sql->num_rows)
        {
            $teamwork_array = $teamwork_sql->fetch_all(1);

            $teamwork = $teamwork + $teamwork_array[0]['teamwork_value'];
        }

        $sql = "SELECT `teamwork_value`
                FROM `teamwork`
                WHERE (`teamwork_player_1_id`='$player_1_id'
                AND `teamwork_player_2_id`='$player_3_id')
                OR (`teamwork_player_1_id`='$player_3_id'
                AND `teamwork_player_2_id`='$player_1_id')
                LIMIT 1";
        $teamwork_sql = f_igosja_mysqli_query($sql);

        if ($teamwork_sql->num_rows)
        {
            $teamwork_array = $teamwork_sql->fetch_all(1);

            $teamwork = $teamwork + $teamwork_array[0]['teamwork_value'];
        }

        $sql = "SELECT `teamwork_value`
                FROM `teamwork`
                WHERE (`teamwork_player_1_id`='$player_1_id'
                AND `teamwork_player_2_id`='$player_4_id')
                OR (`teamwork_player_1_id`='$player_4_id'
                AND `teamwork_player_2_id`='$player_1_id')
                LIMIT 1";
        $teamwork_sql = f_igosja_mysqli_query($sql);

        if ($teamwork_sql->num_rows)
        {
            $teamwork_array = $teamwork_sql->fetch_all(1);

            $teamwork = $teamwork + $teamwork_array[0]['teamwork_value'];
        }

        $sql = "SELECT `teamwork_value`
                FROM `teamwork`
                WHERE (`teamwork_player_1_id`='$player_1_id'
                AND `teamwork_player_2_id`='$player_5_id')
                OR (`teamwork_player_1_id`='$player_5_id'
                AND `teamwork_player_2_id`='$player_1_id')
                LIMIT 1";
        $teamwork_sql = f_igosja_mysqli_query($sql);

        if ($teamwork_sql->num_rows)
        {
            $teamwork_array = $teamwork_sql->fetch_all(1);

            $teamwork = $teamwork + $teamwork_array[0]['teamwork_value'];
        }

        $sql = "SELECT `teamwork_value`
                FROM `teamwork`
                WHERE (`teamwork_player_1_id`='$player_2_id'
                AND `teamwork_player_2_id`='$player_3_id')
                OR (`teamwork_player_1_id`='$player_3_id'
                AND `teamwork_player_2_id`='$player_2_id')
                LIMIT 1";
        $teamwork_sql = f_igosja_mysqli_query($sql);

        if ($teamwork_sql->num_rows)
        {
            $teamwork_array = $teamwork_sql->fetch_all(1);

            $teamwork = $teamwork + $teamwork_array[0]['teamwork_value'];
        }

        $sql = "SELECT `teamwork_value`
                FROM `teamwork`
                WHERE (`teamwork_player_1_id`='$player_2_id'
                AND `teamwork_player_2_id`='$player_4_id')
                OR (`teamwork_player_1_id`='$player_4_id'
                AND `teamwork_player_2_id`='$player_2_id')
                LIMIT 1";
        $teamwork_sql = f_igosja_mysqli_query($sql);

        if ($teamwork_sql->num_rows)
        {
            $teamwork_array = $teamwork_sql->fetch_all(1);

            $teamwork = $teamwork + $teamwork_array[0]['teamwork_value'];
        }

        $sql = "SELECT `teamwork_value`
                FROM `teamwork`
                WHERE (`teamwork_player_1_id`='$player_2_id'
                AND `teamwork_player_2_id`='$player_5_id')
                OR (`teamwork_player_1_id`='$player_5_id'
                AND `teamwork_player_2_id`='$player_2_id')
                LIMIT 1";
        $teamwork_sql = f_igosja_mysqli_query($sql);

        if ($teamwork_sql->num_rows)
        {
            $teamwork_array = $teamwork_sql->fetch_all(1);

            $teamwork = $teamwork + $teamwork_array[0]['teamwork_value'];
        }

        $sql = "SELECT `teamwork_value`
                FROM `teamwork`
                WHERE (`teamwork_player_1_id`='$player_3_id'
                AND `teamwork_player_2_id`='$player_4_id')
                OR (`teamwork_player_1_id`='$player_4_id'
                AND `teamwork_player_2_id`='$player_3_id')
                LIMIT 1";
        $teamwork_sql = f_igosja_mysqli_query($sql);

        if ($teamwork_sql->num_rows)
        {
            $teamwork_array = $teamwork_sql->fetch_all(1);

            $teamwork = $teamwork + $teamwork_array[0]['teamwork_value'];
        }

        $sql = "SELECT `teamwork_value`
                FROM `teamwork`
                WHERE (`teamwork_player_1_id`='$player_3_id'
                AND `teamwork_player_2_id`='$player_5_id')
                OR (`teamwork_player_1_id`='$player_5_id'
                AND `teamwork_player_2_id`='$player_3_id')
                LIMIT 1";
        $teamwork_sql = f_igosja_mysqli_query($sql);

        if ($teamwork_sql->num_rows)
        {
            $teamwork_array = $teamwork_sql->fetch_all(1);

            $teamwork = $teamwork + $teamwork_array[0]['teamwork_value'];
        }

        $sql = "SELECT `teamwork_value`
                FROM `teamwork`
                WHERE (`teamwork_player_1_id`='$player_4_id'
                AND `teamwork_player_2_id`='$player_5_id')
                OR (`teamwork_player_1_id`='$player_5_id'
                AND `teamwork_player_2_id`='$player_4_id')
                LIMIT 1";
        $teamwork_sql = f_igosja_mysqli_query($sql);

        if ($teamwork_sql->num_rows)
        {
            $teamwork_array = $teamwork_sql->fetch_all(1);

            $teamwork = $teamwork + $teamwork_array[0]['teamwork_value'];
        }

        $game_result[$team]['team']['teamwork'][$i] = $teamwork;
    }

    return $game_result;
}