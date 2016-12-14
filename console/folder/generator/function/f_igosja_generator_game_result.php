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

        $home_gk_assist     = 0;
        $home_gk_pass       = 0;
        $home_gk_shot       = 0;
        $home_ld_1_assist   = 0;
        $home_ld_1_penalty  = 0;
        $home_ld_1_plus     = 0;
        $home_ld_1_score    = 0;
        $home_ld_1_shot     = 0;
        $home_rd_1_assist   = 0;
        $home_rd_1_penalty  = 0;
        $home_rd_1_plus     = 0;
        $home_rd_1_score    = 0;
        $home_rd_1_shot     = 0;
        $home_lf_1_assist   = 0;
        $home_lf_1_penalty  = 0;
        $home_lf_1_plus     = 0;
        $home_lf_1_score    = 0;
        $home_lf_1_shot     = 0;
        $home_c_1_assist    = 0;
        $home_c_1_penalty   = 0;
        $home_c_1_plus      = 0;
        $home_c_1_score     = 0;
        $home_c_1_shot      = 0;
        $home_rf_1_assist   = 0;
        $home_rf_1_penalty  = 0;
        $home_rf_1_plus     = 0;
        $home_rf_1_score    = 0;
        $home_rf_1_shot     = 0;
        $home_ld_2_assist   = 0;
        $home_ld_2_penalty  = 0;
        $home_ld_2_plus     = 0;
        $home_ld_2_score    = 0;
        $home_ld_2_shot     = 0;
        $home_rd_2_assist   = 0;
        $home_rd_2_penalty  = 0;
        $home_rd_2_plus     = 0;
        $home_rd_2_score    = 0;
        $home_rd_2_shot     = 0;
        $home_lf_2_assist   = 0;
        $home_lf_2_penalty  = 0;
        $home_lf_2_plus     = 0;
        $home_lf_2_score    = 0;
        $home_lf_2_shot     = 0;
        $home_c_2_assist    = 0;
        $home_c_2_penalty   = 0;
        $home_c_2_plus      = 0;
        $home_c_2_score     = 0;
        $home_c_2_shot      = 0;
        $home_rf_2_assist   = 0;
        $home_rf_2_penalty  = 0;
        $home_rf_2_plus     = 0;
        $home_rf_2_score    = 0;
        $home_rf_2_shot     = 0;
        $home_ld_3_assist   = 0;
        $home_ld_3_penalty  = 0;
        $home_ld_3_plus     = 0;
        $home_ld_3_score    = 0;
        $home_ld_3_shot     = 0;
        $home_rd_3_assist   = 0;
        $home_rd_3_penalty  = 0;
        $home_rd_3_plus     = 0;
        $home_rd_3_score    = 0;
        $home_rd_3_shot     = 0;
        $home_lf_3_assist   = 0;
        $home_lf_3_penalty  = 0;
        $home_lf_3_plus     = 0;
        $home_lf_3_score    = 0;
        $home_lf_3_shot     = 0;
        $home_c_3_assist    = 0;
        $home_c_3_penalty   = 0;
        $home_c_3_plus      = 0;
        $home_c_3_score     = 0;
        $home_c_3_shot      = 0;
        $home_rf_3_assist   = 0;
        $home_rf_3_penalty  = 0;
        $home_rf_3_plus     = 0;
        $home_rf_3_score    = 0;
        $home_rf_3_shot     = 0;

        $guest_gk_assist    = 0;
        $guest_gk_pass      = 0;
        $guest_gk_shot      = 0;
        $guest_ld_1_assist  = 0;
        $guest_ld_1_penalty = 0;
        $guest_ld_1_plus    = 0;
        $guest_ld_1_score   = 0;
        $guest_ld_1_shot    = 0;
        $guest_rd_1_assist  = 0;
        $guest_rd_1_penalty = 0;
        $guest_rd_1_plus    = 0;
        $guest_rd_1_score   = 0;
        $guest_rd_1_shot    = 0;
        $guest_lf_1_assist  = 0;
        $guest_lf_1_penalty = 0;
        $guest_lf_1_plus    = 0;
        $guest_lf_1_score   = 0;
        $guest_lf_1_shot    = 0;
        $guest_c_1_assist   = 0;
        $guest_c_1_penalty  = 0;
        $guest_c_1_plus     = 0;
        $guest_c_1_score    = 0;
        $guest_c_1_shot     = 0;
        $guest_rf_1_assist  = 0;
        $guest_rf_1_penalty = 0;
        $guest_rf_1_plus    = 0;
        $guest_rf_1_score   = 0;
        $guest_rf_1_shot    = 0;
        $guest_ld_2_assist  = 0;
        $guest_ld_2_penalty = 0;
        $guest_ld_2_plus    = 0;
        $guest_ld_2_score   = 0;
        $guest_ld_2_shot    = 0;
        $guest_rd_2_assist  = 0;
        $guest_rd_2_penalty = 0;
        $guest_rd_2_plus    = 0;
        $guest_rd_2_score   = 0;
        $guest_rd_2_shot    = 0;
        $guest_lf_2_assist  = 0;
        $guest_lf_2_penalty = 0;
        $guest_lf_2_plus    = 0;
        $guest_lf_2_score   = 0;
        $guest_lf_2_shot    = 0;
        $guest_c_2_assist   = 0;
        $guest_c_2_penalty  = 0;
        $guest_c_2_plus     = 0;
        $guest_c_2_score    = 0;
        $guest_c_2_shot     = 0;
        $guest_rf_2_assist  = 0;
        $guest_rf_2_penalty = 0;
        $guest_rf_2_plus    = 0;
        $guest_rf_2_score   = 0;
        $guest_rf_2_shot    = 0;
        $guest_ld_3_assist  = 0;
        $guest_ld_3_penalty = 0;
        $guest_ld_3_plus    = 0;
        $guest_ld_3_score   = 0;
        $guest_ld_3_shot    = 0;
        $guest_rd_3_assist  = 0;
        $guest_rd_3_penalty = 0;
        $guest_rd_3_plus    = 0;
        $guest_rd_3_score   = 0;
        $guest_rd_3_shot    = 0;
        $guest_lf_3_assist  = 0;
        $guest_lf_3_penalty = 0;
        $guest_lf_3_plus    = 0;
        $guest_lf_3_score   = 0;
        $guest_lf_3_shot    = 0;
        $guest_c_3_assist   = 0;
        $guest_c_3_penalty  = 0;
        $guest_c_3_plus     = 0;
        $guest_c_3_score    = 0;
        $guest_c_3_shot     = 0;
        $guest_rf_3_assist  = 0;
        $guest_rf_3_penalty = 0;
        $guest_rf_3_plus    = 0;
        $guest_rf_3_score   = 0;
        $guest_rf_3_shot    = 0;

        $game_id                = $game['game_id'];
        $game_bonus_home        = $game['game_bonus_home'];
        $game_guest_team_id     = $game['game_guest_team_id'];
        $game_home_team_id      = $game['game_home_team_id'];
        $game_stadium_capacity  = $game['game_stadium_capacity'];
        $game_visitor           = $game['game_visitor'];

        if ($game_bonus_home)
        {
            $home_bonus = 1 + $game_visitor / $game_stadium_capacity / 10;
        }
        else
        {
            $home_bonus = 1;
        }

        $sql = "SELECT `lineup_id`,
                       `player_age`,
                       `player_power_nominal`,
                       `player_power_real`
                FROM `lineup`
                LEFT JOIN `player`
                ON `lineup_player_id`=`player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$game_guest_team_id'
                ORDER BY `lineup_line_id` ASC, `lineup_position_id` ASC";
        $guest_lineup_sql = f_igosja_mysqli_query($sql);

        $guest_lineup_array = $guest_lineup_sql->fetch_all(1);

        $guest_player_gk_age                = $guest_lineup_array[0]['player_age'];
        $guest_player_gk_lineup_id          = $guest_lineup_array[0]['lineup_id'];
        $guest_player_gk_power_nominal      = $guest_lineup_array[0]['player_power_nominal'];
        $guest_player_gk_power_real         = $guest_lineup_array[0]['player_power_real'];
        $guest_player_ld_1_age              = $guest_lineup_array[1]['player_age'];
        $guest_player_ld_1_lineup_id        = $guest_lineup_array[1]['lineup_id'];
        $guest_player_ld_1_power_nominal    = $guest_lineup_array[1]['player_power_nominal'];
        $guest_player_ld_1_power_real       = $guest_lineup_array[1]['player_power_real'];
        $guest_player_rd_1_age              = $guest_lineup_array[2]['player_age'];
        $guest_player_rd_1_lineup_id        = $guest_lineup_array[2]['lineup_id'];
        $guest_player_rd_1_power_nominal    = $guest_lineup_array[2]['player_power_nominal'];
        $guest_player_rd_1_power_real       = $guest_lineup_array[2]['player_power_real'];
        $guest_player_lf_1_age              = $guest_lineup_array[3]['player_age'];
        $guest_player_lf_1_lineup_id        = $guest_lineup_array[3]['lineup_id'];
        $guest_player_lf_1_power_nominal    = $guest_lineup_array[3]['player_power_nominal'];
        $guest_player_lf_1_power_real       = $guest_lineup_array[3]['player_power_real'];
        $guest_player_c_1_age               = $guest_lineup_array[4]['player_age'];
        $guest_player_c_1_lineup_id         = $guest_lineup_array[4]['lineup_id'];
        $guest_player_c_1_power_nominal     = $guest_lineup_array[4]['player_power_nominal'];
        $guest_player_c_1_power_real        = $guest_lineup_array[4]['player_power_real'];
        $guest_player_rf_1_age              = $guest_lineup_array[5]['player_age'];
        $guest_player_rf_1_lineup_id        = $guest_lineup_array[5]['lineup_id'];
        $guest_player_rf_1_power_nominal    = $guest_lineup_array[5]['player_power_nominal'];
        $guest_player_rf_1_power_real       = $guest_lineup_array[5]['player_power_real'];
        $guest_player_ld_2_age              = $guest_lineup_array[6]['player_age'];
        $guest_player_ld_2_lineup_id        = $guest_lineup_array[6]['lineup_id'];
        $guest_player_ld_2_power_nominal    = $guest_lineup_array[6]['player_power_nominal'];
        $guest_player_ld_2_power_real       = $guest_lineup_array[6]['player_power_real'];
        $guest_player_rd_2_age              = $guest_lineup_array[7]['player_age'];
        $guest_player_rd_2_lineup_id        = $guest_lineup_array[7]['lineup_id'];
        $guest_player_rd_2_power_nominal    = $guest_lineup_array[7]['player_power_nominal'];
        $guest_player_rd_2_power_real       = $guest_lineup_array[7]['player_power_real'];
        $guest_player_lf_2_age              = $guest_lineup_array[8]['player_age'];
        $guest_player_lf_2_lineup_id        = $guest_lineup_array[8]['lineup_id'];
        $guest_player_lf_2_power_nominal    = $guest_lineup_array[8]['player_power_nominal'];
        $guest_player_lf_2_power_real       = $guest_lineup_array[8]['player_power_real'];
        $guest_player_c_2_age               = $guest_lineup_array[9]['player_age'];
        $guest_player_c_2_lineup_id         = $guest_lineup_array[9]['lineup_id'];
        $guest_player_c_2_power_nominal     = $guest_lineup_array[9]['player_power_nominal'];
        $guest_player_c_2_power_real        = $guest_lineup_array[9]['player_power_real'];
        $guest_player_rf_2_age              = $guest_lineup_array[10]['player_age'];
        $guest_player_rf_2_lineup_id        = $guest_lineup_array[10]['lineup_id'];
        $guest_player_rf_2_power_nominal    = $guest_lineup_array[10]['player_power_nominal'];
        $guest_player_rf_2_power_real       = $guest_lineup_array[10]['player_power_real'];
        $guest_player_ld_3_age              = $guest_lineup_array[11]['player_age'];
        $guest_player_ld_3_lineup_id        = $guest_lineup_array[11]['lineup_id'];
        $guest_player_ld_3_power_nominal    = $guest_lineup_array[11]['player_power_nominal'];
        $guest_player_ld_3_power_real       = $guest_lineup_array[11]['player_power_real'];
        $guest_player_rd_3_age              = $guest_lineup_array[12]['player_age'];
        $guest_player_rd_3_lineup_id        = $guest_lineup_array[12]['lineup_id'];
        $guest_player_rd_3_power_nominal    = $guest_lineup_array[12]['player_power_nominal'];
        $guest_player_rd_3_power_real       = $guest_lineup_array[12]['player_power_real'];
        $guest_player_lf_3_age              = $guest_lineup_array[13]['player_age'];
        $guest_player_lf_3_lineup_id        = $guest_lineup_array[13]['lineup_id'];
        $guest_player_lf_3_power_nominal    = $guest_lineup_array[13]['player_power_nominal'];
        $guest_player_lf_3_power_real       = $guest_lineup_array[13]['player_power_real'];
        $guest_player_c_3_age               = $guest_lineup_array[14]['player_age'];
        $guest_player_c_3_lineup_id         = $guest_lineup_array[14]['lineup_id'];
        $guest_player_c_3_power_nominal     = $guest_lineup_array[14]['player_power_nominal'];
        $guest_player_c_3_power_real        = $guest_lineup_array[14]['player_power_real'];
        $guest_player_rf_3_age              = $guest_lineup_array[15]['player_age'];
        $guest_player_rf_3_lineup_id        = $guest_lineup_array[15]['lineup_id'];
        $guest_player_rf_3_power_nominal    = $guest_lineup_array[15]['player_power_nominal'];
        $guest_player_rf_3_power_real       = $guest_lineup_array[15]['player_power_real'];

        $guest_gk           = $guest_player_gk_power_real;
        $guest_defence_1    = $guest_player_ld_1_power_real + $guest_player_rd_1_power_real;
        $guest_forward_1    = $guest_player_lf_1_power_real + $guest_player_c_1_power_real + $guest_player_rf_1_power_real;
        $guest_defence_2    = $guest_player_ld_2_power_real + $guest_player_rd_2_power_real;
        $guest_forward_2    = $guest_player_lf_2_power_real + $guest_player_c_2_power_real + $guest_player_rf_2_power_real;
        $guest_defence_3    = $guest_player_ld_3_power_real + $guest_player_rd_3_power_real;
        $guest_forward_3    = $guest_player_lf_3_power_real + $guest_player_c_3_power_real + $guest_player_rf_3_power_real;
        $guest_power        = $guest_gk + $guest_defence_1 + $guest_forward_1 + $guest_defence_2 + $guest_forward_2 + $guest_defence_3 + $guest_forward_3;

        $sql = "SELECT `lineup_id`,
                       `player_age`,
                       `player_power_nominal`,
                       `player_power_real`
                FROM `lineup`
                LEFT JOIN `player`
                ON `lineup_player_id`=`player_id`
                WHERE `lineup_game_id`='$game_id'
                AND `lineup_team_id`='$game_home_team_id'
                ORDER BY `lineup_line_id` ASC, `lineup_position_id` ASC";
        $home_lineup_sql = f_igosja_mysqli_query($sql);

        $home_lineup_array = $home_lineup_sql->fetch_all(1);

        $home_player_gk_age                 = $home_lineup_array[0]['player_age'];
        $home_player_gk_lineup_id           = $home_lineup_array[0]['lineup_id'];
        $home_player_gk_power_nominal       = $home_lineup_array[0]['player_power_nominal'];
        $home_player_gk_power_real          = round($home_lineup_array[0]['player_power_real'] * $home_bonus, 0);
        $home_player_ld_1_age               = $home_lineup_array[1]['player_age'];
        $home_player_ld_1_lineup_id         = $home_lineup_array[1]['lineup_id'];
        $home_player_ld_1_power_nominal     = $home_lineup_array[1]['player_power_nominal'];
        $home_player_ld_1_power_real        = round($home_lineup_array[1]['player_power_real'] * $home_bonus, 0);
        $home_player_rd_1_age               = $home_lineup_array[2]['player_age'];
        $home_player_rd_1_lineup_id         = $home_lineup_array[2]['lineup_id'];
        $home_player_rd_1_power_nominal     = $home_lineup_array[2]['player_power_nominal'];
        $home_player_rd_1_power_real        = round($home_lineup_array[2]['player_power_real'] * $home_bonus, 0);
        $home_player_lf_1_age               = $home_lineup_array[3]['player_age'];
        $home_player_lf_1_lineup_id         = $home_lineup_array[3]['lineup_id'];
        $home_player_lf_1_power_nominal     = $home_lineup_array[3]['player_power_nominal'];
        $home_player_lf_1_power_real        = round($home_lineup_array[3]['player_power_real'] * $home_bonus, 0);
        $home_player_c_1_age                = $home_lineup_array[4]['player_age'];
        $home_player_c_1_lineup_id          = $home_lineup_array[4]['lineup_id'];
        $home_player_c_1_power_nominal      = $home_lineup_array[4]['player_power_nominal'];
        $home_player_c_1_power_real         = round($home_lineup_array[4]['player_power_real'] * $home_bonus, 0);
        $home_player_rf_1_age               = $home_lineup_array[5]['player_age'];
        $home_player_rf_1_lineup_id         = $home_lineup_array[5]['lineup_id'];
        $home_player_rf_1_power_nominal     = $home_lineup_array[5]['player_power_nominal'];
        $home_player_rf_1_power_real        = round($home_lineup_array[5]['player_power_real'] * $home_bonus, 0);
        $home_player_ld_2_age               = $home_lineup_array[6]['player_age'];
        $home_player_ld_2_lineup_id         = $home_lineup_array[6]['lineup_id'];
        $home_player_ld_2_power_nominal     = $home_lineup_array[6]['player_power_nominal'];
        $home_player_ld_2_power_real        = round($home_lineup_array[6]['player_power_real'] * $home_bonus, 0);
        $home_player_rd_2_age               = $home_lineup_array[7]['player_age'];
        $home_player_rd_2_lineup_id         = $home_lineup_array[7]['lineup_id'];
        $home_player_rd_2_power_nominal     = $home_lineup_array[7]['player_power_nominal'];
        $home_player_rd_2_power_real        = round($home_lineup_array[7]['player_power_real'] * $home_bonus, 0);
        $home_player_lf_2_age               = $home_lineup_array[8]['player_age'];
        $home_player_lf_2_lineup_id         = $home_lineup_array[8]['lineup_id'];
        $home_player_lf_2_power_nominal     = $home_lineup_array[8]['player_power_nominal'];
        $home_player_lf_2_power_real        = round($home_lineup_array[8]['player_power_real'] * $home_bonus, 0);
        $home_player_c_2_age                = $home_lineup_array[9]['player_age'];
        $home_player_c_2_lineup_id          = $home_lineup_array[9]['lineup_id'];
        $home_player_c_2_power_nominal      = $home_lineup_array[9]['player_power_nominal'];
        $home_player_c_2_power_real         = round($home_lineup_array[9]['player_power_real'] * $home_bonus, 0);
        $home_player_rf_2_age               = $home_lineup_array[10]['player_age'];
        $home_player_rf_2_lineup_id         = $home_lineup_array[10]['lineup_id'];
        $home_player_rf_2_power_nominal     = $home_lineup_array[10]['player_power_nominal'];
        $home_player_rf_2_power_real        = round($home_lineup_array[10]['player_power_real'] * $home_bonus, 0);
        $home_player_ld_3_age               = $home_lineup_array[11]['player_age'];
        $home_player_ld_3_lineup_id         = $home_lineup_array[11]['lineup_id'];
        $home_player_ld_3_power_nominal     = $home_lineup_array[11]['player_power_nominal'];
        $home_player_ld_3_power_real        = round($home_lineup_array[11]['player_power_real'] * $home_bonus, 0);
        $home_player_rd_3_age               = $home_lineup_array[12]['player_age'];
        $home_player_rd_3_lineup_id         = $home_lineup_array[12]['lineup_id'];
        $home_player_rd_3_power_nominal     = $home_lineup_array[12]['player_power_nominal'];
        $home_player_rd_3_power_real        = round($home_lineup_array[12]['player_power_real'] * $home_bonus, 0);
        $home_player_lf_3_age               = $home_lineup_array[13]['player_age'];
        $home_player_lf_3_lineup_id         = $home_lineup_array[13]['lineup_id'];
        $home_player_lf_3_power_nominal     = $home_lineup_array[13]['player_power_nominal'];
        $home_player_lf_3_power_real        = round($home_lineup_array[13]['player_power_real'] * $home_bonus, 0);
        $home_player_c_3_age                = $home_lineup_array[14]['player_age'];
        $home_player_c_3_lineup_id          = $home_lineup_array[14]['lineup_id'];
        $home_player_c_3_power_nominal      = $home_lineup_array[14]['player_power_nominal'];
        $home_player_c_3_power_real         = round($home_lineup_array[14]['player_power_real'] * $home_bonus, 0);
        $home_player_rf_3_age               = $home_lineup_array[15]['player_age'];
        $home_player_rf_3_lineup_id         = $home_lineup_array[15]['lineup_id'];
        $home_player_rf_3_power_nominal     = $home_lineup_array[15]['player_power_nominal'];
        $home_player_rf_3_power_real        = round($home_lineup_array[15]['player_power_real'] * $home_bonus, 0);

        $home_gk            = $home_player_gk_power_real;
        $home_defence_1     = $home_player_ld_1_power_real + $home_player_rd_1_power_real;
        $home_forward_1     = $home_player_lf_1_power_real + $home_player_c_1_power_real + $home_player_rf_1_power_real;
        $home_defence_2     = $home_player_ld_2_power_real + $home_player_rd_2_power_real;
        $home_forward_2     = $home_player_lf_2_power_real + $home_player_c_2_power_real + $home_player_rf_2_power_real;
        $home_defence_3     = $home_player_ld_3_power_real + $home_player_rd_3_power_real;
        $home_forward_3     = $home_player_lf_3_power_real + $home_player_c_3_power_real + $home_player_rf_3_power_real;
        $home_power         = $home_gk + $home_defence_1 + $home_forward_1 + $home_defence_2 + $home_forward_2 + $home_defence_3 + $home_forward_3;

        for ($minute=0; $minute<60; $minute++)
        {
            $home_defence   = f_igosja_get_home_defence();
            $home_forward   = f_igosja_get_home_forward();
            $guest_defence  = f_igosja_get_guest_defence();
            $guest_forward  = f_igosja_get_guest_forward();

            if (rand(0, 40) >= 34 && 1 == rand(0, 1))
            {
                $home_current_penalty = 1;

                $player = rand(1, 5);

                f_igosja_home_player_penalty_increase($player);
                f_igosja_home_team_penalty_increase();
            }
            else
            {
                $home_current_penalty = 0;
            }

            if (rand(0, 40) >= 34 && 1 == rand(0, 1))
            {
                $guest_current_penalty = 1;

                $player = rand(1, 5);

                f_igosja_guest_player_penalty_increase($player);
                f_igosja_guest_team_penalty_increase();
            }
            else
            {
                $guest_current_penalty = 0;
            }

            if (rand(0, $home_defence / (1 + $home_current_penalty)) > rand(0, $guest_forward / (2 + $guest_current_penalty)))
            {
                if (rand(0, $home_forward / (1 + $home_current_penalty)) > rand(0, $guest_defence / (2 + $guest_current_penalty)))
                {
                    $player = rand(1, 5);

                    f_igosja_home_team_shot_increase();
                    f_igosja_home_player_shot_increase($player);

                    $player_shot = f_igosja_get_home_player_shot_power($player);

                    if (rand(0, $player_shot) > rand(0, $guest_gk * 5))
                    {
                        $assist_1 = f_igosja_generator_assist_1($player);
                        $assist_2 = f_igosja_generator_assist_2($player, $assist_1);

                        f_igosja_home_team_score_increase();
                        f_igosja_home_plus_minus_increase();
                        f_igosja_home_player_score_increase($player);
                        f_igosja_home_player_assist_1_increase($assist_1);
                        f_igosja_home_player_assist_2_increase($assist_2);
                    }
                }
            }

            if (rand(0, $guest_defence / (1 + $guest_current_penalty)) > rand(0, $home_forward / (2 + $home_current_penalty)))
            {
                if (rand(0, $guest_forward / (1 + $guest_current_penalty)) > rand(0, $home_defence / (2 + $home_current_penalty)))
                {
                    $player = rand(1, 5);

                    f_igosja_guest_team_shot_increase();
                    f_igosja_guest_player_shot_increase($player);

                    $player_shot = f_igosja_get_guest_player_shot_power($player);

                    if (rand(0, $player_shot) > rand(0, $home_gk * 5))
                    {
                        $assist_1 = f_igosja_generator_assist_1($player);
                        $assist_2 = f_igosja_generator_assist_2($player, $assist_1);

                        f_igosja_guest_team_score_increase();
                        f_igosja_guest_plus_minus_increase();
                        f_igosja_guest_player_score_increase($player);
                        f_igosja_guest_player_assist_1_increase($assist_1);
                        f_igosja_guest_player_assist_2_increase($assist_2);
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

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$guest_player_gk_age',
                    `lineup_assist`='$guest_gk_assist',
                    `lineup_pass`='$guest_gk_pass',
                    `lineup_power_nominal`='$guest_player_gk_power_nominal',
                    `lineup_power_real`='$guest_player_gk_power_real',
                    `lineup_shot`='$guest_gk_shot'
                WHERE `lineup_id`='$guest_player_gk_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$guest_player_ld_1_age',
                    `lineup_assist`='$guest_ld_1_assist',
                    `lineup_penalty`='$guest_ld_1_penalty'*'2',
                    `lineup_plus_minus`='$guest_ld_1_plus',
                    `lineup_power_nominal`='$guest_player_ld_1_power_nominal',
                    `lineup_power_real`='$guest_player_ld_1_power_real',
                    `lineup_score`='$guest_ld_1_score',
                    `lineup_shot`='$guest_ld_1_shot'
                WHERE `lineup_id`='$guest_player_ld_1_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$guest_player_rd_1_age',
                    `lineup_assist`='$guest_rd_1_assist',
                    `lineup_penalty`='$guest_rd_1_penalty'*'2',
                    `lineup_plus_minus`='$guest_rd_1_plus',
                    `lineup_power_nominal`='$guest_player_rd_1_power_nominal',
                    `lineup_power_real`='$guest_player_rd_1_power_real',
                    `lineup_score`='$guest_rd_1_score',
                    `lineup_shot`='$guest_rd_1_shot'
                WHERE `lineup_id`='$guest_player_rd_1_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$guest_player_lf_1_age',
                    `lineup_assist`='$guest_lf_1_assist',
                    `lineup_penalty`='$guest_lf_1_penalty'*'2',
                    `lineup_plus_minus`='$guest_lf_1_plus',
                    `lineup_power_nominal`='$guest_player_lf_1_power_nominal',
                    `lineup_power_real`='$guest_player_lf_1_power_real',
                    `lineup_score`='$guest_lf_1_score',
                    `lineup_shot`='$guest_lf_1_shot'
                WHERE `lineup_id`='$guest_player_lf_1_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$guest_player_c_1_age',
                    `lineup_assist`='$guest_c_1_assist',
                    `lineup_penalty`='$guest_c_1_penalty'*'2',
                    `lineup_plus_minus`='$guest_c_1_plus',
                    `lineup_power_nominal`='$guest_player_c_1_power_nominal',
                    `lineup_power_real`='$guest_player_c_1_power_real',
                    `lineup_score`='$guest_c_1_score',
                    `lineup_shot`='$guest_c_1_shot'
                WHERE `lineup_id`='$guest_player_c_1_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$guest_player_rf_1_age',
                    `lineup_assist`='$guest_rf_1_assist',
                    `lineup_penalty`='$guest_rf_1_penalty'*'2',
                    `lineup_plus_minus`='$guest_rf_1_plus',
                    `lineup_power_nominal`='$guest_player_rf_1_power_nominal',
                    `lineup_power_real`='$guest_player_rf_1_power_real',
                    `lineup_score`='$guest_rf_1_score',
                    `lineup_shot`='$guest_rf_1_shot'
                WHERE `lineup_id`='$guest_player_rf_1_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$guest_player_ld_2_age',
                    `lineup_assist`='$guest_ld_2_assist',
                    `lineup_penalty`='$guest_ld_2_penalty'*'2',
                    `lineup_plus_minus`='$guest_ld_2_plus',
                    `lineup_power_nominal`='$guest_player_ld_2_power_nominal',
                    `lineup_power_real`='$guest_player_ld_2_power_real',
                    `lineup_score`='$guest_ld_2_score',
                    `lineup_shot`='$guest_ld_2_shot'
                WHERE `lineup_id`='$guest_player_ld_2_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$guest_player_rd_2_age',
                    `lineup_assist`='$guest_rd_2_assist',
                    `lineup_penalty`='$guest_rd_2_penalty'*'2',
                    `lineup_plus_minus`='$guest_rd_2_plus',
                    `lineup_power_nominal`='$guest_player_rd_2_power_nominal',
                    `lineup_power_real`='$guest_player_rd_2_power_real',
                    `lineup_score`='$guest_rd_2_score',
                    `lineup_shot`='$guest_rd_2_shot'
                WHERE `lineup_id`='$guest_player_rd_2_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$guest_player_lf_2_age',
                    `lineup_assist`='$guest_lf_2_assist',
                    `lineup_penalty`='$guest_lf_2_penalty'*'2',
                    `lineup_plus_minus`='$guest_lf_2_plus',
                    `lineup_power_nominal`='$guest_player_lf_2_power_nominal',
                    `lineup_power_real`='$guest_player_lf_2_power_real',
                    `lineup_score`='$guest_lf_2_score',
                    `lineup_shot`='$guest_lf_2_shot'
                WHERE `lineup_id`='$guest_player_lf_2_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$guest_player_c_2_age',
                    `lineup_assist`='$guest_c_2_assist',
                    `lineup_penalty`='$guest_c_2_penalty'*'2',
                    `lineup_plus_minus`='$guest_c_2_plus',
                    `lineup_power_nominal`='$guest_player_c_2_power_nominal',
                    `lineup_power_real`='$guest_player_c_2_power_real',
                    `lineup_score`='$guest_c_2_score',
                    `lineup_shot`='$guest_c_2_shot'
                WHERE `lineup_id`='$guest_player_c_2_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$guest_player_rf_2_age',
                    `lineup_assist`='$guest_rf_2_assist',
                    `lineup_penalty`='$guest_rf_2_penalty'*'2',
                    `lineup_plus_minus`='$guest_rf_2_plus',
                    `lineup_power_nominal`='$guest_player_rf_2_power_nominal',
                    `lineup_power_real`='$guest_player_rf_2_power_real',
                    `lineup_score`='$guest_rf_2_score',
                    `lineup_shot`='$guest_rf_2_shot'
                WHERE `lineup_id`='$guest_player_rf_2_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$guest_player_ld_3_age',
                    `lineup_assist`='$guest_ld_3_assist',
                    `lineup_penalty`='$guest_ld_3_penalty'*'2',
                    `lineup_plus_minus`='$guest_ld_3_plus',
                    `lineup_power_nominal`='$guest_player_ld_3_power_nominal',
                    `lineup_power_real`='$guest_player_ld_3_power_real',
                    `lineup_score`='$guest_ld_3_score',
                    `lineup_shot`='$guest_ld_3_shot'
                WHERE `lineup_id`='$guest_player_ld_3_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$guest_player_rd_3_age',
                    `lineup_assist`='$guest_rd_3_assist',
                    `lineup_penalty`='$guest_rd_3_penalty'*'2',
                    `lineup_plus_minus`='$guest_rd_3_plus',
                    `lineup_power_nominal`='$guest_player_rd_3_power_nominal',
                    `lineup_power_real`='$guest_player_rd_3_power_real',
                    `lineup_score`='$guest_rd_3_score',
                    `lineup_shot`='$guest_rd_3_shot'
                WHERE `lineup_id`='$guest_player_rd_3_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$guest_player_lf_3_age',
                    `lineup_assist`='$guest_lf_3_assist',
                    `lineup_penalty`='$guest_lf_3_penalty'*'2',
                    `lineup_plus_minus`='$guest_lf_3_plus',
                    `lineup_power_nominal`='$guest_player_lf_3_power_nominal',
                    `lineup_power_real`='$guest_player_lf_3_power_real',
                    `lineup_score`='$guest_lf_3_score',
                    `lineup_shot`='$guest_lf_3_shot'
                WHERE `lineup_id`='$guest_player_lf_3_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$guest_player_c_3_age',
                    `lineup_assist`='$guest_c_3_assist',
                    `lineup_penalty`='$guest_c_3_penalty'*'2',
                    `lineup_plus_minus`='$guest_c_3_plus',
                    `lineup_power_nominal`='$guest_player_c_3_power_nominal',
                    `lineup_power_real`='$guest_player_c_3_power_real',
                    `lineup_score`='$guest_c_3_score',
                    `lineup_shot`='$guest_c_3_shot'
                WHERE `lineup_id`='$guest_player_c_3_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$guest_player_rf_3_age',
                    `lineup_assist`='$guest_rf_3_assist',
                    `lineup_penalty`='$guest_rf_3_penalty'*'2',
                    `lineup_plus_minus`='$guest_rf_3_plus',
                    `lineup_power_nominal`='$guest_player_rf_3_power_nominal',
                    `lineup_power_real`='$guest_player_rf_3_power_real',
                    `lineup_score`='$guest_rf_3_score',
                    `lineup_shot`='$guest_rf_3_shot'
                WHERE `lineup_id`='$guest_player_rf_3_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$home_player_gk_age',
                    `lineup_assist`='$home_gk_assist',
                    `lineup_pass`='$home_gk_pass',
                    `lineup_power_nominal`='$home_player_gk_power_nominal',
                    `lineup_power_real`='$home_player_gk_power_real',
                    `lineup_shot`='$home_gk_shot'
                WHERE `lineup_id`='$home_player_gk_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$home_player_ld_1_age',
                    `lineup_assist`='$home_ld_1_assist',
                    `lineup_penalty`='$home_ld_1_penalty'*'2',
                    `lineup_plus_minus`='$home_ld_1_plus',
                    `lineup_power_nominal`='$home_player_ld_1_power_nominal',
                    `lineup_power_real`='$home_player_ld_1_power_real',
                    `lineup_score`='$home_ld_1_score',
                    `lineup_shot`='$home_ld_1_shot'
                WHERE `lineup_id`='$home_player_ld_1_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$home_player_rd_1_age',
                    `lineup_assist`='$home_rd_1_assist',
                    `lineup_penalty`='$home_rd_1_penalty'*'2',
                    `lineup_plus_minus`='$home_rd_1_plus',
                    `lineup_power_nominal`='$home_player_rd_1_power_nominal',
                    `lineup_power_real`='$home_player_rd_1_power_real',
                    `lineup_score`='$home_rd_1_score',
                    `lineup_shot`='$home_rd_1_shot'
                WHERE `lineup_id`='$home_player_rd_1_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$home_player_lf_1_age',
                    `lineup_assist`='$home_lf_1_assist',
                    `lineup_penalty`='$home_lf_1_penalty'*'2',
                    `lineup_plus_minus`='$home_lf_1_plus',
                    `lineup_power_nominal`='$home_player_lf_1_power_nominal',
                    `lineup_power_real`='$home_player_lf_1_power_real',
                    `lineup_score`='$home_lf_1_score',
                    `lineup_shot`='$home_lf_1_shot'
                WHERE `lineup_id`='$home_player_lf_1_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$home_player_c_1_age',
                    `lineup_assist`='$home_c_1_assist',
                    `lineup_penalty`='$home_c_1_penalty'*'2',
                    `lineup_plus_minus`='$home_c_1_plus',
                    `lineup_power_nominal`='$home_player_c_1_power_nominal',
                    `lineup_power_real`='$home_player_c_1_power_real',
                    `lineup_score`='$home_c_1_score',
                    `lineup_shot`='$home_c_1_shot'
                WHERE `lineup_id`='$home_player_c_1_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$home_player_rf_1_age',
                    `lineup_assist`='$home_rf_1_assist',
                    `lineup_penalty`='$home_rf_1_penalty'*'2',
                    `lineup_plus_minus`='$home_rf_1_plus',
                    `lineup_power_nominal`='$home_player_rf_1_power_nominal',
                    `lineup_power_real`='$home_player_rf_1_power_real',
                    `lineup_score`='$home_rf_1_score',
                    `lineup_shot`='$home_rf_1_shot'
                WHERE `lineup_id`='$home_player_rf_1_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$home_player_ld_2_age',
                    `lineup_assist`='$home_ld_2_assist',
                    `lineup_penalty`='$home_ld_2_penalty'*'2',
                    `lineup_plus_minus`='$home_ld_2_plus',
                    `lineup_power_nominal`='$home_player_ld_2_power_nominal',
                    `lineup_power_real`='$home_player_ld_2_power_real',
                    `lineup_score`='$home_ld_2_score',
                    `lineup_shot`='$home_ld_2_shot'
                WHERE `lineup_id`='$home_player_ld_2_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$home_player_rd_2_age',
                    `lineup_assist`='$home_rd_2_assist',
                    `lineup_penalty`='$home_rd_2_penalty'*'2',
                    `lineup_plus_minus`='$home_rd_2_plus',
                    `lineup_power_nominal`='$home_player_rd_2_power_nominal',
                    `lineup_power_real`='$home_player_rd_2_power_real',
                    `lineup_score`='$home_rd_2_score',
                    `lineup_shot`='$home_rd_2_shot'
                WHERE `lineup_id`='$home_player_rd_2_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$home_player_lf_2_age',
                    `lineup_assist`='$home_lf_2_assist',
                    `lineup_penalty`='$home_lf_2_penalty'*'2',
                    `lineup_plus_minus`='$home_lf_2_plus',
                    `lineup_power_nominal`='$home_player_lf_2_power_nominal',
                    `lineup_power_real`='$home_player_lf_2_power_real',
                    `lineup_score`='$home_lf_2_score',
                    `lineup_shot`='$home_lf_2_shot'
                WHERE `lineup_id`='$home_player_lf_2_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$home_player_c_2_age',
                    `lineup_assist`='$home_c_2_assist',
                    `lineup_penalty`='$home_c_2_penalty'*'2',
                    `lineup_plus_minus`='$home_c_2_plus',
                    `lineup_power_nominal`='$home_player_c_2_power_nominal',
                    `lineup_power_real`='$home_player_c_2_power_real',
                    `lineup_score`='$home_c_2_score',
                    `lineup_shot`='$home_c_2_shot'
                WHERE `lineup_id`='$home_player_c_2_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$home_player_rf_2_age',
                    `lineup_assist`='$home_rf_2_assist',
                    `lineup_penalty`='$home_rf_2_penalty'*'2',
                    `lineup_plus_minus`='$home_rf_2_plus',
                    `lineup_power_nominal`='$home_player_rf_2_power_nominal',
                    `lineup_power_real`='$home_player_rf_2_power_real',
                    `lineup_score`='$home_rf_2_score',
                    `lineup_shot`='$home_rf_2_shot'
                WHERE `lineup_id`='$home_player_rf_2_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$home_player_ld_3_age',
                    `lineup_assist`='$home_ld_3_assist',
                    `lineup_penalty`='$home_ld_3_penalty'*'2',
                    `lineup_plus_minus`='$home_ld_3_plus',
                    `lineup_power_nominal`='$home_player_ld_3_power_nominal',
                    `lineup_power_real`='$home_player_ld_3_power_real',
                    `lineup_score`='$home_ld_3_score',
                    `lineup_shot`='$home_ld_3_shot'
                WHERE `lineup_id`='$home_player_ld_3_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$home_player_rd_3_age',
                    `lineup_assist`='$home_rd_3_assist',
                    `lineup_penalty`='$home_rd_3_penalty'*'2',
                    `lineup_plus_minus`='$home_rd_3_plus',
                    `lineup_power_nominal`='$home_player_rd_3_power_nominal',
                    `lineup_power_real`='$home_player_rd_3_power_real',
                    `lineup_score`='$home_rd_3_score',
                    `lineup_shot`='$home_rd_3_shot'
                WHERE `lineup_id`='$home_player_rd_3_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$home_player_lf_3_age',
                    `lineup_assist`='$home_lf_3_assist',
                    `lineup_penalty`='$home_lf_3_penalty'*'2',
                    `lineup_plus_minus`='$home_lf_3_plus',
                    `lineup_power_nominal`='$home_player_lf_3_power_nominal',
                    `lineup_power_real`='$home_player_lf_3_power_real',
                    `lineup_score`='$home_lf_3_score',
                    `lineup_shot`='$home_lf_3_shot'
                WHERE `lineup_id`='$home_player_lf_3_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$home_player_c_3_age',
                    `lineup_assist`='$home_c_3_assist',
                    `lineup_penalty`='$home_c_3_penalty'*'2',
                    `lineup_plus_minus`='$home_c_3_plus',
                    `lineup_power_nominal`='$home_player_c_3_power_nominal',
                    `lineup_power_real`='$home_player_c_3_power_real',
                    `lineup_score`='$home_c_3_score',
                    `lineup_shot`='$home_c_3_shot'
                WHERE `lineup_id`='$home_player_c_3_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_age`='$home_player_rf_3_age',
                    `lineup_assist`='$home_rf_3_assist',
                    `lineup_penalty`='$home_rf_3_penalty'*'2',
                    `lineup_plus_minus`='$home_rf_3_plus',
                    `lineup_power_nominal`='$home_player_rf_3_power_nominal',
                    `lineup_power_real`='$home_player_rf_3_power_real',
                    `lineup_score`='$home_rf_3_score',
                    `lineup_shot`='$home_rf_3_shot'
                WHERE `lineup_id`='$home_player_rf_3_lineup_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        usleep(1);

        print '.';
        flush();
    }
}

function f_igosja_generator_assist_1($player)
{
    $assist_1 = rand(1, 5);

    if ($player == $assist_1)
    {
        $assist_1 = f_igosja_generator_assist_1($player);
    }

    return $assist_1;
}

function f_igosja_generator_assist_2($player, $assist_1)
{
    $assist_2 = rand(0, 5);

    if (in_array($assist_2, array($player, $assist_1)))
    {
        $assist_2 = f_igosja_generator_assist_2($player, $assist_1);
    }

    return $assist_2;
}