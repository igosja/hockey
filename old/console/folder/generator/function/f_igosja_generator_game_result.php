<?php

/**
 * Генеруємо результат матчу
 */
function f_igosja_generator_game_result()
{
    global $igosja_season_id;

    $coeff_defence = 1;
    $coeff_defence_gk = 6;
    $coeff_forward = 6;
    $coeff_gk = 5;
    $coeff_rude = 2;
    $coeff_shot_1 = 5;
    $coeff_shot_2 = 2;
    $limit_rude = 38;
    $max_rude = 40;

    $sql = "SELECT `game_id`,
                   `game_bonus_home`,
                   `game_guest_auto`,
                   `game_guest_mood_id`,
                   `game_guest_national_id`,
                   `game_guest_rude_1_id`,
                   `game_guest_rude_2_id`,
                   `game_guest_rude_3_id`,
                   `game_guest_style_1_id`,
                   `game_guest_style_2_id`,
                   `game_guest_style_3_id`,
                   `game_guest_tactic_1_id`,
                   `game_guest_tactic_2_id`,
                   `game_guest_tactic_3_id`,
                   `game_guest_team_id`,
                   `game_home_auto`,
                   `game_home_mood_id`,
                   `game_home_national_id`,
                   `game_home_rude_1_id`,
                   `game_home_rude_2_id`,
                   `game_home_rude_3_id`,
                   `game_home_style_1_id`,
                   `game_home_style_2_id`,
                   `game_home_style_3_id`,
                   `game_home_tactic_1_id`,
                   `game_home_tactic_2_id`,
                   `game_home_tactic_3_id`,
                   `game_home_team_id`,
                   `game_stadium_capacity`,
                   `game_visitor`,
                   `schedule_stage_id`,
                   `schedule_tournamenttype_id`
            FROM `game`
            LEFT JOIN `schedule`
            ON `game_schedule_id`=`schedule_id`
            WHERE `game_played`=0
            AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($game_array as $game)
    {
        $game_id                = $game['game_id'];
        $game_bonus_home        = $game['game_bonus_home'];
        $game_home_national_id  = $game['game_home_national_id'];
        $game_home_team_id      = $game['game_home_team_id'];
        $game_guest_national_id = $game['game_guest_national_id'];
        $game_guest_team_id     = $game['game_guest_team_id'];
        $game_stadium_capacity  = $game['game_stadium_capacity'];
        $game_visitor           = $game['game_visitor'];
        $tournamenttype_id      = $game['schedule_tournamenttype_id'];
        $stage_id               = $game['schedule_stage_id'];

        $game_result = f_igosja_prepare_game_result_array($game_id, $game_home_national_id, $game_home_team_id, $game_guest_national_id, $game_guest_team_id, $tournamenttype_id);

        $game_result['guest']['team']['auto']      = $game['game_guest_auto'];
        $game_result['guest']['team']['mood']      = $game['game_guest_mood_id'];
        $game_result['guest']['team']['rude'][1]   = $game['game_guest_rude_1_id'];
        $game_result['guest']['team']['rude'][2]   = $game['game_guest_rude_2_id'];
        $game_result['guest']['team']['rude'][3]   = $game['game_guest_rude_3_id'];
        $game_result['guest']['team']['style'][1]  = $game['game_guest_style_1_id'];
        $game_result['guest']['team']['style'][2]  = $game['game_guest_style_2_id'];
        $game_result['guest']['team']['style'][3]  = $game['game_guest_style_3_id'];
        $game_result['guest']['team']['tactic'][1] = $game['game_guest_tactic_1_id'];
        $game_result['guest']['team']['tactic'][2] = $game['game_guest_tactic_2_id'];
        $game_result['guest']['team']['tactic'][3] = $game['game_guest_tactic_3_id'];
        $game_result['home']['team']['auto']       = $game['game_home_auto'];
        $game_result['home']['team']['mood']       = $game['game_home_mood_id'];
        $game_result['home']['team']['rude'][1]    = $game['game_home_rude_1_id'];
        $game_result['home']['team']['rude'][2]    = $game['game_home_rude_2_id'];
        $game_result['home']['team']['rude'][3]    = $game['game_home_rude_3_id'];
        $game_result['home']['team']['style'][1]   = $game['game_home_style_1_id'];
        $game_result['home']['team']['style'][2]   = $game['game_home_style_2_id'];
        $game_result['home']['team']['style'][3]   = $game['game_home_style_3_id'];
        $game_result['home']['team']['tactic'][1]  = $game['game_home_tactic_1_id'];
        $game_result['home']['team']['tactic'][2]  = $game['game_home_tactic_2_id'];
        $game_result['home']['team']['tactic'][3]  = $game['game_home_tactic_3_id'];

        $game_result = f_igosja_count_home_bonus($game_result, $game_bonus_home, $game_visitor, $game_stadium_capacity);
        $game_result = f_igosja_get_player_info($game_result);
        $game_result = f_igosja_count_player_bonus($game_result);
        $game_result = f_igosja_get_teamwork($game_result);
        $game_result = f_igosja_set_teamwork($game_result);
        $game_result = f_igosja_collision($game_result);
        $game_result = f_igosja_player_optimal_power($game_result);
        $game_result = f_igosja_get_player_real_power_from_optimal($game_result);
        $game_result = f_igosja_team_power($game_result);
        $game_result = f_igosja_team_power_forecast($game_result);
        $game_result = f_igosja_optimality($game_result);

        $should_win = 0;

        if ($game_result['home']['team']['power']['percent'] > 52)
        {
            $should_win = ($game_result['home']['team']['power']['percent'] - 52) / 3;
        }
        elseif ($game_result['guest']['team']['power']['percent'] > 52)
        {
            $should_win = -($game_result['guest']['team']['power']['percent'] - 52) / 3;
        }

        for ($game_result['minute']=0; $game_result['minute']<60; $game_result['minute']++)
        {
            $game_result = f_igosja_defence($game_result);
            $game_result = f_igosja_forward($game_result);
            $game_result = f_igosja_tactic($game_result);

            $rude_home  = $game_result['home']['team']['rude'][$game_result['minute'] % 3 + 1];
            $rude_guest = $game_result['guest']['team']['rude'][$game_result['minute'] % 3 + 1];

            if (rand(0, $max_rude) >= $limit_rude - $rude_home * $coeff_rude && 1 == rand(0, 1))
            {
                $game_result['player'] = rand(POSITION_LD, POSITION_RW);

                $game_result = f_igosja_event_penalty($game_result, 'home');
                $game_result = f_igosja_player_penalty_increase($game_result, 'home');
                $game_result = f_igosja_current_penalty_increase($game_result, 'home');
                $game_result = f_igosja_team_penalty_increase($game_result, 'home');
            }

            if (rand(0, $max_rude) >= $limit_rude - $rude_guest * $coeff_rude && 1 == rand(0, 1))
            {
                $game_result['player'] = rand(POSITION_LD, POSITION_RW);

                $game_result = f_igosja_event_penalty($game_result, 'guest');
                $game_result = f_igosja_player_penalty_increase($game_result, 'guest');
                $game_result = f_igosja_current_penalty_increase($game_result, 'guest');
                $game_result = f_igosja_team_penalty_increase($game_result, 'guest');
            }

            $game_result = f_igosja_current_penalty_decrease($game_result);
            $game_result = f_igosja_face_off($game_result);

            $home_penalty_current = count($game_result['home']['team']['penalty']['current']);

            if ($home_penalty_current > 2)
            {
                $home_penalty_current = 2;
            }

            $guest_penalty_current = count($game_result['guest']['team']['penalty']['current']);

            if ($guest_penalty_current > 2)
            {
                $guest_penalty_current = 2;
            }

            $forward = $game_result['home']['team']['power']['forward']['current'] / ($coeff_forward + $home_penalty_current);
            $defence = $game_result['guest']['team']['power']['defence']['current'] / ($coeff_defence + $guest_penalty_current);

            if (rand(0, $forward * $game_result['home']['team']['tactic']['current']) > rand(0, $defence))
            {
                $game_result = f_igosja_select_player_shot($game_result, 'home');
                $game_result = f_igosja_team_shot_increase($game_result, 'home', 'guest');
                $game_result = f_igosja_player_shot_increase($game_result, 'home');
                $game_result = f_igosja_player_shot_power($game_result, 'home');

                $shot_power = $game_result['home']['team']['power']['shot'];
                $gk_power   = $game_result['guest']['team']['power']['gk'];

                if (rand($shot_power / $coeff_shot_1, $shot_power * $coeff_shot_2) > rand($gk_power / $coeff_gk, $gk_power + $defence * ($coeff_defence_gk - $game_result['guest']['team']['tactic']['current'])) && f_igosja_can_score($game_result, $should_win, 'home', 'guest'))
                {
                    $game_result = f_igosja_assist_1($game_result, 'home');
                    $game_result = f_igosja_assist_2($game_result, 'home');
                    $game_result = f_igosja_team_score_increase($game_result, 'home', 'guest');
                    $game_result = f_igosja_event_score($game_result, 'home');
                    $game_result = f_igosja_plus_minus_increase($game_result, 'home', 'guest');
                    $game_result = f_igosja_player_score_increase($game_result, 'home', 'guest');
                    $game_result = f_igosja_player_assist_1_increase($game_result, 'home', 'guest');
                    $game_result = f_igosja_player_assist_2_increase($game_result, 'home', 'guest');
                    $game_result = f_igosja_current_penalty_decrease_after_goal($game_result, 'home', 'guest');
                }
            }

            $forward = $game_result['guest']['team']['power']['forward']['current'] / ($coeff_forward + $guest_penalty_current);
            $defence = $game_result['home']['team']['power']['defence']['current'] / ($coeff_defence + $home_penalty_current);

            if (rand(0, $forward * $game_result['guest']['team']['tactic']['current']) > rand(0, $defence))
            {
                $game_result = f_igosja_select_player_shot($game_result, 'guest');
                $game_result = f_igosja_team_shot_increase($game_result, 'guest', 'home');
                $game_result = f_igosja_player_shot_increase($game_result, 'guest');
                $game_result = f_igosja_player_shot_power($game_result, 'guest');

                $shot_power = $game_result['guest']['team']['power']['shot'];
                $gk_power   = $game_result['home']['team']['power']['gk'];

                if (rand($shot_power / $coeff_shot_1, $shot_power * $coeff_shot_2) > rand($gk_power / $coeff_gk, $gk_power + $defence * ($coeff_defence_gk - $game_result['home']['team']['tactic']['current'])) && f_igosja_can_score($game_result, $should_win, 'guest', 'home'))
                {
                    $game_result = f_igosja_assist_1($game_result, 'guest');
                    $game_result = f_igosja_assist_2($game_result, 'guest');
                    $game_result = f_igosja_team_score_increase($game_result, 'guest', 'home');
                    $game_result = f_igosja_event_score($game_result, 'guest');
                    $game_result = f_igosja_plus_minus_increase($game_result, 'guest', 'home');
                    $game_result = f_igosja_player_score_increase($game_result, 'guest', 'home');
                    $game_result = f_igosja_player_assist_1_increase($game_result, 'guest', 'home');
                    $game_result = f_igosja_player_assist_2_increase($game_result, 'guest', 'home');
                    $game_result = f_igosja_current_penalty_decrease_after_goal($game_result, 'guest', 'home');
                }
            }
        }

        $continue = 0;

        if ($game_result['home']['team']['score']['total'] == $game_result['guest']['team']['score']['total'] && TOURNAMENTTYPE_LEAGUE != $tournamenttype_id)
        {
            $continue = 1;
        }
        elseif ($game_result['home']['team']['score']['total'] == $game_result['guest']['team']['score']['total'] && TOURNAMENTTYPE_LEAGUE == $tournamenttype_id && $stage_id <= STAGE_6_TOUR)
        {
            $continue = 1;
        }
        elseif (TOURNAMENTTYPE_LEAGUE == $tournamenttype_id && in_array($stage_id, array(STAGE_1_QUALIFY, STAGE_2_QUALIFY, STAGE_3_QUALIFY, STAGE_1_8_FINAL, STAGE_QUATER, STAGE_SEMI, STAGE_FINAL)))
        {
            $sql = "SELECT `game_guest_score`+`game_guest_score_bullet` AS `guest_score`,
                           `game_guest_team_id`,
                           `game_home_score`+`game_home_score_bullet` AS `home_score`,
                           `game_home_team_id`
                    FROM `game`
                    LEFT JOIN `schedule`
                    ON `game_schedule_id`=`schedule_id`
                    WHERE ((`game_guest_team_id`=$game_home_team_id
                    AND `game_home_team_id`=$game_guest_team_id)
                    OR (`game_guest_team_id`=$game_guest_team_id
                    AND `game_home_team_id`=$game_home_team_id))
                    AND `schedule_season_id`=$igosja_season_id
                    AND `schedule_tournamenttype_id`=$tournamenttype_id
                    AND `schedule_stage_id`=$stage_id
                    AND `game_played`=1
                    LIMIT 1";
            $prev_sql = f_igosja_mysqli_query($sql);

            if (0 != $prev_sql->num_rows)
            {
                $prev_array = $prev_sql->fetch_all(MYSQLI_ASSOC);

                if ($game_home_team_id == $prev_array[0]['game_home_team_id'])
                {
                    $home_score_with_prev   = $game_result['home']['team']['score']['total'] + $prev_array[0]['home_score'];
                    $guest_score_with_prev  = $game_result['guest']['team']['score']['total'] + $prev_array[0]['guest_score'];
                }
                else
                {
                    $home_score_with_prev   = $game_result['home']['team']['score']['total'] + $prev_array[0]['guest_score'];
                    $guest_score_with_prev  = $game_result['guest']['team']['score']['total'] + $prev_array[0]['home_score'];
                }

                if ($home_score_with_prev == $guest_score_with_prev)
                {
                    $continue = 1;
                }
            }
        }

        if (1 == $continue)
        {
            for ($game_result['minute']=60; $game_result['minute']<65; $game_result['minute']++)
            {
                $game_result = f_igosja_defence($game_result);
                $game_result = f_igosja_forward($game_result);
                $game_result = f_igosja_tactic($game_result);

                $rude_home  = $game_result['home']['team']['rude'][$game_result['minute'] % 3 + 1];
                $rude_guest = $game_result['guest']['team']['rude'][$game_result['minute'] % 3 + 1];

                if (rand(0, $max_rude) >= $limit_rude - $rude_home * $coeff_rude && 1 == rand(0, 1))
                {
                    $game_result['player'] = rand(POSITION_LD, POSITION_RW);

                    $game_result = f_igosja_event_penalty($game_result, 'home');
                    $game_result = f_igosja_player_penalty_increase($game_result, 'home');
                    $game_result = f_igosja_current_penalty_increase($game_result, 'home');
                    $game_result = f_igosja_team_penalty_increase($game_result, 'home');
                }

                if (rand(0, $max_rude) >= $limit_rude - $rude_guest * $coeff_rude && 1 == rand(0, 1))
                {
                    $game_result['player'] = rand(POSITION_LD, POSITION_RW);

                    $game_result = f_igosja_event_penalty($game_result, 'guest');
                    $game_result = f_igosja_player_penalty_increase($game_result, 'guest');
                    $game_result = f_igosja_current_penalty_increase($game_result, 'guest');
                    $game_result = f_igosja_team_penalty_increase($game_result, 'guest');
                }

                $game_result = f_igosja_current_penalty_decrease($game_result);
                $game_result = f_igosja_face_off($game_result);

                $home_penalty_current = count($game_result['home']['team']['penalty']['current']);

                if ($home_penalty_current > 2)
                {
                    $home_penalty_current = 2;
                }

                $guest_penalty_current = count($game_result['guest']['team']['penalty']['current']);

                if ($guest_penalty_current > 2)
                {
                    $guest_penalty_current = 2;
                }

                $forward = $game_result['home']['team']['power']['forward']['current'] / ($coeff_forward + $home_penalty_current);
                $defence = $game_result['guest']['team']['power']['defence']['current'] / ($coeff_defence + $guest_penalty_current);

                if (rand(0, $forward * $game_result['home']['team']['tactic']['current']) > rand(0, $defence))
                {
                    $game_result = f_igosja_select_player_shot($game_result, 'home');
                    $game_result = f_igosja_team_shot_increase($game_result, 'home', 'guest');
                    $game_result = f_igosja_player_shot_increase($game_result, 'home');
                    $game_result = f_igosja_player_shot_power($game_result, 'home');

                    $shot_power = $game_result['home']['team']['power']['shot'];
                    $gk_power   = $game_result['guest']['team']['power']['gk'];

                    if (rand($shot_power / $coeff_shot_1, $shot_power * $coeff_shot_2) > rand($gk_power / $coeff_gk, $gk_power + $defence * ($coeff_defence_gk - $game_result['guest']['team']['tactic']['current'])) && f_igosja_can_score($game_result, $should_win, 'home', 'guest'))
                    {
                        $game_result = f_igosja_assist_1($game_result, 'home');
                        $game_result = f_igosja_assist_2($game_result, 'home');
                        $game_result = f_igosja_team_score_increase($game_result, 'home', 'guest');
                        $game_result = f_igosja_event_score($game_result, 'home');
                        $game_result = f_igosja_plus_minus_increase($game_result, 'home', 'guest');
                        $game_result = f_igosja_player_score_increase($game_result, 'home', 'guest');
                        $game_result = f_igosja_player_assist_1_increase($game_result, 'home', 'guest');
                        $game_result = f_igosja_player_assist_2_increase($game_result, 'home', 'guest');
                        $game_result = f_igosja_current_penalty_decrease_after_goal($game_result, 'home', 'guest');

                        $game_result['minute'] = 65;
                    }
                }

                if ($game_result['minute'] < 65)
                {
                    $defence = $game_result['guest']['team']['power']['defence']['current'] / ($coeff_forward + $guest_penalty_current);
                    $forward = $game_result['home']['team']['power']['forward']['current'] / ($coeff_defence + $home_penalty_current);

                    if (rand(0, $forward * $game_result['home']['guest']['tactic']['current']) > rand(0, $defence))
                    {
                        $game_result = f_igosja_select_player_shot($game_result, 'guest');
                        $game_result = f_igosja_team_shot_increase($game_result, 'guest', 'home');
                        $game_result = f_igosja_player_shot_increase($game_result, 'guest');
                        $game_result = f_igosja_player_shot_power($game_result, 'guest');

                        $shot_power = $game_result['guest']['team']['power']['shot'];
                        $gk_power   = $game_result['home']['team']['power']['gk'];

                        if (rand($shot_power / $coeff_shot_1, $shot_power * $coeff_shot_2) > rand($gk_power / $coeff_gk, $gk_power + $defence * ($coeff_defence_gk - $game_result['home']['team']['tactic']['current'])) && f_igosja_can_score($game_result, $should_win, 'guest', 'home'))
                        {
                            $game_result = f_igosja_assist_1($game_result, 'guest');
                            $game_result = f_igosja_assist_2($game_result, 'guest');
                            $game_result = f_igosja_team_score_increase($game_result, 'guest', 'home');
                            $game_result = f_igosja_event_score($game_result, 'guest');
                            $game_result = f_igosja_plus_minus_increase($game_result, 'guest', 'home');
                            $game_result = f_igosja_player_score_increase($game_result, 'guest', 'home');
                            $game_result = f_igosja_player_assist_1_increase($game_result, 'guest', 'home');
                            $game_result = f_igosja_player_assist_2_increase($game_result, 'guest', 'home');
                            $game_result = f_igosja_current_penalty_decrease_after_goal($game_result, 'guest', 'home');

                            $game_result['minute'] = 65;
                        }
                    }
                }
            }
        }

        $continue = 0;

        if ($game_result['home']['team']['score']['total'] == $game_result['guest']['team']['score']['total'] && TOURNAMENTTYPE_LEAGUE != $tournamenttype_id)
        {
            $continue = 1;
        }
        elseif ($game_result['home']['team']['score']['total'] == $game_result['guest']['team']['score']['total'] && TOURNAMENTTYPE_LEAGUE == $tournamenttype_id && $stage_id <= STAGE_6_TOUR)
        {
            $continue = 1;
        }
        elseif (TOURNAMENTTYPE_LEAGUE == $tournamenttype_id && in_array($stage_id, array(STAGE_1_QUALIFY, STAGE_2_QUALIFY, STAGE_3_QUALIFY, STAGE_1_8_FINAL, STAGE_QUATER, STAGE_SEMI, STAGE_FINAL)))
        {
            if (isset($prev_array))
            {
                if ($game_home_team_id == $prev_array[0]['game_home_team_id'])
                {
                    $home_score_with_prev   = $game_result['home']['team']['score']['total'] + $prev_array[0]['home_score'];
                    $guest_score_with_prev  = $game_result['guest']['team']['score']['total'] + $prev_array[0]['guest_score'];
                }
                else
                {
                    $home_score_with_prev   = $game_result['home']['team']['score']['total'] + $prev_array[0]['guest_score'];
                    $guest_score_with_prev  = $game_result['guest']['team']['score']['total'] + $prev_array[0]['home_score'];
                }

                if ($home_score_with_prev == $guest_score_with_prev)
                {
                    $continue = 1;
                }
            }
        }

        if (1 == $continue)
        {
            $game_result = f_igosja_game_with_bullet($game_result);

            $guest_power_array  = array();
            $home_power_array   = array();

            for ($j=1; $j<=15; $j++)
            {
                if     ( 1 == $j) { $key = 'ld_1'; }
                elseif ( 2 == $j) { $key = 'rd_1'; }
                elseif ( 3 == $j) { $key = 'lw_1'; }
                elseif ( 4 == $j) { $key =  'c_1'; }
                elseif ( 5 == $j) { $key = 'rw_1'; }
                elseif ( 6 == $j) { $key = 'ld_2'; }
                elseif ( 7 == $j) { $key = 'rd_2'; }
                elseif ( 8 == $j) { $key = 'lw_2'; }
                elseif ( 9 == $j) { $key =  'c_2'; }
                elseif (10 == $j) { $key = 'rw_2'; }
                elseif (11 == $j) { $key = 'ld_3'; }
                elseif (12 == $j) { $key = 'rd_3'; }
                elseif (13 == $j) { $key = 'lw_3'; }
                elseif (14 == $j) { $key =  'c_3'; }
                else              { $key = 'rw_3'; }

                $guest_power_array[]    = array($key, $game_result['guest']['player']['field'][$key]['power_real']);
                $home_power_array[]     = array($key, $game_result['home']['player']['field'][$key]['power_real']);
            }

            usort($guest_power_array, function ($a, $b) {
                return $a[1] > $b[1] ? -1 : 1;
            });

            usort($home_power_array, function ($a, $b) {
                return $a[1] > $b[1] ? -1 : 1;
            });

            $continue = true;

            while ($continue)
            {
                $game_result['minute']++;

                $key = ($game_result['minute'] - 5) % 15;

                $shot_power = $home_power_array[$key][1];
                $gk_power   = $game_result['guest']['team']['power']['gk'];

                if (rand(0, $shot_power) > rand(0, $gk_power))
                {
                    $game_result = f_igosja_team_score_bullet_increase($game_result, 'home');
                    $game_result = f_igosja_event_bullet($game_result, 'home', EVENTTEXT_BULLET_SCORE, $home_power_array[$key][0]);
                    $game_result['home']['team']['score']['last']['bullet'] = $home_power_array[$key][0];
                }
                else
                {
                    $game_result = f_igosja_event_bullet($game_result, 'home', EVENTTEXT_BULLET_NO_SCORE, $home_power_array[$key][0]);
                }

                $shot_power = $guest_power_array[$key][1];
                $gk_power   = $game_result['home']['team']['power']['gk'];

                if (rand(0, $shot_power) > rand(0, $gk_power))
                {
                    $game_result = f_igosja_team_score_bullet_increase($game_result, 'guest');
                    $game_result = f_igosja_event_bullet($game_result, 'guest', EVENTTEXT_BULLET_SCORE, $guest_power_array[$key][0]);
                    $game_result['guest']['team']['score']['last']['bullet'] = $guest_power_array[$key][0];
                }
                else
                {
                    $game_result = f_igosja_event_bullet($game_result, 'guest', EVENTTEXT_BULLET_NO_SCORE, $guest_power_array[$key][0]);
                }

                if ($game_result['home']['team']['score']['bullet'] != $game_result['guest']['team']['score']['bullet'])
                {
                    $continue = false;
                }
            }
        }

        $game_result = f_igosja_calculate_statistic($game_result);

        $sql = "UPDATE `game`
                SET `game_guest_collision_1`=" . $game_result['guest']['team']['collision'][1] . ",
                    `game_guest_collision_2`=" . $game_result['guest']['team']['collision'][2] . ",
                    `game_guest_collision_3`=" . $game_result['guest']['team']['collision'][3] . ",
                    `game_guest_forecast`=" . $game_result['guest']['team']['power']['forecast'] . ",
                    `game_guest_optimality_1`=" . $game_result['guest']['team']['optimality_1'] . ",
                    `game_guest_optimality_2`=" . $game_result['guest']['team']['optimality_2'] . ",
                    `game_guest_penalty`=" . $game_result['guest']['team']['penalty']['total'] . "*2,
                    `game_guest_penalty_1`=" . $game_result['guest']['team']['penalty'][1] . "*2,
                    `game_guest_penalty_2`=" . $game_result['guest']['team']['penalty'][2] . "*2,
                    `game_guest_penalty_3`=" . $game_result['guest']['team']['penalty'][3] . "*2,
                    `game_guest_penalty_over`=" . $game_result['guest']['team']['penalty']['over'] . "*2,
                    `game_guest_power`=" . $game_result['guest']['team']['power']['total'] . ",
                    `game_guest_power_percent`=" . $game_result['guest']['team']['power']['percent'] . ",
                    `game_guest_score`=" . $game_result['guest']['team']['score']['total'] . ",
                    `game_guest_score_1`=" . $game_result['guest']['team']['score'][1] . ",
                    `game_guest_score_2`=" . $game_result['guest']['team']['score'][2] . ",
                    `game_guest_score_3`=" . $game_result['guest']['team']['score'][3] . ",
                    `game_guest_score_bullet`=" . $game_result['guest']['team']['score']['bullet'] . ",
                    `game_guest_score_over`=" . $game_result['guest']['team']['score']['over'] . ",
                    `game_guest_shot`=" . $game_result['guest']['team']['shot']['total'] . ",
                    `game_guest_shot_1`=" . $game_result['guest']['team']['shot'][1] . ",
                    `game_guest_shot_2`=" . $game_result['guest']['team']['shot'][2] . ",
                    `game_guest_shot_3`=" . $game_result['guest']['team']['shot'][3] . ",
                    `game_guest_shot_over`=" . $game_result['guest']['team']['shot']['over'] . ",
                    `game_guest_teamwork_1`=" . $game_result['guest']['team']['teamwork'][1] . ",
                    `game_guest_teamwork_2`=" . $game_result['guest']['team']['teamwork'][2] . ",
                    `game_guest_teamwork_3`=" . $game_result['guest']['team']['teamwork'][3] . ",
                    `game_home_forecast`=" . $game_result['home']['team']['power']['forecast'] . ",
                    `game_home_optimality_1`=" . $game_result['home']['team']['optimality_1'] . ",
                    `game_home_optimality_2`=" . $game_result['home']['team']['optimality_2'] . ",
                    `game_home_penalty`=" . $game_result['home']['team']['penalty']['total'] . "*2,
                    `game_home_penalty_1`=" . $game_result['home']['team']['penalty'][1] . "*2,
                    `game_home_penalty_2`=" . $game_result['home']['team']['penalty'][2] . "*2,
                    `game_home_penalty_3`=" . $game_result['home']['team']['penalty'][3] . "*2,
                    `game_home_penalty_over`=" . $game_result['home']['team']['penalty']['over'] . "*2,
                    `game_home_power`=" . $game_result['home']['team']['power']['total'] . ",
                    `game_home_power_percent`=" . $game_result['home']['team']['power']['percent'] . ",
                    `game_home_score`=" . $game_result['home']['team']['score']['total'] . ",
                    `game_home_score_1`=" . $game_result['home']['team']['score'][1] . ",
                    `game_home_score_2`=" . $game_result['home']['team']['score'][2] . ",
                    `game_home_score_3`=" . $game_result['home']['team']['score'][3] . ",
                    `game_home_score_bullet`=" . $game_result['home']['team']['score']['bullet'] . ",
                    `game_home_score_over`=" . $game_result['home']['team']['score']['over'] . ",
                    `game_home_shot`=" . $game_result['home']['team']['shot']['total'] . ",
                    `game_home_shot_1`=" . $game_result['home']['team']['shot'][1] . ",
                    `game_home_shot_2`=" . $game_result['home']['team']['shot'][2] . ",
                    `game_home_shot_3`=" . $game_result['home']['team']['shot'][3] . ",
                    `game_home_shot_over`=" . $game_result['home']['team']['shot']['over'] . ",
                    `game_home_teamwork_1`=" . $game_result['home']['team']['teamwork'][1] . ",
                    `game_home_teamwork_2`=" . $game_result['home']['team']['teamwork'][2] . ",
                    `game_home_teamwork_3`=" . $game_result['home']['team']['teamwork'][3] . "
                WHERE `game_id`=$game_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        foreach ($game_result['event'] as $event)
        {
            $sql = "INSERT INTO `event`
                    SET `event_eventtextbullet_id`=" . $event['event_eventtextbullet_id'] . ",
                        `event_eventtextgoal_id`=" . $event['event_eventtextgoal_id'] . ",
                        `event_eventtextpenalty_id`=" . $event['event_eventtextpenalty_id'] . ",
                        `event_eventtype_id`=" . $event['event_eventtype_id'] . ",
                        `event_game_id`=" . $event['event_game_id'] . ",
                        `event_guest_score`=" . $event['event_guest_score'] . ",
                        `event_home_score`=" . $event['event_home_score'] . ",
                        `event_minute`=" . $event['event_minute'] . ",
                        `event_national_id`=" . $event['event_national_id'] . ",
                        `event_player_assist_1_id`=" . $event['event_player_assist_1_id'] . ",
                        `event_player_assist_2_id`=" . $event['event_player_assist_2_id'] . ",
                        `event_player_penalty_id`=" . $event['event_player_penalty_id'] . ",
                        `event_player_score_id`=" . $event['event_player_score_id'] . ",
                        `event_second`=" . $event['event_second'] . ",
                        `event_team_id`=" . $event['event_team_id'];
            f_igosja_mysqli_query($sql);
        }

        if ($game_result['guest']['player']['gk']['lineup_id'])
        {
            $sql = "UPDATE `lineup`
                    SET `lineup_age`=" . $game_result['guest']['player']['gk']['age'] . ",
                        `lineup_assist`=" . $game_result['guest']['player']['gk']['assist'] . ",
                        `lineup_pass`=" . $game_result['guest']['player']['gk']['pass'] . ",
                        `lineup_power_nominal`=" . $game_result['guest']['player']['gk']['power_nominal'] . ",
                        `lineup_power_real`=" . $game_result['guest']['player']['gk']['power_real'] . ",
                        `lineup_shot`=" . $game_result['guest']['player']['gk']['shot'] . "
                    WHERE `lineup_id`=" . $game_result['guest']['player']['gk']['lineup_id'] . "
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }

        foreach ($game_result['guest']['player']['field'] as $player)
        {
            if ($player['lineup_id'])
            {
                $sql = "UPDATE `lineup`
                        SET `lineup_age`=" . $player['age'] . ",
                            `lineup_assist`=" . $player['assist'] . ",
                            `lineup_penalty`=" . $player['penalty'] . "*2,
                            `lineup_plus_minus`=" . $player['plus_minus'] . ",
                            `lineup_power_nominal`=" . $player['power_nominal'] . ",
                            `lineup_power_real`=" . $player['power_real'] . ",
                            `lineup_score`=" . $player['score'] . ",
                            `lineup_shot`=" . $player['shot'] . "
                        WHERE `lineup_id`=" . $player['lineup_id'] . "
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
        }

        if ($game_result['home']['player']['gk']['lineup_id'])
        {
            $sql = "UPDATE `lineup`
                    SET `lineup_age`=" . $game_result['home']['player']['gk']['age'] . ",
                        `lineup_assist`=" . $game_result['home']['player']['gk']['assist'] . ",
                        `lineup_pass`=" . $game_result['home']['player']['gk']['pass'] . ",
                        `lineup_power_nominal`=" . $game_result['home']['player']['gk']['power_nominal'] . ",
                        `lineup_power_real`=" . $game_result['home']['player']['gk']['power_real'] . ",
                        `lineup_shot`=" . $game_result['home']['player']['gk']['shot'] . "
                    WHERE `lineup_id`=" . $game_result['home']['player']['gk']['lineup_id'] . "
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }

        foreach ($game_result['home']['player']['field'] as $player)
        {
            if ($player['lineup_id'])
            {
                $sql = "UPDATE `lineup`
                        SET `lineup_age`=" . $player['age'] . ",
                            `lineup_assist`=" . $player['assist'] . ",
                            `lineup_penalty`=" . $player['penalty'] . "*2,
                            `lineup_plus_minus`=" . $player['plus_minus'] . ",
                            `lineup_power_nominal`=" . $player['power_nominal'] . ",
                            `lineup_power_real`=" . $player['power_real'] . ",
                            `lineup_score`=" . $player['score'] . ",
                            `lineup_shot`=" . $player['shot'] . "
                        WHERE `lineup_id`=" . $player['lineup_id'] . "
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
        }

        $sql = "SELECT `championship_country_id`,
                       `championship_division_id`,
                       `schedule_season_id`,
                       `schedule_stage_id`,
                       `schedule_tournamenttype_id`,
                       `worldcup_division_id`
                FROM `lineup`
                LEFT JOIN `game`
                ON `game_id`=`lineup_game_id`
                LEFT JOIN `schedule`
                ON `game_schedule_id`=`schedule_id`
                LEFT JOIN `championship`
                ON (`lineup_team_id`=`championship_team_id`
                AND `schedule_season_id`=`championship_season_id`)
                LEFT JOIN `worldcup`
                ON (`lineup_national_id`=`worldcup_national_id`
                AND `schedule_season_id`=`worldcup_season_id`)
                WHERE `lineup_id`=" . $game_result['guest']['player']['gk']['lineup_id'] . "
                LIMIT 1";
        $statistic_sql = f_igosja_mysqli_query($sql);

        $statistic_array = $statistic_sql->fetch_all(MYSQLI_ASSOC);

        $country_id         = $statistic_array[0]['championship_country_id'];
        $division_id        = $statistic_array[0]['championship_division_id'];
        $season_id          = $statistic_array[0]['schedule_season_id'];
        $stage_id           = $statistic_array[0]['schedule_stage_id'];
        $tournamenttype_id  = $statistic_array[0]['schedule_tournamenttype_id'];

        if (in_array($tournamenttype_id, array(
            TOURNAMENTTYPE_FRIENDLY,
            TOURNAMENTTYPE_CONFERENCE,
            TOURNAMENTTYPE_LEAGUE,
            TOURNAMENTTYPE_OFFSEASON
        )))
        {
            $country_id = 0;
            $division_id = 0;
        }

        if (TOURNAMENTTYPE_NATIONAL == $tournamenttype_id)
        {
            $division_id = $statistic_array[0]['worldcup_division_id'];
        }

        if (!$country_id)
        {
            $country_id = 0;
        }

        if (!$division_id)
        {
            $division_id = 0;
        }

        if (TOURNAMENTTYPE_CHAMPIONSHIP == $tournamenttype_id && $stage_id >= STAGE_1_QUALIFY)
        {
            $is_playoff = 1;
        }
        else
        {
            $is_playoff = 0;
        }

        if ($game_result['guest']['player']['gk']['player_id'])
        {
            $sql = "UPDATE `statisticplayer`
                    SET `statisticplayer_assist`=`statisticplayer_assist`+" . $game_result['guest']['player']['gk']['assist'] . ",
                        `statisticplayer_assist_power`=`statisticplayer_assist_power`+" . $game_result['guest']['player']['gk']['assist_power'] . ",
                        `statisticplayer_assist_short`=`statisticplayer_assist_short`+" . $game_result['guest']['player']['gk']['assist_short'] . ",
                        `statisticplayer_game`=`statisticplayer_game`+" . $game_result['guest']['player']['gk']['game'] . ",
                        `statisticplayer_game_with_bullet`=`statisticplayer_game_with_bullet`+" . $game_result['guest']['player']['gk']['game_with_bullet'] . ",
                        `statisticplayer_loose`=`statisticplayer_loose`+" . $game_result['guest']['player']['gk']['loose'] . ",
                        `statisticplayer_pass`=`statisticplayer_pass`+" . $game_result['guest']['player']['gk']['pass'] . ",
                        `statisticplayer_point`=`statisticplayer_point`+" . $game_result['guest']['player']['gk']['point'] . ",
                        `statisticplayer_save`=`statisticplayer_save`+" . $game_result['guest']['player']['gk']['save'] . ",
                        `statisticplayer_shot_gk`=`statisticplayer_shot_gk`+" . $game_result['guest']['player']['gk']['shot'] . ",
                        `statisticplayer_shutout`=`statisticplayer_shutout`+" . $game_result['guest']['player']['gk']['shutout'] . ",
                        `statisticplayer_win`=`statisticplayer_win`+" . $game_result['guest']['player']['gk']['win'] . "
                    WHERE `statisticplayer_championship_playoff`=$is_playoff
                    AND `statisticplayer_country_id`=$country_id
                    AND `statisticplayer_division_id`=$division_id
                    AND `statisticplayer_is_gk`=1
                    AND `statisticplayer_national_id`=" . $game_result['game_info']['guest_national_id'] . "
                    AND `statisticplayer_player_id`=" . $game_result['guest']['player']['gk']['player_id'] . "
                    AND `statisticplayer_season_id`=$season_id
                    AND `statisticplayer_team_id`=" . $game_result['game_info']['guest_team_id'] . "
                    AND `statisticplayer_tournamenttype_id`=$tournamenttype_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }

        foreach ($game_result['guest']['player']['field'] as $player)
        {
            if ($player['player_id'])
            {
                $sql = "UPDATE `statisticplayer`
                        SET `statisticplayer_assist`=`statisticplayer_assist`+" . $player['assist'] . ",
                            `statisticplayer_assist_power`=`statisticplayer_assist_power`+" . $player['assist_power'] . ",
                            `statisticplayer_assist_short`=`statisticplayer_assist_short`+" . $player['assist_short'] . ",
                            `statisticplayer_bullet_win`=`statisticplayer_bullet_win`+" . $player['bullet_win'] . ",
                            `statisticplayer_face_off`=`statisticplayer_face_off`+" . $player['face_off'] . ",
                            `statisticplayer_face_off_win`=`statisticplayer_face_off_win`+" . $player['face_off_win'] . ",
                            `statisticplayer_game`=`statisticplayer_game`+" . $player['game'] . ",
                            `statisticplayer_loose`=`statisticplayer_loose`+" . $player['loose'] . ",
                            `statisticplayer_penalty`=`statisticplayer_penalty`+" . $player['penalty'] . "*2,
                            `statisticplayer_plus_minus`=`statisticplayer_plus_minus`+" . $player['plus_minus'] . ",
                            `statisticplayer_point`=`statisticplayer_point`+" . $player['point'] . ",
                            `statisticplayer_score`=`statisticplayer_score`+" . $player['score'] . ",
                            `statisticplayer_score_draw`=`statisticplayer_score_draw`+" . $player['score_draw'] . ",
                            `statisticplayer_score_power`=`statisticplayer_score_power`+" . $player['score_power'] . ",
                            `statisticplayer_score_short`=`statisticplayer_score_short`+" . $player['score_short'] . ",
                            `statisticplayer_score_win`=`statisticplayer_score_win`+" . $player['score_win'] . ",
                            `statisticplayer_shot`=`statisticplayer_shot`+" . $player['shot'] . ",
                            `statisticplayer_win`=`statisticplayer_win`+" . $player['win'] . "
                        WHERE `statisticplayer_championship_playoff`=$is_playoff
                        AND `statisticplayer_country_id`=$country_id
                        AND `statisticplayer_division_id`=$division_id
                        AND `statisticplayer_is_gk`=0
                        AND `statisticplayer_national_id`=" . $game_result['game_info']['guest_national_id'] . "
                        AND `statisticplayer_player_id`=" . $player['player_id'] . "
                        AND `statisticplayer_season_id`=$season_id
                        AND `statisticplayer_team_id`=" . $game_result['game_info']['guest_team_id'] . "
                        AND `statisticplayer_tournamenttype_id`=$tournamenttype_id
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
        }

        if ($game_result['home']['player']['gk']['player_id'])
        {
            $sql = "UPDATE `statisticplayer`
                    SET `statisticplayer_assist`=`statisticplayer_assist`+" . $game_result['home']['player']['gk']['assist'] . ",
                        `statisticplayer_assist_power`=`statisticplayer_assist_power`+" . $game_result['home']['player']['gk']['assist_power'] . ",
                        `statisticplayer_assist_short`=`statisticplayer_assist_short`+" . $game_result['home']['player']['gk']['assist_short'] . ",
                        `statisticplayer_game`=`statisticplayer_game`+" . $game_result['home']['player']['gk']['game'] . ",
                        `statisticplayer_game_with_bullet`=`statisticplayer_game_with_bullet`+" . $game_result['home']['player']['gk']['game_with_bullet'] . ",
                        `statisticplayer_loose`=`statisticplayer_loose`+" . $game_result['home']['player']['gk']['loose'] . ",
                        `statisticplayer_pass`=`statisticplayer_pass`+" . $game_result['home']['player']['gk']['pass'] . ",
                        `statisticplayer_point`=`statisticplayer_point`+" . $game_result['home']['player']['gk']['point'] . ",
                        `statisticplayer_save`=`statisticplayer_save`+" . $game_result['home']['player']['gk']['save'] . ",
                        `statisticplayer_shot_gk`=`statisticplayer_shot_gk`+" . $game_result['home']['player']['gk']['shot'] . ",
                        `statisticplayer_shutout`=`statisticplayer_shutout`+" . $game_result['home']['player']['gk']['shutout'] . ",
                        `statisticplayer_win`=`statisticplayer_win`+" . $game_result['home']['player']['gk']['win'] . "
                    WHERE `statisticplayer_championship_playoff`=$is_playoff
                    AND `statisticplayer_country_id`=$country_id
                    AND `statisticplayer_division_id`=$division_id
                    AND `statisticplayer_is_gk`=1
                    AND `statisticplayer_national_id`=" . $game_result['game_info']['home_national_id'] . "
                    AND `statisticplayer_player_id`=" . $game_result['home']['player']['gk']['player_id'] . "
                    AND `statisticplayer_season_id`=$season_id
                    AND `statisticplayer_team_id`=" . $game_result['game_info']['home_team_id'] . "
                    AND `statisticplayer_tournamenttype_id`=$tournamenttype_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }

        foreach ($game_result['home']['player']['field'] as $player)
        {
            if ($player['player_id'])
            {
                $sql = "UPDATE `statisticplayer`
                        SET `statisticplayer_assist`=`statisticplayer_assist`+" . $player['assist'] . ",
                            `statisticplayer_assist_power`=`statisticplayer_assist_power`+" . $player['assist_power'] . ",
                            `statisticplayer_assist_short`=`statisticplayer_assist_short`+" . $player['assist_short'] . ",
                            `statisticplayer_bullet_win`=`statisticplayer_bullet_win`+" . $player['bullet_win'] . ",
                            `statisticplayer_face_off`=`statisticplayer_face_off`+" . $player['face_off'] . ",
                            `statisticplayer_face_off_win`=`statisticplayer_face_off_win`+" . $player['face_off_win'] . ",
                            `statisticplayer_game`=`statisticplayer_game`+" . $player['game'] . ",
                            `statisticplayer_loose`=`statisticplayer_loose`+" . $player['loose'] . ",
                            `statisticplayer_penalty`=`statisticplayer_penalty`+" . $player['penalty'] . "*2,
                            `statisticplayer_plus_minus`=`statisticplayer_plus_minus`+" . $player['plus_minus'] . ",
                            `statisticplayer_point`=`statisticplayer_point`+" . $player['point'] . ",
                            `statisticplayer_score`=`statisticplayer_score`+" . $player['score'] . ",
                            `statisticplayer_score_draw`=`statisticplayer_score_draw`+" . $player['score_draw'] . ",
                            `statisticplayer_score_power`=`statisticplayer_score_power`+" . $player['score_power'] . ",
                            `statisticplayer_score_short`=`statisticplayer_score_short`+" . $player['score_short'] . ",
                            `statisticplayer_score_win`=`statisticplayer_score_win`+" . $player['score_win'] . ",
                            `statisticplayer_shot`=`statisticplayer_shot`+" . $player['shot'] . ",
                            `statisticplayer_win`=`statisticplayer_win`+" . $player['win'] . "
                        WHERE `statisticplayer_championship_playoff`=$is_playoff
                        AND `statisticplayer_country_id`=$country_id
                        AND `statisticplayer_division_id`=$division_id
                        AND `statisticplayer_is_gk`=0
                        AND `statisticplayer_national_id`=" . $game_result['game_info']['home_national_id'] . "
                        AND `statisticplayer_player_id`=" . $player['player_id'] . "
                        AND `statisticplayer_season_id`=$season_id
                        AND `statisticplayer_team_id`=" . $game_result['game_info']['home_team_id'] . "
                        AND `statisticplayer_tournamenttype_id`=$tournamenttype_id
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
        }

        $sql = "UPDATE `statisticteam`
                SET `statisticteam_game`=`statisticteam_game`+" . $game_result['guest']['team']['game'] . ",
                    `statisticteam_game_no_pass`=`statisticteam_game_no_pass`+" . $game_result['guest']['team']['no_pass'] . ",
                    `statisticteam_game_no_score`=`statisticteam_game_no_score`+" . $game_result['guest']['team']['no_score'] . ",
                    `statisticteam_loose`=`statisticteam_loose`+" . $game_result['guest']['team']['loose'] . ",
                    `statisticteam_loose_bullet`=`statisticteam_loose_bullet`+" . $game_result['guest']['team']['loose_bullet'] . ",
                    `statisticteam_loose_over`=`statisticteam_loose_over`+" . $game_result['guest']['team']['loose_over'] . ",
                    `statisticteam_pass`=`statisticteam_pass`+" . $game_result['guest']['team']['pass'] . ",
                    `statisticteam_penalty`=`statisticteam_penalty`+" . $game_result['guest']['team']['penalty']['total'] . "*2,
                    `statisticteam_penalty_opponent`=`statisticteam_penalty_opponent`+" . $game_result['guest']['team']['penalty']['total'] . "*2,
                    `statisticteam_score`=`statisticteam_score`+" . $game_result['guest']['team']['score']['total'] . ",
                    `statisticteam_win`=`statisticteam_win`+" . $game_result['guest']['team']['win'] . ",
                    `statisticteam_win_bullet`=`statisticteam_win_bullet`+" . $game_result['guest']['team']['win_bullet'] . ",
                    `statisticteam_win_over`=`statisticteam_win_over`+" . $game_result['guest']['team']['win_over'] . "
                WHERE `statisticteam_championship_playoff`=$is_playoff
                AND `statisticteam_country_id`=$country_id
                AND `statisticteam_division_id`=$division_id
                AND `statisticteam_national_id`=" . $game_result['game_info']['guest_national_id'] . "
                AND `statisticteam_season_id`=$season_id
                AND `statisticteam_team_id`=" . $game_result['game_info']['guest_team_id'] . "
                AND `statisticteam_tournamenttype_id`=$tournamenttype_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `statisticteam`
                SET `statisticteam_game`=`statisticteam_game`+" . $game_result['home']['team']['game'] . ",
                    `statisticteam_game_no_pass`=`statisticteam_game_no_pass`+" . $game_result['home']['team']['no_pass'] . ",
                    `statisticteam_game_no_score`=`statisticteam_game_no_score`+" . $game_result['home']['team']['no_score'] . ",
                    `statisticteam_loose`=`statisticteam_loose`+" . $game_result['home']['team']['loose'] . ",
                    `statisticteam_loose_bullet`=`statisticteam_loose_bullet`+" . $game_result['home']['team']['loose_bullet'] . ",
                    `statisticteam_loose_over`=`statisticteam_loose_over`+" . $game_result['home']['team']['loose_over'] . ",
                    `statisticteam_pass`=`statisticteam_pass`+" . $game_result['home']['team']['pass'] . ",
                    `statisticteam_penalty`=`statisticteam_penalty`+" . $game_result['home']['team']['penalty']['total'] . "*2,
                    `statisticteam_penalty_opponent`=`statisticteam_penalty_opponent`+" . $game_result['home']['team']['penalty']['total'] . "*2,
                    `statisticteam_score`=`statisticteam_score`+" . $game_result['home']['team']['score']['total'] . ",
                    `statisticteam_win`=`statisticteam_win`+" . $game_result['home']['team']['win'] . ",
                    `statisticteam_win_bullet`=`statisticteam_win_bullet`+" . $game_result['home']['team']['win_bullet'] . ",
                    `statisticteam_win_over`=`statisticteam_win_over`+" . $game_result['home']['team']['win_over'] . "
                WHERE `statisticteam_championship_playoff`=$is_playoff
                AND `statisticteam_country_id`=$country_id
                AND `statisticteam_division_id`=$division_id
                AND `statisticteam_national_id`=" . $game_result['game_info']['home_national_id'] . "
                AND `statisticteam_season_id`=$season_id
                AND `statisticteam_team_id`=" . $game_result['game_info']['home_team_id'] . "
                AND `statisticteam_tournamenttype_id`=$tournamenttype_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }
}