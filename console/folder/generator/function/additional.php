<?php

function f_igosja_get_home_defence()
{
    global $home_defence_1;
    global $home_defence_2;
    global $home_defence_3;
    global $minute;

    if (0 == $minute % 3)
    {
        $home_defence = $home_defence_1;
    }
    elseif (1 == $minute % 3)
    {
        $home_defence = $home_defence_2;
    }
    else
    {
        $home_defence = $home_defence_3;
    }

    return $home_defence;
}

function f_igosja_get_home_forward()
{
    global $home_forward_1;
    global $home_forward_2;
    global $home_forward_3;
    global $minute;

    if (0 == $minute % 3)
    {
        $home_forward = $home_forward_1;
    }
    elseif (1 == $minute % 3)
    {
        $home_forward = $home_forward_2;
    }
    else
    {
        $home_forward = $home_forward_3;
    }

    return $home_forward;
}

function f_igosja_get_guest_defence()
{
    global $guest_defence_1;
    global $guest_defence_2;
    global $guest_defence_3;
    global $minute;

    if (0 == $minute % 3)
    {
        $guest_defence = $guest_defence_1;
    }
    elseif (1 == $minute % 3)
    {
        $guest_defence = $guest_defence_2;
    }
    else
    {
        $guest_defence = $guest_defence_3;
    }

    return $guest_defence;
}

function f_igosja_get_guest_forward()
{
    global $guest_forward_1;
    global $guest_forward_2;
    global $guest_forward_3;
    global $minute;

    if (0 == $minute % 3)
    {
        $guest_forward = $guest_forward_1;
    }
    elseif (1 == $minute % 3)
    {
        $guest_forward = $guest_forward_2;
    }
    else
    {
        $guest_forward = $guest_forward_3;
    }

    return $guest_forward;
}

function f_igosja_home_player_penalty_increase($player)
{
    global $home_c_1_penalty;
    global $home_c_2_penalty;
    global $home_c_3_penalty;
    global $home_ld_1_penalty;
    global $home_ld_2_penalty;
    global $home_ld_3_penalty;
    global $home_lf_1_penalty;
    global $home_lf_2_penalty;
    global $home_lf_3_penalty;
    global $home_rd_1_penalty;
    global $home_rd_2_penalty;
    global $home_rd_3_penalty;
    global $home_rf_1_penalty;
    global $home_rf_2_penalty;
    global $home_rf_3_penalty;
    global $minute;


    if (1 == $player)
    {
        if (0 == $minute % 3)
        {
            $home_ld_1_penalty++;
        }
        elseif (1 == $minute % 3)
        {
            $home_ld_2_penalty++;
        }
        else
        {
            $home_ld_3_penalty++;
        }
    }
    elseif (2 == $player)
    {
        if (0 == $minute % 3)
        {
            $home_rd_1_penalty++;
        }
        elseif (1 == $minute % 3)
        {
            $home_rd_2_penalty++;
        }
        else
        {
            $home_rd_3_penalty++;
        }
    }
    elseif (3 == $player)
    {
        if (0 == $minute % 3)
        {
            $home_lf_1_penalty++;
        }
        elseif (1 == $minute % 3)
        {
            $home_lf_2_penalty++;
        }
        else
        {
            $home_lf_3_penalty++;
        }
    }
    elseif (4 == $player)
    {
        if (0 == $minute % 3)
        {
            $home_c_1_penalty++;
        }
        elseif (1 == $minute % 3)
        {
            $home_c_2_penalty++;
        }
        else
        {
            $home_c_3_penalty++;
        }
    }
    else
    {
        if (0 == $minute % 3)
        {
            $home_rf_1_penalty++;
        }
        elseif (1 == $minute % 3)
        {
            $home_rf_2_penalty++;
        }
        else
        {
            $home_rf_3_penalty++;
        }
    }
}

function f_igosja_guest_player_penalty_increase($player)
{
    global $guest_c_1_penalty;
    global $guest_c_2_penalty;
    global $guest_c_3_penalty;
    global $guest_ld_1_penalty;
    global $guest_ld_2_penalty;
    global $guest_ld_3_penalty;
    global $guest_lf_1_penalty;
    global $guest_lf_2_penalty;
    global $guest_lf_3_penalty;
    global $guest_rd_1_penalty;
    global $guest_rd_2_penalty;
    global $guest_rd_3_penalty;
    global $guest_rf_1_penalty;
    global $guest_rf_2_penalty;
    global $guest_rf_3_penalty;
    global $minute;


    if (1 == $player)
    {
        if (0 == $minute % 3)
        {
            $guest_ld_1_penalty++;
        }
        elseif (1 == $minute % 3)
        {
            $guest_ld_2_penalty++;
        }
        else
        {
            $guest_ld_3_penalty++;
        }
    }
    elseif (2 == $player)
    {
        if (0 == $minute % 3)
        {
            $guest_rd_1_penalty++;
        }
        elseif (1 == $minute % 3)
        {
            $guest_rd_2_penalty++;
        }
        else
        {
            $guest_rd_3_penalty++;
        }
    }
    elseif (3 == $player)
    {
        if (0 == $minute % 3)
        {
            $guest_lf_1_penalty++;
        }
        elseif (1 == $minute % 3)
        {
            $guest_lf_2_penalty++;
        }
        else
        {
            $guest_lf_3_penalty++;
        }
    }
    elseif (4 == $player)
    {
        if (0 == $minute % 3)
        {
            $guest_c_1_penalty++;
        }
        elseif (1 == $minute % 3)
        {
            $guest_c_2_penalty++;
        }
        else
        {
            $guest_c_3_penalty++;
        }
    }
    else
    {
        if (0 == $minute % 3)
        {
            $guest_rf_1_penalty++;
        }
        elseif (1 == $minute % 3)
        {
            $guest_rf_2_penalty++;
        }
        else
        {
            $guest_rf_3_penalty++;
        }
    }
}

function f_igosja_home_team_penalty_increase()
{
    global $home_penalty;
    global $home_penalty_1;
    global $home_penalty_2;
    global $home_penalty_3;
    global $minute;

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

function f_igosja_guest_team_penalty_increase()
{
    global $guest_penalty;
    global $guest_penalty_1;
    global $guest_penalty_2;
    global $guest_penalty_3;
    global $minute;

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

function f_igosja_home_team_shot_increase()
{
    global $guest_gk_shot;
    global $home_shot;
    global $home_shot_1;
    global $home_shot_2;
    global $home_shot_3;
    global $minute;

    $guest_gk_shot++;
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
}

function f_igosja_guest_team_shot_increase()
{
    global $home_gk_shot;
    global $guest_shot;
    global $guest_shot_1;
    global $guest_shot_2;
    global $guest_shot_3;
    global $minute;

    $home_gk_shot++;
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
}

function f_igosja_home_player_shot_increase($player)
{
    global $home_c_1_shot;
    global $home_c_2_shot;
    global $home_c_3_shot;
    global $home_ld_1_shot;
    global $home_ld_2_shot;
    global $home_ld_3_shot;
    global $home_lf_1_shot;
    global $home_lf_2_shot;
    global $home_lf_3_shot;
    global $home_rd_1_shot;
    global $home_rd_2_shot;
    global $home_rd_3_shot;
    global $home_rf_1_shot;
    global $home_rf_2_shot;
    global $home_rf_3_shot;
    global $minute;

    if (1 == $player)
    {
        if (0 == $minute % 3)
        {
            $home_ld_1_shot++;
        }
        elseif (1 == $minute % 3)
        {
            $home_ld_2_shot++;
        }
        else
        {
            $home_ld_3_shot++;
        }
    }
    elseif (2 == $player)
    {
        if (0 == $minute % 3)
        {
            $home_rd_1_shot++;
        }
        elseif (1 == $minute % 3)
        {
            $home_rd_2_shot++;
        }
        else
        {
            $home_rd_3_shot++;
        }
    }
    elseif (3 == $player)
    {
        if (0 == $minute % 3)
        {
            $home_lf_1_shot++;
        }
        elseif (1 == $minute % 3)
        {
            $home_lf_2_shot++;
        }
        else
        {
            $home_lf_3_shot++;
        }
    }
    elseif (4 == $player)
    {
        if (0 == $minute % 3)
        {
            $home_c_1_shot++;
        }
        elseif (1 == $minute % 3)
        {
            $home_c_2_shot++;
        }
        else
        {
            $home_c_3_shot++;
        }
    }
    else
    {
        if (0 == $minute % 3)
        {
            $home_rf_1_shot++;
        }
        elseif (1 == $minute % 3)
        {
            $home_rf_2_shot++;
        }
        else
        {
            $home_rf_3_shot++;
        }
    }
}

function f_igosja_guest_player_shot_increase($player)
{
    global $guest_c_1_shot;
    global $guest_c_2_shot;
    global $guest_c_3_shot;
    global $guest_ld_1_shot;
    global $guest_ld_2_shot;
    global $guest_ld_3_shot;
    global $guest_lf_1_shot;
    global $guest_lf_2_shot;
    global $guest_lf_3_shot;
    global $guest_rd_1_shot;
    global $guest_rd_2_shot;
    global $guest_rd_3_shot;
    global $guest_rf_1_shot;
    global $guest_rf_2_shot;
    global $guest_rf_3_shot;
    global $minute;

    if (1 == $player)
    {
        if (0 == $minute % 3)
        {
            $guest_ld_1_shot++;
        }
        elseif (1 == $minute % 3)
        {
            $guest_ld_2_shot++;
        }
        else
        {
            $guest_ld_3_shot++;
        }
    }
    elseif (2 == $player)
    {
        if (0 == $minute % 3)
        {
            $guest_rd_1_shot++;
        }
        elseif (1 == $minute % 3)
        {
            $guest_rd_2_shot++;
        }
        else
        {
            $guest_rd_3_shot++;
        }
    }
    elseif (3 == $player)
    {
        if (0 == $minute % 3)
        {
            $guest_lf_1_shot++;
        }
        elseif (1 == $minute % 3)
        {
            $guest_lf_2_shot++;
        }
        else
        {
            $guest_lf_3_shot++;
        }
    }
    elseif (4 == $player)
    {
        if (0 == $minute % 3)
        {
            $guest_c_1_shot++;
        }
        elseif (1 == $minute % 3)
        {
            $guest_c_2_shot++;
        }
        else
        {
            $guest_c_3_shot++;
        }
    }
    else
    {
        if (0 == $minute % 3)
        {
            $guest_rf_1_shot++;
        }
        elseif (1 == $minute % 3)
        {
            $guest_rf_2_shot++;
        }
        else
        {
            $guest_rf_3_shot++;
        }
    }
}

function f_igosja_get_home_player_shot_power($player)
{
    global $home_player_c_1_power_real;
    global $home_player_c_2_power_real;
    global $home_player_c_3_power_real;
    global $home_player_ld_1_power_real;
    global $home_player_ld_2_power_real;
    global $home_player_ld_3_power_real;
    global $home_player_lf_1_power_real;
    global $home_player_lf_2_power_real;
    global $home_player_lf_3_power_real;
    global $home_player_rd_1_power_real;
    global $home_player_rd_2_power_real;
    global $home_player_rd_3_power_real;
    global $home_player_rf_1_power_real;
    global $home_player_rf_2_power_real;
    global $home_player_rf_3_power_real;
    global $minute;

    if (1 == $player)
    {
        if (0 == $minute % 3)
        {
            $player_shot = $home_player_ld_1_power_real;
        }
        elseif (1 == $minute % 3)
        {
            $player_shot = $home_player_ld_2_power_real;
        }
        else
        {
            $player_shot = $home_player_ld_3_power_real;
        }
    }
    elseif (2 == $player)
    {
        if (0 == $minute % 3)
        {
            $player_shot = $home_player_rd_1_power_real;
        }
        elseif (1 == $minute % 3)
        {
            $player_shot = $home_player_rd_2_power_real;
        }
        else
        {
            $player_shot = $home_player_rd_3_power_real;
        }
    }
    elseif (3 == $player)
    {
        if (0 == $minute % 3)
        {
            $player_shot = $home_player_lf_1_power_real;
        }
        elseif (1 == $minute % 3)
        {
            $player_shot = $home_player_lf_2_power_real;
        }
        else
        {
            $player_shot = $home_player_lf_3_power_real;
        }
    }
    elseif (4 == $player)
    {
        if (0 == $minute % 3)
        {
            $player_shot = $home_player_c_1_power_real;
        }
        elseif (1 == $minute % 3)
        {
            $player_shot = $home_player_c_2_power_real;
        }
        else
        {
            $player_shot = $home_player_c_3_power_real;
        }
    }
    else
    {
        if (0 == $minute % 3)
        {
            $player_shot = $home_player_rf_1_power_real;
        }
        elseif (1 == $minute % 3)
        {
            $player_shot = $home_player_rf_2_power_real;
        }
        else
        {
            $player_shot = $home_player_rf_3_power_real;
        }
    }

    return $player_shot;
}

function f_igosja_get_guest_player_shot_power($player)
{
    global $guest_player_c_1_power_real;
    global $guest_player_c_2_power_real;
    global $guest_player_c_3_power_real;
    global $guest_player_ld_1_power_real;
    global $guest_player_ld_2_power_real;
    global $guest_player_ld_3_power_real;
    global $guest_player_lf_1_power_real;
    global $guest_player_lf_2_power_real;
    global $guest_player_lf_3_power_real;
    global $guest_player_rd_1_power_real;
    global $guest_player_rd_2_power_real;
    global $guest_player_rd_3_power_real;
    global $guest_player_rf_1_power_real;
    global $guest_player_rf_2_power_real;
    global $guest_player_rf_3_power_real;
    global $minute;

    if (1 == $player)
    {
        if (0 == $minute % 3)
        {
            $player_shot = $guest_player_ld_1_power_real;
        }
        elseif (1 == $minute % 3)
        {
            $player_shot = $guest_player_ld_2_power_real;
        }
        else
        {
            $player_shot = $guest_player_ld_3_power_real;
        }
    }
    elseif (2 == $player)
    {
        if (0 == $minute % 3)
        {
            $player_shot = $guest_player_rd_1_power_real;
        }
        elseif (1 == $minute % 3)
        {
            $player_shot = $guest_player_rd_2_power_real;
        }
        else
        {
            $player_shot = $guest_player_rd_3_power_real;
        }
    }
    elseif (3 == $player)
    {
        if (0 == $minute % 3)
        {
            $player_shot = $guest_player_lf_1_power_real;
        }
        elseif (1 == $minute % 3)
        {
            $player_shot = $guest_player_lf_2_power_real;
        }
        else
        {
            $player_shot = $guest_player_lf_3_power_real;
        }
    }
    elseif (4 == $player)
    {
        if (0 == $minute % 3)
        {
            $player_shot = $guest_player_c_1_power_real;
        }
        elseif (1 == $minute % 3)
        {
            $player_shot = $guest_player_c_2_power_real;
        }
        else
        {
            $player_shot = $guest_player_c_3_power_real;
        }
    }
    else
    {
        if (0 == $minute % 3)
        {
            $player_shot = $guest_player_rf_1_power_real;
        }
        elseif (1 == $minute % 3)
        {
            $player_shot = $guest_player_rf_2_power_real;
        }
        else
        {
            $player_shot = $guest_player_rf_3_power_real;
        }
    }

    return $player_shot;
}

function f_igosja_home_team_score_increase()
{
    global $guest_gk_pass;
    global $home_score;
    global $home_score_1;
    global $home_score_2;
    global $home_score_3;
    global $minute;

    $home_score++;
    $guest_gk_pass++;

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

function f_igosja_guest_team_score_increase()
{
    global $home_gk_pass;
    global $guest_score;
    global $guest_score_1;
    global $guest_score_2;
    global $guest_score_3;
    global $minute;

    $guest_score++;
    $home_gk_pass++;

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

function f_igosja_home_plus_minus_increase()
{
    global $guest_c_1_plus;
    global $guest_c_2_plus;
    global $guest_c_3_plus;
    global $guest_ld_1_plus;
    global $guest_ld_2_plus;
    global $guest_ld_3_plus;
    global $guest_lf_1_plus;
    global $guest_lf_2_plus;
    global $guest_lf_3_plus;
    global $guest_rd_1_plus;
    global $guest_rd_2_plus;
    global $guest_rd_3_plus;
    global $guest_rf_1_plus;
    global $guest_rf_2_plus;
    global $guest_rf_3_plus;
    global $home_c_1_plus;
    global $home_c_2_plus;
    global $home_c_3_plus;
    global $home_ld_1_plus;
    global $home_ld_2_plus;
    global $home_ld_3_plus;
    global $home_lf_1_plus;
    global $home_lf_2_plus;
    global $home_lf_3_plus;
    global $home_rd_1_plus;
    global $home_rd_2_plus;
    global $home_rd_3_plus;
    global $home_rf_1_plus;
    global $home_rf_2_plus;
    global $home_rf_3_plus;
    global $minute;

    if (20 > $minute)
    {
        $home_ld_1_plus++;
        $home_rd_1_plus++;
        $home_lf_1_plus++;
        $home_c_1_plus++;
        $home_rf_1_plus++;

        $guest_ld_1_plus--;
        $guest_rd_1_plus--;
        $guest_lf_1_plus--;
        $guest_c_1_plus--;
        $guest_rf_1_plus--;
    }
    elseif (40 > $minute)
    {
        $home_ld_2_plus++;
        $home_rd_2_plus++;
        $home_lf_2_plus++;
        $home_c_2_plus++;
        $home_rf_2_plus++;

        $guest_ld_2_plus--;
        $guest_rd_2_plus--;
        $guest_lf_2_plus--;
        $guest_c_2_plus--;
        $guest_rf_2_plus--;
    }
    else
    {
        $home_ld_3_plus++;
        $home_rd_3_plus++;
        $home_lf_3_plus++;
        $home_c_3_plus++;
        $home_rf_3_plus++;

        $guest_ld_3_plus--;
        $guest_rd_3_plus--;
        $guest_lf_3_plus--;
        $guest_c_3_plus--;
        $guest_rf_3_plus--;
    }
}

function f_igosja_guest_plus_minus_increase()
{
    global $home_c_1_plus;
    global $home_c_2_plus;
    global $home_c_3_plus;
    global $home_ld_1_plus;
    global $home_ld_2_plus;
    global $home_ld_3_plus;
    global $home_lf_1_plus;
    global $home_lf_2_plus;
    global $home_lf_3_plus;
    global $home_rd_1_plus;
    global $home_rd_2_plus;
    global $home_rd_3_plus;
    global $home_rf_1_plus;
    global $home_rf_2_plus;
    global $home_rf_3_plus;
    global $guest_c_1_plus;
    global $guest_c_2_plus;
    global $guest_c_3_plus;
    global $guest_ld_1_plus;
    global $guest_ld_2_plus;
    global $guest_ld_3_plus;
    global $guest_lf_1_plus;
    global $guest_lf_2_plus;
    global $guest_lf_3_plus;
    global $guest_rd_1_plus;
    global $guest_rd_2_plus;
    global $guest_rd_3_plus;
    global $guest_rf_1_plus;
    global $guest_rf_2_plus;
    global $guest_rf_3_plus;
    global $minute;

    if (20 > $minute)
    {
        $guest_ld_1_plus++;
        $guest_rd_1_plus++;
        $guest_lf_1_plus++;
        $guest_c_1_plus++;
        $guest_rf_1_plus++;

        $home_ld_1_plus--;
        $home_rd_1_plus--;
        $home_lf_1_plus--;
        $home_c_1_plus--;
        $home_rf_1_plus--;
    }
    elseif (40 > $minute)
    {
        $guest_ld_2_plus++;
        $guest_rd_2_plus++;
        $guest_lf_2_plus++;
        $guest_c_2_plus++;
        $guest_rf_2_plus++;

        $home_ld_2_plus--;
        $home_rd_2_plus--;
        $home_lf_2_plus--;
        $home_c_2_plus--;
        $home_rf_2_plus--;
    }
    else
    {
        $guest_ld_3_plus++;
        $guest_rd_3_plus++;
        $guest_lf_3_plus++;
        $guest_c_3_plus++;
        $guest_rf_3_plus++;

        $home_ld_3_plus--;
        $home_rd_3_plus--;
        $home_lf_3_plus--;
        $home_c_3_plus--;
        $home_rf_3_plus--;
    }
}

function f_igosja_home_player_score_increase($player)
{
    global $home_c_1_score;
    global $home_c_2_score;
    global $home_c_3_score;
    global $home_ld_1_score;
    global $home_ld_2_score;
    global $home_ld_3_score;
    global $home_lf_1_score;
    global $home_lf_2_score;
    global $home_lf_3_score;
    global $home_rd_1_score;
    global $home_rd_2_score;
    global $home_rd_3_score;
    global $home_rf_1_score;
    global $home_rf_2_score;
    global $home_rf_3_score;
    global $minute;

    if (1 == $player)
    {
        if (0 == $minute % 3)
        {
            $home_ld_1_score++;
        }
        elseif (1 == $minute % 3)
        {
            $home_ld_2_score++;
        }
        else
        {
            $home_ld_3_score++;
        }
    }
    elseif (2 == $player)
    {
        if (0 == $minute % 3)
        {
            $home_rd_1_score++;
        }
        elseif (1 == $minute % 3)
        {
            $home_rd_2_score++;
        }
        else
        {
            $home_rd_3_score++;
        }
    }
    elseif (3 == $player)
    {
        if (0 == $minute % 3)
        {
            $home_lf_1_score++;
        }
        elseif (1 == $minute % 3)
        {
            $home_lf_2_score++;
        }
        else
        {
            $home_lf_3_score++;
        }
    }
    elseif (4 == $player)
    {
        if (0 == $minute % 3)
        {
            $home_c_1_score++;
        }
        elseif (1 == $minute % 3)
        {
            $home_c_2_score++;
        }
        else
        {
            $home_c_3_score++;
        }
    }
    else
    {
        if (0 == $minute % 3)
        {
            $home_rf_1_score++;
        }
        elseif (1 == $minute % 3)
        {
            $home_rf_2_score++;
        }
        else
        {
            $home_rf_3_score++;
        }
    }
}

function f_igosja_guest_player_score_increase($player)
{
    global $guest_c_1_score;
    global $guest_c_2_score;
    global $guest_c_3_score;
    global $guest_ld_1_score;
    global $guest_ld_2_score;
    global $guest_ld_3_score;
    global $guest_lf_1_score;
    global $guest_lf_2_score;
    global $guest_lf_3_score;
    global $guest_rd_1_score;
    global $guest_rd_2_score;
    global $guest_rd_3_score;
    global $guest_rf_1_score;
    global $guest_rf_2_score;
    global $guest_rf_3_score;
    global $minute;

    if (1 == $player)
    {
        if (0 == $minute % 3)
        {
            $guest_ld_1_score++;
        }
        elseif (1 == $minute % 3)
        {
            $guest_ld_2_score++;
        }
        else
        {
            $guest_ld_3_score++;
        }
    }
    elseif (2 == $player)
    {
        if (0 == $minute % 3)
        {
            $guest_rd_1_score++;
        }
        elseif (1 == $minute % 3)
        {
            $guest_rd_2_score++;
        }
        else
        {
            $guest_rd_3_score++;
        }
    }
    elseif (3 == $player)
    {
        if (0 == $minute % 3)
        {
            $guest_lf_1_score++;
        }
        elseif (1 == $minute % 3)
        {
            $guest_lf_2_score++;
        }
        else
        {
            $guest_lf_3_score++;
        }
    }
    elseif (4 == $player)
    {
        if (0 == $minute % 3)
        {
            $guest_c_1_score++;
        }
        elseif (1 == $minute % 3)
        {
            $guest_c_2_score++;
        }
        else
        {
            $guest_c_3_score++;
        }
    }
    else
    {
        if (0 == $minute % 3)
        {
            $guest_rf_1_score++;
        }
        elseif (1 == $minute % 3)
        {
            $guest_rf_2_score++;
        }
        else
        {
            $guest_rf_3_score++;
        }
    }
}

function f_igosja_home_player_assist_1_increase($assist_1)
{
    global $home_c_1_assist;
    global $home_c_2_assist;
    global $home_c_3_assist;
    global $home_ld_1_assist;
    global $home_ld_2_assist;
    global $home_ld_3_assist;
    global $home_lf_1_assist;
    global $home_lf_2_assist;
    global $home_lf_3_assist;
    global $home_rd_1_assist;
    global $home_rd_2_assist;
    global $home_rd_3_assist;
    global $home_rf_1_assist;
    global $home_rf_2_assist;
    global $home_rf_3_assist;
    global $minute;

    if (1 == $assist_1)
    {
        if (0 == $minute % 3)
        {
            $home_ld_1_assist++;
        }
        elseif (1 == $minute % 3)
        {
            $home_ld_2_assist++;
        }
        else
        {
            $home_ld_3_assist++;
        }
    }
    elseif (2 == $assist_1)
    {
        if (0 == $minute % 3)
        {
            $home_rd_1_assist++;
        }
        elseif (1 == $minute % 3)
        {
            $home_rd_2_assist++;
        }
        else
        {
            $home_rd_3_assist++;
        }
    }
    elseif (3 == $assist_1)
    {
        if (0 == $minute % 3)
        {
            $home_lf_1_assist++;
        }
        elseif (1 == $minute % 3)
        {
            $home_lf_2_assist++;
        }
        else
        {
            $home_lf_3_assist++;
        }
    }
    elseif (4 == $assist_1)
    {
        if (0 == $minute % 3)
        {
            $home_c_1_assist++;
        }
        elseif (1 == $minute % 3)
        {
            $home_c_2_assist++;
        }
        else
        {
            $home_c_3_assist++;
        }
    }
    else
    {
        if (0 == $minute % 3)
        {
            $home_rf_1_assist++;
        }
        elseif (1 == $minute % 3)
        {
            $home_rf_2_assist++;
        }
        else
        {
            $home_rf_3_assist++;
        }
    }
}

function f_igosja_guest_player_assist_1_increase($assist_1)
{
    global $guest_c_1_assist;
    global $guest_c_2_assist;
    global $guest_c_3_assist;
    global $guest_ld_1_assist;
    global $guest_ld_2_assist;
    global $guest_ld_3_assist;
    global $guest_lf_1_assist;
    global $guest_lf_2_assist;
    global $guest_lf_3_assist;
    global $guest_rd_1_assist;
    global $guest_rd_2_assist;
    global $guest_rd_3_assist;
    global $guest_rf_1_assist;
    global $guest_rf_2_assist;
    global $guest_rf_3_assist;
    global $minute;

    if (1 == $assist_1)
    {
        if (0 == $minute % 3)
        {
            $guest_ld_1_assist++;
        }
        elseif (1 == $minute % 3)
        {
            $guest_ld_2_assist++;
        }
        else
        {
            $guest_ld_3_assist++;
        }
    }
    elseif (2 == $assist_1)
    {
        if (0 == $minute % 3)
        {
            $guest_rd_1_assist++;
        }
        elseif (1 == $minute % 3)
        {
            $guest_rd_2_assist++;
        }
        else
        {
            $guest_rd_3_assist++;
        }
    }
    elseif (3 == $assist_1)
    {
        if (0 == $minute % 3)
        {
            $guest_lf_1_assist++;
        }
        elseif (1 == $minute % 3)
        {
            $guest_lf_2_assist++;
        }
        else
        {
            $guest_lf_3_assist++;
        }
    }
    elseif (4 == $assist_1)
    {
        if (0 == $minute % 3)
        {
            $guest_c_1_assist++;
        }
        elseif (1 == $minute % 3)
        {
            $guest_c_2_assist++;
        }
        else
        {
            $guest_c_3_assist++;
        }
    }
    else
    {
        if (0 == $minute % 3)
        {
            $guest_rf_1_assist++;
        }
        elseif (1 == $minute % 3)
        {
            $guest_rf_2_assist++;
        }
        else
        {
            $guest_rf_3_assist++;
        }
    }
}

function f_igosja_home_player_assist_2_increase($assist_2)
{
    global $home_c_1_assist;
    global $home_c_2_assist;
    global $home_c_3_assist;
    global $home_ld_1_assist;
    global $home_ld_2_assist;
    global $home_ld_3_assist;
    global $home_lf_1_assist;
    global $home_lf_2_assist;
    global $home_lf_3_assist;
    global $home_rd_1_assist;
    global $home_rd_2_assist;
    global $home_rd_3_assist;
    global $home_rf_1_assist;
    global $home_rf_2_assist;
    global $home_rf_3_assist;
    global $minute;

    if (1 == $assist_2)
    {
        if (0 == $minute % 3)
        {
            $home_ld_1_assist++;
        }
        elseif (1 == $minute % 3)
        {
            $home_ld_2_assist++;
        }
        else
        {
            $home_ld_3_assist++;
        }
    }
    elseif (2 == $assist_2)
    {
        if (0 == $minute % 3)
        {
            $home_rd_1_assist++;
        }
        elseif (1 == $minute % 3)
        {
            $home_rd_2_assist++;
        }
        else
        {
            $home_rd_3_assist++;
        }
    }
    elseif (3 == $assist_2)
    {
        if (0 == $minute % 3)
        {
            $home_lf_1_assist++;
        }
        elseif (1 == $minute % 3)
        {
            $home_lf_2_assist++;
        }
        else
        {
            $home_lf_3_assist++;
        }
    }
    elseif (4 == $assist_2)
    {
        if (0 == $minute % 3)
        {
            $home_c_1_assist++;
        }
        elseif (1 == $minute % 3)
        {
            $home_c_2_assist++;
        }
        else
        {
            $home_c_3_assist++;
        }
    }
    else
    {
        if (0 == $minute % 3)
        {
            $home_rf_1_assist++;
        }
        elseif (1 == $minute % 3)
        {
            $home_rf_2_assist++;
        }
        else
        {
            $home_rf_3_assist++;
        }
    }
}

function f_igosja_guest_player_assist_2_increase($assist_2)
{
    global $guest_c_1_assist;
    global $guest_c_2_assist;
    global $guest_c_3_assist;
    global $guest_ld_1_assist;
    global $guest_ld_2_assist;
    global $guest_ld_3_assist;
    global $guest_lf_1_assist;
    global $guest_lf_2_assist;
    global $guest_lf_3_assist;
    global $guest_rd_1_assist;
    global $guest_rd_2_assist;
    global $guest_rd_3_assist;
    global $guest_rf_1_assist;
    global $guest_rf_2_assist;
    global $guest_rf_3_assist;
    global $minute;

    if (1 == $assist_2)
    {
        if (0 == $minute % 3)
        {
            $guest_ld_1_assist++;
        }
        elseif (1 == $minute % 3)
        {
            $guest_ld_2_assist++;
        }
        else
        {
            $guest_ld_3_assist++;
        }
    }
    elseif (2 == $assist_2)
    {
        if (0 == $minute % 3)
        {
            $guest_rd_1_assist++;
        }
        elseif (1 == $minute % 3)
        {
            $guest_rd_2_assist++;
        }
        else
        {
            $guest_rd_3_assist++;
        }
    }
    elseif (3 == $assist_2)
    {
        if (0 == $minute % 3)
        {
            $guest_lf_1_assist++;
        }
        elseif (1 == $minute % 3)
        {
            $guest_lf_2_assist++;
        }
        else
        {
            $guest_lf_3_assist++;
        }
    }
    elseif (4 == $assist_2)
    {
        if (0 == $minute % 3)
        {
            $guest_c_1_assist++;
        }
        elseif (1 == $minute % 3)
        {
            $guest_c_2_assist++;
        }
        else
        {
            $guest_c_3_assist++;
        }
    }
    else
    {
        if (0 == $minute % 3)
        {
            $guest_rf_1_assist++;
        }
        elseif (1 == $minute % 3)
        {
            $guest_rf_2_assist++;
        }
        else
        {
            $guest_rf_3_assist++;
        }
    }
}