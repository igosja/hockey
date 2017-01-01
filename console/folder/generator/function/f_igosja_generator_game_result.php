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
        $game_id                = $game['game_id'];
        $game_bonus_home        = $game['game_bonus_home'];
        $game_guest_team_id     = $game['game_guest_team_id'];
        $game_home_team_id      = $game['game_home_team_id'];
        $game_stadium_capacity  = $game['game_stadium_capacity'];
        $game_visitor           = $game['game_visitor'];

        $game_result = f_igosja_prepare_game_result_array($game_id, $game_home_team_id, $game_guest_team_id);
        $game_result = f_igosja_count_home_bonus($game_result, $game_bonus_home, $game_visitor, $game_stadium_capacity);
        $game_result = f_igosja_get_player_info($game_result, 'home');
        $game_result = f_igosja_get_player_info($game_result, 'guest');

        for ($game_result['minute']=0; $game_result['minute']<60; $game_result['minute']++)
        {
            $game_result = f_igosja_defence($game_result, 'home');
            $game_result = f_igosja_forward($game_result, 'home');
            $game_result = f_igosja_defence($game_result, 'guest');
            $game_result = f_igosja_forward($game_result, 'guest');

            if (rand(0, 40) >= 34 && 1 == rand(0, 1))
            {
                $game_result['player'] = rand(POSITION_LD, POSITION_RW);

                $game_result = f_igosja_event_penalty($game_result, 'home');
                $game_result = f_igosja_player_penalty_increase($game_result, 'home');
                $game_result = f_igosja_current_penalty_increase($game_result, 'home');
                $game_result = f_igosja_team_penalty_increase($game_result, 'home');
            }

            if (rand(0, 40) >= 34 && 1 == rand(0, 1))
            {
                $game_result['player'] = rand(POSITION_LD, POSITION_RW);

                $game_result = f_igosja_event_penalty($game_result, 'guest');
                $game_result = f_igosja_player_penalty_increase($game_result, 'guest');
                $game_result = f_igosja_current_penalty_increase($game_result, 'guest');
                $game_result = f_igosja_team_penalty_increase($game_result, 'guest');
            }

            $game_result = f_igosja_current_penalty_decrease($game_result, 'home');
            $game_result = f_igosja_current_penalty_decrease($game_result, 'guest');
            $game_result = f_igosja_face_off($game_result);

            $home_penalty_current = count($game_result['home']['team']['penalty']['current']);

            if (2 < $home_penalty_current)
            {
                $home_penalty_current = 2;
            }

            $guest_penalty_current = count($game_result['guest']['team']['penalty']['current']);

            if (2 < $guest_penalty_current)
            {
                $guest_penalty_current = 2;
            }

            $defence = $game_result['home']['team']['power']['defence']['current'] / (1 + $home_penalty_current);
            $forward = $game_result['guest']['team']['power']['forward']['current'] / (2 + $guest_penalty_current);

            if (rand(0, $defence) > rand(0, $forward))
            {
                $forward = $game_result['home']['team']['power']['forward']['current'] / (1 + $home_penalty_current);
                $defence = $game_result['guest']['team']['power']['defence']['current'] / (2 + $guest_penalty_current);

                if (rand(0, $forward) > rand(0, $defence))
                {
                    $game_result = f_igosja_select_player_shot($game_result, 'home');
                    $game_result = f_igosja_team_shot_increase($game_result, 'home', 'guest');
                    $game_result = f_igosja_player_shot_increase($game_result, 'home');
                    $game_result = f_igosja_player_shot_power($game_result, 'home');

                    $shot_power = $game_result['home']['team']['power']['shot'];
                    $gk_power   = $game_result['guest']['team']['power']['gk'];

                    if (rand(0, $shot_power) > rand(0, $gk_power * 6))
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
            }

            $defence = $game_result['guest']['team']['power']['defence']['current'] / (1 + $guest_penalty_current);
            $forward = $game_result['home']['team']['power']['forward']['current'] / (2 + $home_penalty_current);

            if (rand(0, $defence) > rand(0, $forward))
            {
                $forward = $game_result['guest']['team']['power']['forward']['current'] / (1 + $guest_penalty_current);
                $defence = $game_result['home']['team']['power']['defence']['current'] / (2 + $home_penalty_current);

                if (rand(0, $forward) > rand(0, $defence))
                {
                    $game_result = f_igosja_select_player_shot($game_result, 'guest');
                    $game_result = f_igosja_team_shot_increase($game_result, 'guest', 'home');
                    $game_result = f_igosja_player_shot_increase($game_result, 'guest');
                    $game_result = f_igosja_player_shot_power($game_result, 'guest');

                    $shot_power = $game_result['guest']['team']['power']['shot'];
                    $gk_power   = $game_result['home']['team']['power']['gk'];

                    if (rand(0, $shot_power) > rand(0, $gk_power * 6))
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
        }

        if ($game_result['home']['team']['score']['total'] == $game_result['guest']['team']['score']['total'])
        {
            for ($game_result['minute']=60; $game_result['minute']<65; $game_result['minute']++)
            {
                $game_result = f_igosja_defence($game_result, 'home');
                $game_result = f_igosja_forward($game_result, 'home');
                $game_result = f_igosja_defence($game_result, 'guest');
                $game_result = f_igosja_forward($game_result, 'guest');

                if (rand(0, 40) >= 34 && 1 == rand(0, 1))
                {
                    $game_result['player'] = rand(POSITION_LD, POSITION_RW);

                    $game_result = f_igosja_event_penalty($game_result, 'home');
                    $game_result = f_igosja_player_penalty_increase($game_result, 'home');
                    $game_result = f_igosja_current_penalty_increase($game_result, 'home');
                    $game_result = f_igosja_team_penalty_increase($game_result, 'home');
                }

                if (rand(0, 40) >= 34 && 1 == rand(0, 1))
                {
                    $game_result['player'] = rand(POSITION_LD, POSITION_RW);

                    $game_result = f_igosja_event_penalty($game_result, 'guest');
                    $game_result = f_igosja_player_penalty_increase($game_result, 'guest');
                    $game_result = f_igosja_current_penalty_increase($game_result, 'guest');
                    $game_result = f_igosja_team_penalty_increase($game_result, 'guest');
                }

                $game_result = f_igosja_current_penalty_decrease($game_result, 'home');
                $game_result = f_igosja_current_penalty_decrease($game_result, 'guest');
                $game_result = f_igosja_face_off($game_result);

                $home_penalty_current = count($game_result['home']['team']['penalty']['current']);

                if (2 < $home_penalty_current)
                {
                    $home_penalty_current = 2;
                }

                $guest_penalty_current = count($game_result['guest']['team']['penalty']['current']);

                if (2 < $guest_penalty_current)
                {
                    $guest_penalty_current = 2;
                }

                $defence = $game_result['home']['team']['power']['defence']['current'] / (1 + $home_penalty_current);
                $forward = $game_result['guest']['team']['power']['forward']['current'] / (2 + $guest_penalty_current);

                if (rand(0, $defence) > rand(0, $forward))
                {
                    $forward = $game_result['home']['team']['power']['forward']['current'] / (1 + $home_penalty_current);
                    $defence = $game_result['guest']['team']['power']['defence']['current'] / (2 + $guest_penalty_current);

                    if (rand(0, $forward) > rand(0, $defence))
                    {
                        $game_result = f_igosja_select_player_shot($game_result, 'home');
                        $game_result = f_igosja_team_shot_increase($game_result, 'home', 'guest');
                        $game_result = f_igosja_player_shot_increase($game_result, 'home');
                        $game_result = f_igosja_player_shot_power($game_result, 'home');

                        $shot_power = $game_result['home']['team']['power']['shot'];
                        $gk_power   = $game_result['guest']['team']['power']['gk'];

                        if (rand(0, $shot_power) > rand(0, $gk_power * 6))
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
                }

                if (65 > $game_result['minute'])
                {
                    $defence = $game_result['guest']['team']['power']['defence']['current'] / (1 + $guest_penalty_current);
                    $forward = $game_result['home']['team']['power']['forward']['current'] / (2 + $home_penalty_current);

                    if (rand(0, $defence) > rand(0, $forward))
                    {
                        $forward = $game_result['guest']['team']['power']['forward']['current'] / (1 + $guest_penalty_current);
                        $defence = $game_result['home']['team']['power']['defence']['current'] / (2 + $home_penalty_current);

                        if (rand(0, $forward) > rand(0, $defence))
                        {
                            $game_result = f_igosja_select_player_shot($game_result, 'guest');
                            $game_result = f_igosja_team_shot_increase($game_result, 'guest', 'home');
                            $game_result = f_igosja_player_shot_increase($game_result, 'guest');
                            $game_result = f_igosja_player_shot_power($game_result, 'guest');

                            $shot_power = $game_result['guest']['team']['power']['shot'];
                            $gk_power   = $game_result['home']['team']['power']['gk'];

                            if (rand(0, $shot_power) > rand(0, $gk_power * 6))
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
        }

        if ($game_result['home']['team']['score']['total'] == $game_result['guest']['team']['score']['total'])
        {
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
                }
                else
                {
                    $game_result = f_igosja_event_bullet($game_result, 'guest', EVENTTEXT_BULLET_NO_SCORE, $guest_power_array[$key][0]);
                }

                if ($game_result['home']['team']['score']['total'] != $game_result['guest']['team']['score']['total'])
                {
                    $continue = false;
                }
            }
        }

        $sql = "UPDATE `game`
                SET `game_guest_penalty`='" . $game_result['guest']['team']['penalty']['total'] . "'*'2',
                    `game_guest_penalty_1`='" . $game_result['guest']['team']['penalty'][1] . "'*'2',
                    `game_guest_penalty_2`='" . $game_result['guest']['team']['penalty'][2] . "'*'2',
                    `game_guest_penalty_3`='" . $game_result['guest']['team']['penalty'][3] . "'*'2',
                    `game_guest_penalty_over`='" . $game_result['guest']['team']['penalty']['over'] . "'*'2',
                    `game_guest_power`='" . $game_result['guest']['team']['power']['total'] . "',
                    `game_guest_score`='" . $game_result['guest']['team']['score']['total'] . "',
                    `game_guest_score_1`='" . $game_result['guest']['team']['score'][1] . "',
                    `game_guest_score_2`='" . $game_result['guest']['team']['score'][2] . "',
                    `game_guest_score_3`='" . $game_result['guest']['team']['score'][3] . "',
                    `game_guest_score_bullet`='" . $game_result['guest']['team']['score']['bullet'] . "',
                    `game_guest_score_over`='" . $game_result['guest']['team']['score']['over'] . "',
                    `game_guest_shot`='" . $game_result['guest']['team']['shot']['total'] . "',
                    `game_guest_shot_1`='" . $game_result['guest']['team']['shot'][1] . "',
                    `game_guest_shot_2`='" . $game_result['guest']['team']['shot'][2] . "',
                    `game_guest_shot_3`='" . $game_result['guest']['team']['shot'][3] . "',
                    `game_guest_shot_over`='" . $game_result['guest']['team']['shot']['over'] . "',
                    `game_home_penalty`='" . $game_result['home']['team']['penalty']['total'] . "'*'2',
                    `game_home_penalty_1`='" . $game_result['home']['team']['penalty'][1] . "'*'2',
                    `game_home_penalty_2`='" . $game_result['home']['team']['penalty'][2] . "'*'2',
                    `game_home_penalty_3`='" . $game_result['home']['team']['penalty'][3] . "'*'2',
                    `game_home_penalty_over`='" . $game_result['home']['team']['penalty']['over'] . "'*'2',
                    `game_home_power`='" . $game_result['home']['team']['power']['total'] . "',
                    `game_home_score`='" . $game_result['home']['team']['score']['total'] . "',
                    `game_home_score_1`='" . $game_result['home']['team']['score'][1] . "',
                    `game_home_score_2`='" . $game_result['home']['team']['score'][2] . "',
                    `game_home_score_3`='" . $game_result['home']['team']['score'][3] . "',
                    `game_home_score_bullet`='" . $game_result['home']['team']['score']['bullet'] . "',
                    `game_home_score_over`='" . $game_result['home']['team']['score']['over'] . "',
                    `game_home_shot`='" . $game_result['home']['team']['shot']['total'] . "',
                    `game_home_shot_1`='" . $game_result['home']['team']['shot'][1] . "',
                    `game_home_shot_2`='" . $game_result['home']['team']['shot'][2] . "',
                    `game_home_shot_3`='" . $game_result['home']['team']['shot'][3] . "',
                    `game_home_shot_over`='" . $game_result['home']['team']['shot']['over'] . "',
                    `game_played`='1'
                WHERE `game_id`='$game_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        foreach ($game_result['event'] as $event)
        {
            $sql = "INSERT INTO `event`
                    SET `event_eventtextbullet_id`='" . $event['event_eventtextbullet_id'] . "',
                        `event_eventtextgoal_id`='" . $event['event_eventtextgoal_id'] . "',
                        `event_eventtextpenalty_id`='" . $event['event_eventtextpenalty_id'] . "',
                        `event_eventtype_id`='" . $event['event_eventtype_id'] . "',
                        `event_game_id`='" . $event['event_game_id'] . "',
                        `event_guest_score`='" . $event['event_guest_score'] . "',
                        `event_home_score`='" . $event['event_home_score'] . "',
                        `event_minute`='" . $event['event_minute'] . "',
                        `event_player_assist_1_id`='" . $event['event_player_assist_1_id'] . "',
                        `event_player_assist_2_id`='" . $event['event_player_assist_2_id'] . "',
                        `event_player_penalty_id`='" . $event['event_player_penalty_id'] . "',
                        `event_player_score_id`='" . $event['event_player_score_id'] . "',
                        `event_second`='" . $event['event_second'] . "',
                        `event_team_id`='" . $event['event_team_id'] . "'";
            f_igosja_mysqli_query($sql);
        }

        $sql = "UPDATE `lineup`
                SET `lineup_age`='" . $game_result['guest']['player']['gk']['age'] . "',
                    `lineup_assist`='" . $game_result['guest']['player']['gk']['assist'] . "',
                    `lineup_pass`='" . $game_result['guest']['player']['gk']['pass'] . "',
                    `lineup_power_nominal`='" . $game_result['guest']['player']['gk']['power_nominal'] . "',
                    `lineup_power_real`='" . $game_result['guest']['player']['gk']['power_real'] . "',
                    `lineup_shot`='" . $game_result['guest']['player']['gk']['shot'] . "'
                WHERE `lineup_id`='" . $game_result['guest']['player']['gk']['lineup_id'] . "'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        foreach ($game_result['guest']['player']['field'] as $player)
        {
            $sql = "UPDATE `lineup`
                    SET `lineup_age`='" . $player['age'] . "',
                        `lineup_assist`='" . $player['assist'] . "',
                        `lineup_penalty`='" . $player['penalty'] . "'*'2',
                        `lineup_plus_minus`='" . $player['plus_minus'] . "',
                        `lineup_power_nominal`='" . $player['power_nominal'] . "',
                        `lineup_power_real`='" . $player['power_real'] . "',
                        `lineup_score`='" . $player['score'] . "',
                        `lineup_shot`='" . $player['shot'] . "'
                    WHERE `lineup_id`='" . $player['lineup_id'] . "'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }

        $sql = "UPDATE `lineup`
                SET `lineup_age`='" . $game_result['home']['player']['gk']['age'] . "',
                    `lineup_assist`='" . $game_result['home']['player']['gk']['assist'] . "',
                    `lineup_pass`='" . $game_result['home']['player']['gk']['pass'] . "',
                    `lineup_power_nominal`='" . $game_result['home']['player']['gk']['power_nominal'] . "',
                    `lineup_power_real`='" . $game_result['home']['player']['gk']['power_real'] . "',
                    `lineup_shot`='" . $game_result['home']['player']['gk']['shot'] . "'
                WHERE `lineup_id`='" . $game_result['home']['player']['gk']['lineup_id'] . "'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        foreach ($game_result['home']['player']['field'] as $player)
        {
            $sql = "UPDATE `lineup`
                    SET `lineup_age`='" . $player['age'] . "',
                        `lineup_assist`='" . $player['assist'] . "',
                        `lineup_penalty`='" . $player['penalty'] . "'*'2',
                        `lineup_plus_minus`='" . $player['plus_minus'] . "',
                        `lineup_power_nominal`='" . $player['power_nominal'] . "',
                        `lineup_power_real`='" . $player['power_real'] . "',
                        `lineup_score`='" . $player['score'] . "',
                        `lineup_shot`='" . $player['shot'] . "'
                    WHERE `lineup_id`='" . $player['lineup_id'] . "'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }

        usleep(1);

        print '.';
        flush();
    }
}