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

        $field_player_array = array();

        for ($j=1; $j<=3; $j++)
        {
            for ($k=POSITION_LD; $k<=POSITION_RW; $k++)
            {
                if     (POSITION_LD == $k) { $key = 'ld'; }
                elseif (POSITION_RD == $k) { $key = 'rd'; }
                elseif (POSITION_LW == $k) { $key = 'lw'; }
                elseif (POSITION_C  == $k) { $key =  'c'; }
                else                       { $key = 'rw'; }

                $key = $key . '_' . $j;

                $field_player_array[$key] = array(
                    'age'           => 0,
                    'assist'        => 0,
                    'lineup_id'     => 0,
                    'penalty'       => 0,
                    'player_id'     => 0,
                    'plus_minus'    => 0,
                    'power_nominal' => 0,
                    'power_real'    => 0,
                    'score'         => 0,
                    'shot'          => 0,
                );
            }
        }

        $team_array = array(
            'player' => array(
                'gk' => array(
                    'age'           => 0,
                    'assist'        => 0,
                    'lineup_id'     => 0,
                    'pass'          => 0,
                    'player_id'     => 0,
                    'power_nominal' => 0,
                    'power_real'    => 0,
                    'shot'          => 0,
                ),
                'field' => $field_player_array,
            ),
            'team' => array(
                'penalty' => array(
                    1 => 0,
                    2 => 0,
                    3 => 0,
                    'current' => array(),
                    'total' => 0,
                ),
                'power' => array(
                    'defence' => array(
                        1 => 0,
                        2 => 0,
                        3 => 0,
                        'current' => 0,
                    ),
                    'forward' => array(
                        1 => 0,
                        2 => 0,
                        3 => 0,
                        'current' => 0,
                    ),
                    'gk'    => 0,
                    'shot'  => 0,
                    'total' => 0,
                ),
                'score' => array(
                    1 => 0,
                    2 => 0,
                    3 => 0,
                    'total' => 0,
                ),
                'shot' => array(
                    1 => 0,
                    2 => 0,
                    3 => 0,
                    'total' => 0,
                ),
            ),
        );

        $game_result = array(
            'event'     => array(),
            'game_info' => array(
                'game_id'       => $game_id,
                'guest_team_id' => $game_guest_team_id,
                'home_team_id'  => $game_home_team_id,
            ),
            'guest'     => $team_array,
            'home'      => $team_array,
            'minute'    => 0,
            'player'    => 0,
            'assist_1'  => 0,
            'assist_2'  => 0,
        );

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
                       `player_id`,
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

        $game_result['guest']['player']['gk']['age']            = $guest_lineup_array[0]['player_age'];
        $game_result['guest']['player']['gk']['lineup_id']      = $guest_lineup_array[0]['lineup_id'];
        $game_result['guest']['player']['gk']['player_id']      = $guest_lineup_array[0]['player_id'];
        $game_result['guest']['player']['gk']['power_nominal']  = $guest_lineup_array[0]['player_power_nominal'];
        $game_result['guest']['player']['gk']['power_real']     = $guest_lineup_array[0]['player_power_real'];
        
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

            $game_result['guest']['player']['field'][$key]['age']           = $guest_lineup_array[$j]['player_age'];
            $game_result['guest']['player']['field'][$key]['lineup_id']     = $guest_lineup_array[$j]['lineup_id'];
            $game_result['guest']['player']['field'][$key]['player_id']     = $guest_lineup_array[$j]['player_id'];
            $game_result['guest']['player']['field'][$key]['power_nominal'] = $guest_lineup_array[$j]['player_power_nominal'];
            $game_result['guest']['player']['field'][$key]['power_real']    = $guest_lineup_array[$j]['player_power_real'];
        }

        $game_result['guest']['team']['power']['gk'] = $game_result['guest']['player']['gk']['power_real'];
        $game_result['guest']['team']['power']['defence'][1]
            = $game_result['guest']['player']['field']['ld_1']['power_real']
            + $game_result['guest']['player']['field']['rd_1']['power_real'];
        $game_result['guest']['team']['power']['defence'][2]
            = $game_result['guest']['player']['field']['ld_2']['power_real']
            + $game_result['guest']['player']['field']['rd_2']['power_real'];
        $game_result['guest']['team']['power']['defence'][3]
            = $game_result['guest']['player']['field']['ld_3']['power_real']
            + $game_result['guest']['player']['field']['rd_3']['power_real'];
        $game_result['guest']['team']['power']['forward'][1]
            = $game_result['guest']['player']['field']['lw_1']['power_real']
            + $game_result['guest']['player']['field']['c_1']['power_real']
            + $game_result['guest']['player']['field']['rw_1']['power_real'];
        $game_result['guest']['team']['power']['forward'][2]
            = $game_result['guest']['player']['field']['lw_2']['power_real']
            + $game_result['guest']['player']['field']['c_2']['power_real']
            + $game_result['guest']['player']['field']['rw_2']['power_real'];
        $game_result['guest']['team']['power']['forward'][3]
            = $game_result['guest']['player']['field']['lw_2']['power_real']
            + $game_result['guest']['player']['field']['c_2']['power_real']
            + $game_result['guest']['player']['field']['rw_2']['power_real'];
        $game_result['guest']['team']['power']['total']
            = $game_result['guest']['team']['power']['gk']
            + $game_result['guest']['team']['power']['defence'][1]
            + $game_result['guest']['team']['power']['defence'][2]
            + $game_result['guest']['team']['power']['defence'][3]
            + $game_result['guest']['team']['power']['forward'][1]
            + $game_result['guest']['team']['power']['forward'][2]
            + $game_result['guest']['team']['power']['forward'][3];

        $sql = "SELECT `lineup_id`,
                       `player_age`,
                       `player_id`,
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

        $game_result['home']['player']['gk']['age']             = $home_lineup_array[0]['player_age'];
        $game_result['home']['player']['gk']['lineup_id']       = $home_lineup_array[0]['lineup_id'];
        $game_result['home']['player']['gk']['player_id']       = $home_lineup_array[0]['player_id'];
        $game_result['home']['player']['gk']['power_nominal']   = $home_lineup_array[0]['player_power_nominal'];
        $game_result['home']['player']['gk']['power_real']      = round($home_lineup_array[0]['player_power_real'] * $home_bonus, 0);

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

            $game_result['home']['player']['field'][$key]['age']           = $guest_lineup_array[$j]['player_age'];
            $game_result['home']['player']['field'][$key]['lineup_id']     = $guest_lineup_array[$j]['lineup_id'];
            $game_result['home']['player']['field'][$key]['player_id']     = $guest_lineup_array[$j]['player_id'];
            $game_result['home']['player']['field'][$key]['power_nominal'] = $guest_lineup_array[$j]['player_power_nominal'];
            $game_result['home']['player']['field'][$key]['power_real']    = round($home_lineup_array[$j]['player_power_real'] * $home_bonus, 0);
        }

        $game_result['home']['team']['power']['gk'] = $game_result['home']['player']['gk']['power_real'];
        $game_result['home']['team']['power']['defence'][1]
            = $game_result['home']['player']['field']['ld_1']['power_real']
            + $game_result['home']['player']['field']['rd_1']['power_real'];
        $game_result['home']['team']['power']['defence'][2]
            = $game_result['home']['player']['field']['ld_2']['power_real']
            + $game_result['home']['player']['field']['rd_2']['power_real'];
        $game_result['home']['team']['power']['defence'][3]
            = $game_result['home']['player']['field']['ld_3']['power_real']
            + $game_result['home']['player']['field']['rd_3']['power_real'];
        $game_result['home']['team']['power']['forward'][1]
            = $game_result['home']['player']['field']['lw_1']['power_real']
            + $game_result['home']['player']['field']['c_1']['power_real']
            + $game_result['home']['player']['field']['rw_1']['power_real'];
        $game_result['home']['team']['power']['forward'][2]
            = $game_result['home']['player']['field']['lw_2']['power_real']
            + $game_result['home']['player']['field']['c_2']['power_real']
            + $game_result['home']['player']['field']['rw_2']['power_real'];
        $game_result['home']['team']['power']['forward'][3]
            = $game_result['home']['player']['field']['lw_2']['power_real']
            + $game_result['home']['player']['field']['c_2']['power_real']
            + $game_result['home']['player']['field']['rw_2']['power_real'];
        $game_result['home']['team']['power']['total']
            = $game_result['home']['team']['power']['gk']
            + $game_result['home']['team']['power']['defence'][1]
            + $game_result['home']['team']['power']['defence'][2]
            + $game_result['home']['team']['power']['defence'][3]
            + $game_result['home']['team']['power']['forward'][1]
            + $game_result['home']['team']['power']['forward'][2]
            + $game_result['home']['team']['power']['forward'][3];

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

            if (rand(
                    0,
                    $game_result['home']['team']['power']['defence']['current']
                    /
                    (1 + $home_penalty_current)
                ) > rand(
                    0,
                    $game_result['guest']['team']['power']['forward']['current']
                    /
                    (2 + $guest_penalty_current)
                ))
            {
                if (rand(
                        0,
                        $game_result['home']['team']['power']['forward']['current']
                        /
                        (1 + $home_penalty_current)
                    ) > rand(
                        0,
                        $game_result['guest']['team']['power']['defence']['current']
                        /
                        (2 + $guest_penalty_current)
                    ))
                {
                    $game_result = f_igosja_select_player_shot($game_result, 'home');
                    $game_result = f_igosja_team_shot_increase($game_result, 'home', 'guest');
                    $game_result = f_igosja_player_shot_increase($game_result, 'home');
                    $game_result = f_igosja_player_shot_power($game_result, 'home');

                    if (rand(
                            0,
                            $game_result['home']['team']['power']['shot']
                        ) > rand(
                            0,
                            $game_result['guest']['team']['power']['gk'] * 6
                        ))
                    {
                        $game_result = f_igosja_assist_1($game_result, 'home');
                        $game_result = f_igosja_assist_2($game_result, 'home');
                        $game_result = f_igosja_team_score_increase($game_result, 'home', 'guest');
                        $game_result = f_igosja_event_score($game_result, 'home');
                        $game_result = f_igosja_plus_minus_increase($game_result, 'home', 'guest');
                        $game_result = f_igosja_player_score_increase($game_result, 'home');
                        $game_result = f_igosja_player_assist_1_increase($game_result, 'home');
                        $game_result = f_igosja_player_assist_2_increase($game_result, 'home');
                        $game_result = f_igosja_current_penalty_decrease_after_goal($game_result, 'home', 'guest');
                    }
                }
            }

            if (rand(
                    0,
                    $game_result['guest']['team']['power']['defence']['current']
                    /
                    (1 + $guest_penalty_current)
                ) > rand(
                    0,
                    $game_result['home']['team']['power']['forward']['current']
                    /
                    (2 + $home_penalty_current)
                ))
            {
                if (rand(
                        0,
                        $game_result['guest']['team']['power']['forward']['current']
                        /
                        (1 + $guest_penalty_current)
                    ) > rand(
                        0,
                        $game_result['home']['team']['power']['defence']['current']
                        /
                        (2 + $home_penalty_current)
                    ))
                {
                    $game_result = f_igosja_select_player_shot($game_result, 'guest');
                    $game_result = f_igosja_team_shot_increase($game_result, 'guest', 'home');
                    $game_result = f_igosja_player_shot_increase($game_result, 'guest');
                    $game_result = f_igosja_player_shot_power($game_result, 'guest');

                    if (rand(
                            0,
                            $game_result['guest']['team']['power']['shot']
                        ) > rand(
                            0,
                            $game_result['home']['team']['power']['gk'] * 6
                        ))
                    {
                        $game_result = f_igosja_assist_1($game_result, 'guest');
                        $game_result = f_igosja_assist_2($game_result, 'guest');
                        $game_result = f_igosja_team_score_increase($game_result, 'guest', 'home');
                        $game_result = f_igosja_event_score($game_result, 'guest');
                        $game_result = f_igosja_plus_minus_increase($game_result, 'guest', 'home');
                        $game_result = f_igosja_player_score_increase($game_result, 'guest');
                        $game_result = f_igosja_player_assist_1_increase($game_result, 'guest');
                        $game_result = f_igosja_player_assist_2_increase($game_result, 'guest');
                        $game_result = f_igosja_current_penalty_decrease_after_goal($game_result, 'guest', 'home');
                    }
                }
            }
        }

        $sql = "UPDATE `game`
                SET `game_guest_penalty`='" . $game_result['guest']['team']['penalty']['total'] . "'*'2',
                    `game_guest_penalty_1`='" . $game_result['guest']['team']['penalty'][1] . "'*'2',
                    `game_guest_penalty_2`='" . $game_result['guest']['team']['penalty'][2] . "'*'2',
                    `game_guest_penalty_3`='" . $game_result['guest']['team']['penalty'][3] . "'*'2',
                    `game_guest_power`='" . $game_result['guest']['team']['power']['total'] . "',
                    `game_guest_score`='" . $game_result['guest']['team']['score']['total'] . "',
                    `game_guest_score_1`='" . $game_result['guest']['team']['score'][1] . "',
                    `game_guest_score_2`='" . $game_result['guest']['team']['score'][2] . "',
                    `game_guest_score_3`='" . $game_result['guest']['team']['score'][3] . "',
                    `game_guest_shot`='" . $game_result['guest']['team']['shot']['total'] . "',
                    `game_guest_shot_1`='" . $game_result['guest']['team']['shot'][1] . "',
                    `game_guest_shot_2`='" . $game_result['guest']['team']['shot'][2] . "',
                    `game_guest_shot_3`='" . $game_result['guest']['team']['shot'][3] . "',
                    `game_home_penalty`='" . $game_result['home']['team']['penalty']['total'] . "'*'2',
                    `game_home_penalty_1`='" . $game_result['home']['team']['penalty'][1] . "'*'2',
                    `game_home_penalty_2`='" . $game_result['home']['team']['penalty'][2] . "'*'2',
                    `game_home_penalty_3`='" . $game_result['home']['team']['penalty'][3] . "'*'2',
                    `game_home_power`='" . $game_result['home']['team']['power']['total'] . "',
                    `game_home_score`='" . $game_result['home']['team']['score']['total'] . "',
                    `game_home_score_1`='" . $game_result['home']['team']['score'][1] . "',
                    `game_home_score_2`='" . $game_result['home']['team']['score'][2] . "',
                    `game_home_score_3`='" . $game_result['home']['team']['score'][3] . "',
                    `game_home_shot`='" . $game_result['home']['team']['shot']['total'] . "',
                    `game_home_shot_1`='" . $game_result['home']['team']['shot'][1] . "',
                    `game_home_shot_2`='" . $game_result['home']['team']['shot'][2] . "',
                    `game_home_shot_3`='" . $game_result['home']['team']['shot'][3] . "',
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