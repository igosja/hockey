<?php

function f_igosja_generator_game_result()
//Генерируем результат матча
{
    $sql = "SELECT `game_id`,
                   `game_bonus_home`,
                   `game_guest_team_id`,
                   `game_home_team_id`,
                   `game_stadium_capacity`,
                   `game_visitor`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `tournamenttype`
            ON `shedule_tournamenttype_id`=`tournamenttype_id`
            LEFT JOIN `stage`
            ON `shedule_stage_id`=`stage_id`
            LEFT JOIN `team` AS `guest_team`
            ON `game_guest_team_id`=`guest_team`.`team_id`
            LEFT JOIN `team` AS `home_team`
            ON `game_home_team_id`=`home_team`.`team_id`
            LEFT JOIN `stadium`
            ON `game_stadium_id`=`stadium_id`
            WHERE `game_played`='0'
            AND FROM_UNIXTIME(`shedule_date`, '%Y-%m-%d')=CURDATE()
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $game_array = $game_sql->fetch_all(1);

    foreach ($game_array as $game)
    {
        $home_score         = 0;
        $home_score_1       = 0;
        $home_score_2       = 0;
        $home_score_3       = 0;
        $home_shot          = 0;
        $home_shot_1        = 0;
        $home_shot_2        = 0;
        $home_shot_3        = 0;
        $home_penalty       = 0;
        $home_penalty_1     = 0;
        $home_penalty_2     = 0;
        $home_penalty_3     = 0;
        $guest_score        = 0;
        $guest_score_1      = 0;
        $guest_score_2      = 0;
        $guest_score_3      = 0;
        $guest_shot         = 0;
        $guest_shot_1       = 0;
        $guest_shot_2       = 0;
        $guest_shot_3       = 0;
        $guest_penalty      = 0;
        $guest_penalty_1    = 0;
        $guest_penalty_2    = 0;
        $guest_penalty_3    = 0;

        $game_id                = $game['game_id'];
        $game_bonus_home        = $game['game_bonus_home'];
        $game_guest_team_id     = $game['game_guest_team_id'];
        $game_home_team_id      = $game['game_home_team_id'];
        $game_stadium_capacity  = $game['game_stadium_capacity'];
        $game_visitor           = $game['game_visitor'];

        $sql = "SELECT `player_power_real`
                FROM `lineup`
                LEFT JOIN `player`
                ON `lineup_player_id`=`player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$game_guest_team_id'
                ORDER BY `lineup_line_id` ASC, `lineup_position_id` ASC";
        $guest_lineup_sql = f_igosja_mysqli_query($sql);

        $guest_lineup_array = $guest_lineup_sql->fetch_all(1);

        $guest_player_gk    = $guest_lineup_array[0]['player_power_real'];
        $guest_player_1_ld  = $guest_lineup_array[1]['player_power_real'];
        $guest_player_1_rd  = $guest_lineup_array[2]['player_power_real'];
        $guest_player_1_lf  = $guest_lineup_array[3]['player_power_real'];
        $guest_player_1_c   = $guest_lineup_array[4]['player_power_real'];
        $guest_player_1_rf  = $guest_lineup_array[5]['player_power_real'];
        $guest_player_2_ld  = $guest_lineup_array[6]['player_power_real'];
        $guest_player_2_rd  = $guest_lineup_array[7]['player_power_real'];
        $guest_player_2_lf  = $guest_lineup_array[8]['player_power_real'];
        $guest_player_2_c   = $guest_lineup_array[9]['player_power_real'];
        $guest_player_2_rf  = $guest_lineup_array[10]['player_power_real'];
        $guest_player_3_ld  = $guest_lineup_array[11]['player_power_real'];
        $guest_player_3_rd  = $guest_lineup_array[12]['player_power_real'];
        $guest_player_3_lf  = $guest_lineup_array[13]['player_power_real'];
        $guest_player_3_c   = $guest_lineup_array[14]['player_power_real'];
        $guest_player_3_rf  = $guest_lineup_array[15]['player_power_real'];

        $guest_gk           = $guest_player_gk;
        $guest_defence_1    = $guest_player_1_ld + $guest_player_1_rd;
        $guest_forward_1    = $guest_player_1_lf + $guest_player_1_c + $guest_player_1_rf;
        $guest_defence_2    = $guest_player_2_ld + $guest_player_2_rd;
        $guest_forward_2    = $guest_player_2_lf + $guest_player_2_c + $guest_player_2_rf;
        $guest_defence_3    = $guest_player_3_ld + $guest_player_3_rd;
        $guest_forward_3    = $guest_player_3_lf + $guest_player_3_c + $guest_player_3_rf;
        $guest_power        = $guest_gk + $guest_defence_1 + $guest_forward_1 + $guest_defence_2 + $guest_forward_2 + $guest_defence_3 + $guest_forward_3;

        $sql = "SELECT `player_power_real`
                FROM `lineup`
                LEFT JOIN `player`
                ON `lineup_player_id`=`player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$game_home_team_id'
                ORDER BY `lineup_line_id` ASC, `lineup_position_id` ASC";
        $home_lineup_sql = f_igosja_mysqli_query($sql);

        $home_lineup_array = $home_lineup_sql->fetch_all(1);

        $home_player_gk     = $home_lineup_array[0]['player_power_real'];
        $home_player_1_ld   = $home_lineup_array[1]['player_power_real'];
        $home_player_1_rd   = $home_lineup_array[2]['player_power_real'];
        $home_player_1_lf   = $home_lineup_array[3]['player_power_real'];
        $home_player_1_c    = $home_lineup_array[4]['player_power_real'];
        $home_player_1_rf   = $home_lineup_array[5]['player_power_real'];
        $home_player_2_ld   = $home_lineup_array[6]['player_power_real'];
        $home_player_2_rd   = $home_lineup_array[7]['player_power_real'];
        $home_player_2_lf   = $home_lineup_array[8]['player_power_real'];
        $home_player_2_c    = $home_lineup_array[9]['player_power_real'];
        $home_player_2_rf   = $home_lineup_array[10]['player_power_real'];
        $home_player_3_ld   = $home_lineup_array[11]['player_power_real'];
        $home_player_3_rd   = $home_lineup_array[12]['player_power_real'];
        $home_player_3_lf   = $home_lineup_array[13]['player_power_real'];
        $home_player_3_c    = $home_lineup_array[14]['player_power_real'];
        $home_player_3_rf   = $home_lineup_array[15]['player_power_real'];

        $home_gk            = $home_player_gk;
        $home_defence_1     = $home_player_1_ld + $home_player_1_rd;
        $home_forward_1     = $home_player_1_lf + $home_player_1_c + $home_player_1_rf;
        $home_defence_2     = $home_player_2_ld + $home_player_2_rd;
        $home_forward_2     = $home_player_2_lf + $home_player_2_c + $home_player_2_rf;
        $home_defence_3     = $home_player_3_ld + $home_player_3_rd;
        $home_forward_3     = $home_player_3_lf + $home_player_3_c + $home_player_3_rf;
        $home_power         = $home_gk + $home_defence_1 + $home_forward_1 + $home_defence_2 + $home_forward_2 + $home_defence_3 + $home_forward_3;

        for ($minute=0; $minute<60; $minute++)
        {
            if (0 == $minute % 3)
            {
                $home_defence   = $home_defence_1;
                $home_forward   = $home_forward_1;
                $guest_defence  = $guest_defence_1;
                $guest_forward  = $guest_forward_1;
            }
            elseif (1 == $minute % 3)
            {
                $home_defence   = $home_defence_2;
                $home_forward   = $home_forward_2;
                $guest_defence  = $guest_defence_2;
                $guest_forward  = $guest_forward_2;
            }
            else
            {
                $home_defence   = $home_defence_3;
                $home_forward   = $home_forward_3;
                $guest_defence  = $guest_defence_3;
                $guest_forward  = $guest_forward_3;
            }

            if (rand(0, 40) >= 37)
            {
                $home_current_penalty = 1;

                $home_penalty++;

                if (20 > $minute)
                {
                    $home_penalty_1++;
                }
                elseif (40 > $minute)
                {
                    $home_penalty_2++;
                }
                else
                {
                    $home_penalty_3++;
                }
            }
            else
            {
                $home_current_penalty = 0;
            }

            if (rand(0, 40) >= 37)
            {
                $guest_current_penalty = 1;

                $guest_penalty++;

                if (20 > $minute)
                {
                    $guest_penalty_1++;
                }
                elseif (40 > $minute)
                {
                    $guest_penalty_2++;
                }
                else
                {
                    $guest_penalty_3++;
                }
            }
            else
            {
                $guest_current_penalty = 0;
            }

            if (rand(0, $home_defence / (1 + $home_current_penalty)) > rand(0, $guest_forward / (2 + $guest_current_penalty)))
            {
                if (rand(0, $home_forward / (1 + $home_current_penalty)) > rand(0, $guest_defence / (2 + $guest_current_penalty)))
                {
                    $home_shot++;

                    if (20 > $minute)
                    {
                        $home_shot_1++;
                    }
                    elseif (40 > $minute)
                    {
                        $home_shot_2++;
                    }
                    else
                    {
                        $home_shot_3++;
                    }

                    $player = rand(1, 5);

                    if (1 == $player)
                    {
                        if (0 == $minute % 3)
                        {
                            $player_shot = $home_player_1_ld;
                        }
                        elseif (1 == $minute % 3)
                        {
                            $player_shot = $home_player_2_ld;
                        }
                        else
                        {
                            $player_shot = $home_player_3_ld;
                        }
                    }
                    elseif (2 == $player)
                    {
                        if (0 == $minute % 3)
                        {
                            $player_shot = $home_player_1_rd;
                        }
                        elseif (1 == $minute % 3)
                        {
                            $player_shot = $home_player_2_rd;
                        }
                        else
                        {
                            $player_shot = $home_player_3_rd;
                        }
                    }
                    elseif (3 == $player)
                    {
                        if (0 == $minute % 3)
                        {
                            $player_shot = $home_player_1_lf;
                        }
                        elseif (1 == $minute % 3)
                        {
                            $player_shot = $home_player_2_lf;
                        }
                        else
                        {
                            $player_shot = $home_player_3_lf;
                        }
                    }
                    elseif (4 == $player)
                    {
                        if (0 == $minute % 3)
                        {
                            $player_shot = $home_player_1_c;
                        }
                        elseif (1 == $minute % 3)
                        {
                            $player_shot = $home_player_2_c;
                        }
                        else
                        {
                            $player_shot = $home_player_3_c;
                        }
                    }
                    else
                    {
                        if (0 == $minute % 3)
                        {
                            $player_shot = $home_player_1_rf;
                        }
                        elseif (1 == $minute % 3)
                        {
                            $player_shot = $home_player_2_rf;
                        }
                        else
                        {
                            $player_shot = $home_player_3_rf;
                        }
                    }

                    if (rand(0, $player_shot) > rand(0, $guest_gk * 5))
                    {
                        $home_score++;

                        if (20 > $minute)
                        {
                            $home_score_1++;
                        }
                        elseif (40 > $minute)
                        {
                            $home_score_2++;
                        }
                        else
                        {
                            $home_score_3++;
                        }
                    }
                }
            }

            if (rand(0, $guest_defence / (1 + $guest_current_penalty)) > rand(0, $home_forward / (2 + $home_current_penalty)))
            {
                if (rand(0, $guest_forward / (1 + $guest_current_penalty)) > rand(0, $home_defence / (2 + $home_current_penalty)))
                {
                    $guest_shot++;

                    if (20 > $minute)
                    {
                        $guest_shot_1++;
                    }
                    elseif (40 > $minute)
                    {
                        $guest_shot_2++;
                    }
                    else
                    {
                        $guest_shot_3++;
                    }

                    $player = rand(1, 5);

                    if (1 == $player)
                    {
                        if (0 == $minute % 3)
                        {
                            $player_shot = $guest_player_1_ld;
                        }
                        elseif (1 == $minute % 3)
                        {
                            $player_shot = $guest_player_2_ld;
                        }
                        else
                        {
                            $player_shot = $guest_player_3_ld;
                        }
                    }
                    elseif (2 == $player)
                    {
                        if (0 == $minute % 3)
                        {
                            $player_shot = $guest_player_1_rd;
                        }
                        elseif (1 == $minute % 3)
                        {
                            $player_shot = $guest_player_2_rd;
                        }
                        else
                        {
                            $player_shot = $guest_player_3_rd;
                        }
                    }
                    elseif (3 == $player)
                    {
                        if (0 == $minute % 3)
                        {
                            $player_shot = $guest_player_1_lf;
                        }
                        elseif (1 == $minute % 3)
                        {
                            $player_shot = $guest_player_2_lf;
                        }
                        else
                        {
                            $player_shot = $guest_player_3_lf;
                        }
                    }
                    elseif (4 == $player)
                    {
                        if (0 == $minute % 3)
                        {
                            $player_shot = $guest_player_1_c;
                        }
                        elseif (1 == $minute % 3)
                        {
                            $player_shot = $guest_player_2_c;
                        }
                        else
                        {
                            $player_shot = $guest_player_3_c;
                        }
                    }
                    else
                    {
                        if (0 == $minute % 3)
                        {
                            $player_shot = $guest_player_1_rf;
                        }
                        elseif (1 == $minute % 3)
                        {
                            $player_shot = $guest_player_2_rf;
                        }
                        else
                        {
                            $player_shot = $guest_player_3_rf;
                        }
                    }

                    if (rand(0, $player_shot) > rand(0, $home_gk * 5))
                    {
                        $guest_score++;

                        if (20 > $minute)
                        {
                            $guest_score_1++;
                        }
                        elseif (40 > $minute)
                        {
                            $guest_score_2++;
                        }
                        else
                        {
                            $guest_score_3++;
                        }
                    }
                }
            }
        }

        $sql = "UPDATE `game`
                SET `game_guest_penalty`='$guest_penalty'*'2',
                    `game_guest_penalty_1`='$guest_penalty_1'*'2',
                    `game_guest_penalty_2`='$guest_penalty_2'*'2',
                    `game_guest_penalty_3`='$guest_penalty_3'*'2',
                    `game_guest_power`='$guest_power',
                    `game_guest_score`='$guest_score',
                    `game_guest_score_1`='$guest_score_1',
                    `game_guest_score_2`='$guest_score_2',
                    `game_guest_score_3`='$guest_score_3',
                    `game_guest_shot`='$guest_shot',
                    `game_guest_shot_1`='$guest_shot_1',
                    `game_guest_shot_2`='$guest_shot_2',
                    `game_guest_shot_3`='$guest_shot_3',
                    `game_home_penalty`='$home_penalty'*'2',
                    `game_home_penalty_1`='$home_penalty_1'*'2',
                    `game_home_penalty_2`='$home_penalty_2'*'2',
                    `game_home_penalty_3`='$home_penalty_3'*'2',
                    `game_home_power`='$home_power',
                    `game_home_score`='$home_score',
                    `game_home_score_1`='$home_score_1',
                    `game_home_score_2`='$home_score_2',
                    `game_home_score_3`='$home_score_3',
                    `game_home_shot`='$home_shot',
                    `game_home_shot_1`='$home_shot_1',
                    `game_home_shot_2`='$home_shot_2',
                    `game_home_shot_3`='$home_shot_3',
                    `game_played`='1'
                WHERE `game_id`='$game_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        usleep(1);

        print '.';
        flush();
    }
}