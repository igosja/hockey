<?php

/**
 * @var $auth_team_id integer
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/../include/include.php');

$result = array(
    'power' => 123,
    'position' => 123,
    'lineup' => 123,
    'teamwork_1' => 123,
    'teamwork_2' => 123,
    'teamwork_3' => 123,
);

if ($data = f_igosja_request_post('data', 'line'))
{
    $power      = 0;
    $position   = 0;
    $lineup     = 0;
    $teamwork_1 = 0;
    $teamwork_2 = 0;
    $teamwork_3 = 0;

    $gk     = $data[0][0];
    $ld1    = $data[1][1];
    $rd1    = $data[1][2];
    $lw1    = $data[1][3];
    $c1     = $data[1][4];
    $rw1    = $data[1][5];
    $ld2    = $data[2][1];
    $rd2    = $data[2][2];
    $lw2    = $data[2][3];
    $c2     = $data[2][4];
    $rw2    = $data[2][5];
    $ld3    = $data[3][1];
    $rd3    = $data[3][2];
    $lw3    = $data[3][3];
    $c3     = $data[3][4];
    $rw3    = $data[3][5];

    if (0 != $gk)
    {
        $sql = "SELECT `player_power_real`
                FROM `player`
                WHERE `player_id`=$gk
                LIMIT 1";
        $gk_sql = f_igosja_mysqli_query($sql);

        if (0 != $gk_sql->num_rows)
        {
            $gk_array = $gk_sql->fetch_all(MYSQLI_ASSOC);

            $power      = $power + $gk_array[0]['player_power_real'];
            $position   = $position + $gk_array[0]['player_power_real'];
        }
    }

    if (0 != $ld1)
    {
        $sql = "SELECT `player_power_real`,
                       ROUND(IF(`playerposition_position_id`=" . POSITION_LD . ", `player_power_real`, IF(`playerposition_position_id`=" . POSITION_LW . ", `player_power_real`*0.9, IF(`playerposition_position_id`=" . POSITION_RD . ", `player_power_real`*0.9, `player_power_real`*0.8)))) AS `player_power_position`
                FROM `player`
                LEFT JOIN `playerposition`
                ON `player_id`=`playerposition_player_id`
                WHERE `player_id`=$ld1
                ORDER BY `player_power_position` DESC
                LIMIT 1";
        $ld1_sql = f_igosja_mysqli_query($sql);

        if (0 != $ld1_sql->num_rows)
        {
            $ld1_array = $ld1_sql->fetch_all(MYSQLI_ASSOC);

            $power      = $power + $ld1_array[0]['player_power_real'];
            $position   = $position + $ld1_array[0]['player_power_position'];
        }
    }

    if (0 != $rd1)
    {
        $sql = "SELECT `player_power_real`,
                       ROUND(IF(`playerposition_position_id`=" . POSITION_RD . ", `player_power_real`, IF(`playerposition_position_id`=" . POSITION_RW . ", `player_power_real`*0.9, IF(`playerposition_position_id`=" . POSITION_LD . ", `player_power_real`*0.9, `player_power_real`*0.8)))) AS `player_power_position`
                FROM `player`
                LEFT JOIN `playerposition`
                ON `player_id`=`playerposition_player_id`
                WHERE `player_id`=$rd1
                ORDER BY `player_power_position` DESC
                LIMIT 1";
        $rd1_sql = f_igosja_mysqli_query($sql);

        if (0 != $rd1_sql->num_rows)
        {
            $rd1_array = $rd1_sql->fetch_all(MYSQLI_ASSOC);

            $power      = $power + $rd1_array[0]['player_power_real'];
            $position   = $position + $rd1_array[0]['player_power_position'];
        }
    }

    if (0 != $lw1)
    {
        $sql = "SELECT `player_power_real`,
                       ROUND(IF(`playerposition_position_id`=" . POSITION_LW . ", `player_power_real`, IF(`playerposition_position_id`=" . POSITION_C . ", `player_power_real`*0.9, IF(`playerposition_position_id`=" . POSITION_LD . ", `player_power_real`*0.9, `player_power_real`*0.8)))) AS `player_power_position`
                FROM `player`
                LEFT JOIN `playerposition`
                ON `player_id`=`playerposition_player_id`
                WHERE `player_id`=$lw1
                ORDER BY `player_power_position` DESC
                LIMIT 1";
        $lw1_sql = f_igosja_mysqli_query($sql);

        if (0 != $lw1_sql->num_rows)
        {
            $lw1_array = $lw1_sql->fetch_all(MYSQLI_ASSOC);

            $power      = $power + $lw1_array[0]['player_power_real'];
            $position   = $position + $lw1_array[0]['player_power_position'];
        }
    }

    if (0 != $c1)
    {
        $sql = "SELECT `player_power_real`,
                       ROUND(IF(`playerposition_position_id`=" . POSITION_C . ", `player_power_real`, IF(`playerposition_position_id`=" . POSITION_LW . ", `player_power_real`*0.9, IF(`playerposition_position_id`=" . POSITION_RW . ", `player_power_real`*0.9, `player_power_real`*0.8)))) AS `player_power_position`
                FROM `player`
                LEFT JOIN `playerposition`
                ON `player_id`=`playerposition_player_id`
                WHERE `player_id`=$c1
                ORDER BY `player_power_position` DESC
                LIMIT 1";
        $c1_sql = f_igosja_mysqli_query($sql);

        if (0 != $c1_sql->num_rows)
        {
            $c1_array = $c1_sql->fetch_all(MYSQLI_ASSOC);

            $power      = $power + $c1_array[0]['player_power_real'];
            $position   = $position + $c1_array[0]['player_power_position'];
        }
    }

    if (0 != $rw1)
    {
        $sql = "SELECT `player_power_real`,
                       ROUND(IF(`playerposition_position_id`=" . POSITION_RW . ", `player_power_real`, IF(`playerposition_position_id`=" . POSITION_C . ", `player_power_real`*0.9, IF(`playerposition_position_id`=" . POSITION_RD . ", `player_power_real`*0.9, `player_power_real`*0.8)))) AS `player_power_position`
                FROM `player`
                LEFT JOIN `playerposition`
                ON `player_id`=`playerposition_player_id`
                WHERE `player_id`=$rw1
                ORDER BY `player_power_position` DESC
                LIMIT 1";
        $rw1_sql = f_igosja_mysqli_query($sql);

        if (0 != $rw1_sql->num_rows)
        {
            $rw1_array = $rw1_sql->fetch_all(MYSQLI_ASSOC);

            $power      = $power + $rw1_array[0]['player_power_real'];
            $position   = $position + $rw1_array[0]['player_power_position'];
        }
    }

    if (0 != $ld2)
    {
        $sql = "SELECT `player_power_real`,
                       ROUND(IF(`playerposition_position_id`=" . POSITION_LD . ", `player_power_real`, IF(`playerposition_position_id`=" . POSITION_LW . ", `player_power_real`*0.9, IF(`playerposition_position_id`=" . POSITION_RD . ", `player_power_real`*0.9, `player_power_real`*0.8)))) AS `player_power_position`
                FROM `player`
                LEFT JOIN `playerposition`
                ON `player_id`=`playerposition_player_id`
                WHERE `player_id`=$ld2
                ORDER BY `player_power_position` DESC
                LIMIT 1";
        $ld2_sql = f_igosja_mysqli_query($sql);

        if (0 != $ld2_sql->num_rows)
        {
            $ld2_array = $ld2_sql->fetch_all(MYSQLI_ASSOC);

            $power      = $power + $ld2_array[0]['player_power_real'];
            $position   = $position + $ld2_array[0]['player_power_position'];
        }
    }

    if (0 != $rd2)
    {
        $sql = "SELECT `player_power_real`,
                       ROUND(IF(`playerposition_position_id`=" . POSITION_RD . ", `player_power_real`, IF(`playerposition_position_id`=" . POSITION_RW . ", `player_power_real`*0.9, IF(`playerposition_position_id`=" . POSITION_LD . ", `player_power_real`*0.9, `player_power_real`*0.8)))) AS `player_power_position`
                FROM `player`
                LEFT JOIN `playerposition`
                ON `player_id`=`playerposition_player_id`
                WHERE `player_id`=$rd2
                ORDER BY `player_power_position` DESC
                LIMIT 2";
        $rd2_sql = f_igosja_mysqli_query($sql);

        if (0 != $rd2_sql->num_rows)
        {
            $rd2_array = $rd2_sql->fetch_all(MYSQLI_ASSOC);

            $power      = $power + $rd2_array[0]['player_power_real'];
            $position   = $position + $rd2_array[0]['player_power_position'];
        }
    }

    if (0 != $lw2)
    {
        $sql = "SELECT `player_power_real`,
                       ROUND(IF(`playerposition_position_id`=" . POSITION_LW . ", `player_power_real`, IF(`playerposition_position_id`=" . POSITION_C . ", `player_power_real`*0.9, IF(`playerposition_position_id`=" . POSITION_LD . ", `player_power_real`*0.9, `player_power_real`*0.8)))) AS `player_power_position`
                FROM `player`
                LEFT JOIN `playerposition`
                ON `player_id`=`playerposition_player_id`
                WHERE `player_id`=$lw2
                ORDER BY `player_power_position` DESC
                LIMIT 2";
        $lw2_sql = f_igosja_mysqli_query($sql);

        if (0 != $lw2_sql->num_rows)
        {
            $lw2_array = $lw2_sql->fetch_all(MYSQLI_ASSOC);

            $power      = $power + $lw2_array[0]['player_power_real'];
            $position   = $position + $lw2_array[0]['player_power_position'];
        }
    }

    if (0 != $c2)
    {
        $sql = "SELECT `player_power_real`,
                       ROUND(IF(`playerposition_position_id`=" . POSITION_C . ", `player_power_real`, IF(`playerposition_position_id`=" . POSITION_LW . ", `player_power_real`*0.9, IF(`playerposition_position_id`=" . POSITION_RW . ", `player_power_real`*0.9, `player_power_real`*0.8)))) AS `player_power_position`
                FROM `player`
                LEFT JOIN `playerposition`
                ON `player_id`=`playerposition_player_id`
                WHERE `player_id`=$c2
                ORDER BY `player_power_position` DESC
                LIMIT 2";
        $c2_sql = f_igosja_mysqli_query($sql);

        if (0 != $c2_sql->num_rows)
        {
            $c2_array = $c2_sql->fetch_all(MYSQLI_ASSOC);

            $power      = $power + $c2_array[0]['player_power_real'];
            $position   = $position + $c2_array[0]['player_power_position'];
        }
    }

    if (0 != $rw2)
    {
        $sql = "SELECT `player_power_real`,
                       ROUND(IF(`playerposition_position_id`=" . POSITION_RW . ", `player_power_real`, IF(`playerposition_position_id`=" . POSITION_C . ", `player_power_real`*0.9, IF(`playerposition_position_id`=" . POSITION_RD . ", `player_power_real`*0.9, `player_power_real`*0.8)))) AS `player_power_position`
                FROM `player`
                LEFT JOIN `playerposition`
                ON `player_id`=`playerposition_player_id`
                WHERE `player_id`=$rw2
                ORDER BY `player_power_position` DESC
                LIMIT 2";
        $rw2_sql = f_igosja_mysqli_query($sql);

        if (0 != $rw2_sql->num_rows)
        {
            $rw2_array = $rw2_sql->fetch_all(MYSQLI_ASSOC);

            $power      = $power + $rw2_array[0]['player_power_real'];
            $position   = $position + $rw2_array[0]['player_power_position'];
        }
    }

    if (0 != $ld3)
    {
        $sql = "SELECT `player_power_real`,
                       ROUND(IF(`playerposition_position_id`=" . POSITION_LD . ", `player_power_real`, IF(`playerposition_position_id`=" . POSITION_LW . ", `player_power_real`*0.9, IF(`playerposition_position_id`=" . POSITION_RD . ", `player_power_real`*0.9, `player_power_real`*0.8)))) AS `player_power_position`
                FROM `player`
                LEFT JOIN `playerposition`
                ON `player_id`=`playerposition_player_id`
                WHERE `player_id`=$ld3
                ORDER BY `player_power_position` DESC
                LIMIT 3";
        $ld3_sql = f_igosja_mysqli_query($sql);

        if (0 != $ld3_sql->num_rows)
        {
            $ld3_array = $ld3_sql->fetch_all(MYSQLI_ASSOC);

            $power      = $power + $ld3_array[0]['player_power_real'];
            $position   = $position + $ld3_array[0]['player_power_position'];
        }
    }

    if (0 != $rd3)
    {
        $sql = "SELECT `player_power_real`,
                       ROUND(IF(`playerposition_position_id`=" . POSITION_RD . ", `player_power_real`, IF(`playerposition_position_id`=" . POSITION_RW . ", `player_power_real`*0.9, IF(`playerposition_position_id`=" . POSITION_LD . ", `player_power_real`*0.9, `player_power_real`*0.8)))) AS `player_power_position`
                FROM `player`
                LEFT JOIN `playerposition`
                ON `player_id`=`playerposition_player_id`
                WHERE `player_id`=$rd3
                ORDER BY `player_power_position` DESC
                LIMIT 3";
        $rd3_sql = f_igosja_mysqli_query($sql);

        if (0 != $rd3_sql->num_rows)
        {
            $rd3_array = $rd3_sql->fetch_all(MYSQLI_ASSOC);

            $power      = $power + $rd3_array[0]['player_power_real'];
            $position   = $position + $rd3_array[0]['player_power_position'];
        }
    }

    if (0 != $lw3)
    {
        $sql = "SELECT `player_power_real`,
                       ROUND(IF(`playerposition_position_id`=" . POSITION_LW . ", `player_power_real`, IF(`playerposition_position_id`=" . POSITION_C . ", `player_power_real`*0.9, IF(`playerposition_position_id`=" . POSITION_LD . ", `player_power_real`*0.9, `player_power_real`*0.8)))) AS `player_power_position`
                FROM `player`
                LEFT JOIN `playerposition`
                ON `player_id`=`playerposition_player_id`
                WHERE `player_id`=$lw3
                ORDER BY `player_power_position` DESC
                LIMIT 3";
        $lw3_sql = f_igosja_mysqli_query($sql);

        if (0 != $lw3_sql->num_rows)
        {
            $lw3_array = $lw3_sql->fetch_all(MYSQLI_ASSOC);

            $power      = $power + $lw3_array[0]['player_power_real'];
            $position   = $position + $lw3_array[0]['player_power_position'];
        }
    }

    if (0 != $c3)
    {
        $sql = "SELECT `player_power_real`,
                       ROUND(IF(`playerposition_position_id`=" . POSITION_C . ", `player_power_real`, IF(`playerposition_position_id`=" . POSITION_LW . ", `player_power_real`*0.9, IF(`playerposition_position_id`=" . POSITION_RW . ", `player_power_real`*0.9, `player_power_real`*0.8)))) AS `player_power_position`
                FROM `player`
                LEFT JOIN `playerposition`
                ON `player_id`=`playerposition_player_id`
                WHERE `player_id`=$c3
                ORDER BY `player_power_position` DESC
                LIMIT 3";
        $c3_sql = f_igosja_mysqli_query($sql);

        if (0 != $c3_sql->num_rows)
        {
            $c3_array = $c3_sql->fetch_all(MYSQLI_ASSOC);

            $power      = $power + $c3_array[0]['player_power_real'];
            $position   = $position + $c3_array[0]['player_power_position'];
        }
    }

    if (0 != $rw3)
    {
        $sql = "SELECT `player_power_real`,
                       ROUND(IF(`playerposition_position_id`=" . POSITION_RW . ", `player_power_real`, IF(`playerposition_position_id`=" . POSITION_C . ", `player_power_real`*0.9, IF(`playerposition_position_id`=" . POSITION_RD . ", `player_power_real`*0.9, `player_power_real`*0.8)))) AS `player_power_position`
                FROM `player`
                LEFT JOIN `playerposition`
                ON `player_id`=`playerposition_player_id`
                WHERE `player_id`=$rw3
                ORDER BY `player_power_position` DESC
                LIMIT 3";
        $rw3_sql = f_igosja_mysqli_query($sql);

        if (0 != $rw3_sql->num_rows)
        {
            $rw3_array = $rw3_sql->fetch_all(MYSQLI_ASSOC);

            $power      = $power + $rw3_array[0]['player_power_real'];
            $position   = $position + $rw3_array[0]['player_power_position'];
        }
    }

    $sql = "SELECT `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_player_1_id`=$ld1
            AND `teamwork_player_2_id`=$rd1)
            OR (`teamwork_player_1_id`=$rd1
            AND `teamwork_player_2_id`=$ld1)
            LIMIT 1";
    $teamwork_sql = f_igosja_mysqli_query($sql);

    if ($teamwork_sql->num_rows)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_1= $teamwork_1+ $teamwork_array[0]['teamwork_value'];
    }

    $sql = "SELECT `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_player_1_id`=$ld1
            AND `teamwork_player_2_id`=$lw1)
            OR (`teamwork_player_1_id`=$lw1
            AND `teamwork_player_2_id`=$ld1)
            LIMIT 1";
    $teamwork_sql = f_igosja_mysqli_query($sql);

    if ($teamwork_sql->num_rows)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_1= $teamwork_1+ $teamwork_array[0]['teamwork_value'];
    }

    $sql = "SELECT `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_player_1_id`=$ld1
            AND `teamwork_player_2_id`=$c1)
            OR (`teamwork_player_1_id`=$c1
            AND `teamwork_player_2_id`=$ld1)
            LIMIT 1";
    $teamwork_sql = f_igosja_mysqli_query($sql);

    if ($teamwork_sql->num_rows)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_1= $teamwork_1+ $teamwork_array[0]['teamwork_value'];
    }

    $sql = "SELECT `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_player_1_id`=$ld1
            AND `teamwork_player_2_id`=$rw1)
            OR (`teamwork_player_1_id`=$rw1
            AND `teamwork_player_2_id`=$ld1)
            LIMIT 1";
    $teamwork_sql = f_igosja_mysqli_query($sql);

    if ($teamwork_sql->num_rows)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_1= $teamwork_1+ $teamwork_array[0]['teamwork_value'];
    }

    $sql = "SELECT `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_player_1_id`=$rd1
            AND `teamwork_player_2_id`=$lw1)
            OR (`teamwork_player_1_id`=$lw1
            AND `teamwork_player_2_id`=$rd1)
            LIMIT 1";
    $teamwork_sql = f_igosja_mysqli_query($sql);

    if ($teamwork_sql->num_rows)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_1= $teamwork_1+ $teamwork_array[0]['teamwork_value'];
    }

    $sql = "SELECT `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_player_1_id`=$rd1
            AND `teamwork_player_2_id`=$c1)
            OR (`teamwork_player_1_id`=$c1
            AND `teamwork_player_2_id`=$rd1)
            LIMIT 1";
    $teamwork_sql = f_igosja_mysqli_query($sql);

    if ($teamwork_sql->num_rows)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_1= $teamwork_1+ $teamwork_array[0]['teamwork_value'];
    }

    $sql = "SELECT `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_player_1_id`=$rd1
            AND `teamwork_player_2_id`=$rw1)
            OR (`teamwork_player_1_id`=$rw1
            AND `teamwork_player_2_id`=$rd1)
            LIMIT 1";
    $teamwork_sql = f_igosja_mysqli_query($sql);

    if ($teamwork_sql->num_rows)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_1= $teamwork_1+ $teamwork_array[0]['teamwork_value'];
    }

    $sql = "SELECT `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_player_1_id`=$lw1
            AND `teamwork_player_2_id`=$c1)
            OR (`teamwork_player_1_id`=$c1
            AND `teamwork_player_2_id`=$lw1)
            LIMIT 1";
    $teamwork_sql = f_igosja_mysqli_query($sql);

    if ($teamwork_sql->num_rows)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_1= $teamwork_1+ $teamwork_array[0]['teamwork_value'];
    }

    $sql = "SELECT `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_player_1_id`=$lw1
            AND `teamwork_player_2_id`=$rw1)
            OR (`teamwork_player_1_id`=$rw1
            AND `teamwork_player_2_id`=$lw1)
            LIMIT 1";
    $teamwork_sql = f_igosja_mysqli_query($sql);

    if ($teamwork_sql->num_rows)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_1= $teamwork_1+ $teamwork_array[0]['teamwork_value'];
    }

    $sql = "SELECT `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_player_1_id`=$lw1
            AND `teamwork_player_2_id`=$rw1)
            OR (`teamwork_player_1_id`=$rw1
            AND `teamwork_player_2_id`=$lw1)
            LIMIT 1";
    $teamwork_sql = f_igosja_mysqli_query($sql);

    if ($teamwork_sql->num_rows)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_1= $teamwork_1+ $teamwork_array[0]['teamwork_value'];
    }

    $sql = "SELECT `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_player_1_id`=$ld2
            AND `teamwork_player_2_id`=$rd2)
            OR (`teamwork_player_1_id`=$rd2
            AND `teamwork_player_2_id`=$ld2)
            LIMIT 1";
    $teamwork_sql = f_igosja_mysqli_query($sql);

    if ($teamwork_sql->num_rows)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_2 = $teamwork_2 + $teamwork_array[0]['teamwork_value'];
    }

    $sql = "SELECT `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_player_1_id`=$ld2
            AND `teamwork_player_2_id`=$lw2)
            OR (`teamwork_player_1_id`=$lw2
            AND `teamwork_player_2_id`=$ld2)
            LIMIT 1";
    $teamwork_sql = f_igosja_mysqli_query($sql);

    if ($teamwork_sql->num_rows)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_2 = $teamwork_2 + $teamwork_array[0]['teamwork_value'];
    }

    $sql = "SELECT `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_player_1_id`=$ld2
            AND `teamwork_player_2_id`=$c2)
            OR (`teamwork_player_1_id`=$c2
            AND `teamwork_player_2_id`=$ld2)
            LIMIT 1";
    $teamwork_sql = f_igosja_mysqli_query($sql);

    if ($teamwork_sql->num_rows)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_2 = $teamwork_2 + $teamwork_array[0]['teamwork_value'];
    }

    $sql = "SELECT `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_player_1_id`=$ld2
            AND `teamwork_player_2_id`=$rw2)
            OR (`teamwork_player_1_id`=$rw2
            AND `teamwork_player_2_id`=$ld2)
            LIMIT 1";
    $teamwork_sql = f_igosja_mysqli_query($sql);

    if ($teamwork_sql->num_rows)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_2 = $teamwork_2 + $teamwork_array[0]['teamwork_value'];
    }

    $sql = "SELECT `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_player_1_id`=$rd2
            AND `teamwork_player_2_id`=$lw2)
            OR (`teamwork_player_1_id`=$lw2
            AND `teamwork_player_2_id`=$rd2)
            LIMIT 1";
    $teamwork_sql = f_igosja_mysqli_query($sql);

    if ($teamwork_sql->num_rows)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_2 = $teamwork_2 + $teamwork_array[0]['teamwork_value'];
    }

    $sql = "SELECT `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_player_1_id`=$rd2
            AND `teamwork_player_2_id`=$c2)
            OR (`teamwork_player_1_id`=$c2
            AND `teamwork_player_2_id`=$rd2)
            LIMIT 1";
    $teamwork_sql = f_igosja_mysqli_query($sql);

    if ($teamwork_sql->num_rows)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_2 = $teamwork_2 + $teamwork_array[0]['teamwork_value'];
    }

    $sql = "SELECT `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_player_1_id`=$rd2
            AND `teamwork_player_2_id`=$rw2)
            OR (`teamwork_player_1_id`=$rw2
            AND `teamwork_player_2_id`=$rd2)
            LIMIT 1";
    $teamwork_sql = f_igosja_mysqli_query($sql);

    if ($teamwork_sql->num_rows)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_2 = $teamwork_2 + $teamwork_array[0]['teamwork_value'];
    }

    $sql = "SELECT `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_player_1_id`=$lw2
            AND `teamwork_player_2_id`=$c2)
            OR (`teamwork_player_1_id`=$c2
            AND `teamwork_player_2_id`=$lw2)
            LIMIT 1";
    $teamwork_sql = f_igosja_mysqli_query($sql);

    if ($teamwork_sql->num_rows)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_2 = $teamwork_2 + $teamwork_array[0]['teamwork_value'];
    }

    $sql = "SELECT `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_player_1_id`=$lw2
            AND `teamwork_player_2_id`=$rw2)
            OR (`teamwork_player_1_id`=$rw2
            AND `teamwork_player_2_id`=$lw2)
            LIMIT 1";
    $teamwork_sql = f_igosja_mysqli_query($sql);

    if ($teamwork_sql->num_rows)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_2 = $teamwork_2 + $teamwork_array[0]['teamwork_value'];
    }

    $sql = "SELECT `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_player_1_id`=$lw2
            AND `teamwork_player_2_id`=$rw2)
            OR (`teamwork_player_1_id`=$rw2
            AND `teamwork_player_2_id`=$lw2)
            LIMIT 1";
    $teamwork_sql = f_igosja_mysqli_query($sql);

    if ($teamwork_sql->num_rows)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_2 = $teamwork_2 + $teamwork_array[0]['teamwork_value'];
    }

    $sql = "SELECT `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_player_1_id`=$ld3
            AND `teamwork_player_2_id`=$rd3)
            OR (`teamwork_player_1_id`=$rd3
            AND `teamwork_player_2_id`=$ld3)
            LIMIT 1";
    $teamwork_sql = f_igosja_mysqli_query($sql);

    if ($teamwork_sql->num_rows)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_3 = $teamwork_3 + $teamwork_array[0]['teamwork_value'];
    }

    $sql = "SELECT `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_player_1_id`=$ld3
            AND `teamwork_player_2_id`=$lw3)
            OR (`teamwork_player_1_id`=$lw3
            AND `teamwork_player_2_id`=$ld3)
            LIMIT 1";
    $teamwork_sql = f_igosja_mysqli_query($sql);

    if ($teamwork_sql->num_rows)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_3 = $teamwork_3 + $teamwork_array[0]['teamwork_value'];
    }

    $sql = "SELECT `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_player_1_id`=$ld3
            AND `teamwork_player_2_id`=$c3)
            OR (`teamwork_player_1_id`=$c3
            AND `teamwork_player_2_id`=$ld3)
            LIMIT 1";
    $teamwork_sql = f_igosja_mysqli_query($sql);

    if ($teamwork_sql->num_rows)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_3 = $teamwork_3 + $teamwork_array[0]['teamwork_value'];
    }

    $sql = "SELECT `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_player_1_id`=$ld3
            AND `teamwork_player_2_id`=$rw3)
            OR (`teamwork_player_1_id`=$rw3
            AND `teamwork_player_2_id`=$ld3)
            LIMIT 1";
    $teamwork_sql = f_igosja_mysqli_query($sql);

    if ($teamwork_sql->num_rows)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_3 = $teamwork_3 + $teamwork_array[0]['teamwork_value'];
    }

    $sql = "SELECT `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_player_1_id`=$rd3
            AND `teamwork_player_2_id`=$lw3)
            OR (`teamwork_player_1_id`=$lw3
            AND `teamwork_player_2_id`=$rd3)
            LIMIT 1";
    $teamwork_sql = f_igosja_mysqli_query($sql);

    if ($teamwork_sql->num_rows)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_3 = $teamwork_3 + $teamwork_array[0]['teamwork_value'];
    }

    $sql = "SELECT `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_player_1_id`=$rd3
            AND `teamwork_player_2_id`=$c3)
            OR (`teamwork_player_1_id`=$c3
            AND `teamwork_player_2_id`=$rd3)
            LIMIT 1";
    $teamwork_sql = f_igosja_mysqli_query($sql);

    if ($teamwork_sql->num_rows)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_3 = $teamwork_3 + $teamwork_array[0]['teamwork_value'];
    }

    $sql = "SELECT `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_player_1_id`=$rd3
            AND `teamwork_player_2_id`=$rw3)
            OR (`teamwork_player_1_id`=$rw3
            AND `teamwork_player_2_id`=$rd3)
            LIMIT 1";
    $teamwork_sql = f_igosja_mysqli_query($sql);

    if ($teamwork_sql->num_rows)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_3 = $teamwork_3 + $teamwork_array[0]['teamwork_value'];
    }

    $sql = "SELECT `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_player_1_id`=$lw3
            AND `teamwork_player_2_id`=$c3)
            OR (`teamwork_player_1_id`=$c3
            AND `teamwork_player_2_id`=$lw3)
            LIMIT 1";
    $teamwork_sql = f_igosja_mysqli_query($sql);

    if ($teamwork_sql->num_rows)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_3 = $teamwork_3 + $teamwork_array[0]['teamwork_value'];
    }

    $sql = "SELECT `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_player_1_id`=$lw3
            AND `teamwork_player_2_id`=$rw3)
            OR (`teamwork_player_1_id`=$rw3
            AND `teamwork_player_2_id`=$lw3)
            LIMIT 1";
    $teamwork_sql = f_igosja_mysqli_query($sql);

    if ($teamwork_sql->num_rows)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_3 = $teamwork_3 + $teamwork_array[0]['teamwork_value'];
    }

    $sql = "SELECT `teamwork_value`
            FROM `teamwork`
            WHERE (`teamwork_player_1_id`=$lw3
            AND `teamwork_player_2_id`=$rw3)
            OR (`teamwork_player_1_id`=$rw3
            AND `teamwork_player_2_id`=$lw3)
            LIMIT 1";
    $teamwork_sql = f_igosja_mysqli_query($sql);

    if ($teamwork_sql->num_rows)
    {
        $teamwork_array = $teamwork_sql->fetch_all(MYSQLI_ASSOC);

        $teamwork_3 = $teamwork_3 + $teamwork_array[0]['teamwork_value'];
    }

    if (0 == $power)
    {
        $power = 1;
    }

    $position = round($position / $power * 100);

    $sql = "SELECT `team_power_v`
            FROM `team`
            WHERE `team_id`=$auth_team_id
            LIMIT 1";
    $team_sql = f_igosja_mysqli_query($sql);

    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

    $lineup = round($power / $team_array[0]['team_power_v'] * 100);

    $teamwork_1 = round($teamwork_1 / 10);
    $teamwork_2 = round($teamwork_2 / 10);
    $teamwork_3 = round($teamwork_3 / 10);

    $result = array(
        'power' => $power,
        'position' => $position,
        'lineup' => $lineup,
        'teamwork_1' => $teamwork_1,
        'teamwork_2' => $teamwork_2,
        'teamwork_3' => $teamwork_3,
    );
}

print json_encode($result);
exit;