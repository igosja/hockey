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

        $game_result = array(
            'event' => array(),
            'game_info' => array(
                'game_id' => $game_id,
                'guest_team_id' => $game_guest_team_id,
                'home_team_id' => $game_home_team_id,
            ),
            'guest' => array(
                'player' => array(
                    'gk' => array(
                        'age' => 0,
                        'assist' => 0,
                        'lineup_id' => 0,
                        'pass' => 0,
                        'player_id' => 0,
                        'power_nominal' => 0,
                        'power_real' => 0,
                        'shot' => 0,
                    ),
                    'field' => array(
                        'ld_1' => array(
                            'age' => 0,
                            'assist' => 0,
                            'lineup_id' => 0,
                            'penalty' => 0,
                            'player_id' => 0,
                            'plus_minus' => 0,
                            'power_nominal' => 0,
                            'power_real' => 0,
                            'score' => 0,
                            'shot' => 0,
                        ),
                        'rd_1' => array(
                            'age' => 0,
                            'assist' => 0,
                            'lineup_id' => 0,
                            'penalty' => 0,
                            'player_id' => 0,
                            'plus_minus' => 0,
                            'power_nominal' => 0,
                            'power_real' => 0,
                            'score' => 0,
                            'shot' => 0,
                        ),
                        'lf_1' => array(
                            'age' => 0,
                            'assist' => 0,
                            'lineup_id' => 0,
                            'penalty' => 0,
                            'player_id' => 0,
                            'plus_minus' => 0,
                            'power_nominal' => 0,
                            'power_real' => 0,
                            'score' => 0,
                            'shot' => 0,
                        ),
                        'c_1' => array(
                            'age' => 0,
                            'assist' => 0,
                            'lineup_id' => 0,
                            'penalty' => 0,
                            'player_id' => 0,
                            'plus_minus' => 0,
                            'power_nominal' => 0,
                            'power_real' => 0,
                            'score' => 0,
                            'shot' => 0,
                        ),
                        'rf_1' => array(
                            'age' => 0,
                            'assist' => 0,
                            'lineup_id' => 0,
                            'penalty' => 0,
                            'player_id' => 0,
                            'plus_minus' => 0,
                            'power_nominal' => 0,
                            'power_real' => 0,
                            'score' => 0,
                            'shot' => 0,
                        ),
                        'ld_2' => array(
                            'age' => 0,
                            'assist' => 0,
                            'lineup_id' => 0,
                            'penalty' => 0,
                            'player_id' => 0,
                            'plus_minus' => 0,
                            'power_nominal' => 0,
                            'power_real' => 0,
                            'score' => 0,
                            'shot' => 0,
                        ),
                        'rd_2' => array(
                            'age' => 0,
                            'assist' => 0,
                            'lineup_id' => 0,
                            'penalty' => 0,
                            'player_id' => 0,
                            'plus_minus' => 0,
                            'power_nominal' => 0,
                            'power_real' => 0,
                            'score' => 0,
                            'shot' => 0,
                        ),
                        'lf_2' => array(
                            'age' => 0,
                            'assist' => 0,
                            'lineup_id' => 0,
                            'penalty' => 0,
                            'player_id' => 0,
                            'plus_minus' => 0,
                            'power_nominal' => 0,
                            'power_real' => 0,
                            'score' => 0,
                            'shot' => 0,
                        ),
                        'c_2' => array(
                            'age' => 0,
                            'assist' => 0,
                            'lineup_id' => 0,
                            'penalty' => 0,
                            'player_id' => 0,
                            'plus_minus' => 0,
                            'power_nominal' => 0,
                            'power_real' => 0,
                            'score' => 0,
                            'shot' => 0,
                        ),
                        'rf_2' => array(
                            'age' => 0,
                            'assist' => 0,
                            'lineup_id' => 0,
                            'penalty' => 0,
                            'player_id' => 0,
                            'plus_minus' => 0,
                            'power_nominal' => 0,
                            'power_real' => 0,
                            'score' => 0,
                            'shot' => 0,
                        ),
                        'ld_3' => array(
                            'age' => 0,
                            'assist' => 0,
                            'lineup_id' => 0,
                            'penalty' => 0,
                            'player_id' => 0,
                            'plus_minus' => 0,
                            'power_nominal' => 0,
                            'power_real' => 0,
                            'score' => 0,
                            'shot' => 0,
                        ),
                        'rd_3' => array(
                            'age' => 0,
                            'assist' => 0,
                            'lineup_id' => 0,
                            'penalty' => 0,
                            'player_id' => 0,
                            'plus_minus' => 0,
                            'power_nominal' => 0,
                            'power_real' => 0,
                            'score' => 0,
                            'shot' => 0,
                        ),
                        'lf_3' => array(
                            'age' => 0,
                            'assist' => 0,
                            'lineup_id' => 0,
                            'penalty' => 0,
                            'player_id' => 0,
                            'plus_minus' => 0,
                            'power_nominal' => 0,
                            'power_real' => 0,
                            'score' => 0,
                            'shot' => 0,
                        ),
                        'c_3' => array(
                            'age' => 0,
                            'assist' => 0,
                            'lineup_id' => 0,
                            'penalty' => 0,
                            'player_id' => 0,
                            'plus_minus' => 0,
                            'power_nominal' => 0,
                            'power_real' => 0,
                            'score' => 0,
                            'shot' => 0,
                        ),
                        'rf_3' => array(
                            'age' => 0,
                            'assist' => 0,
                            'lineup_id' => 0,
                            'penalty' => 0,
                            'player_id' => 0,
                            'plus_minus' => 0,
                            'power_nominal' => 0,
                            'power_real' => 0,
                            'score' => 0,
                            'shot' => 0,
                        ),
                    ),
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
                        'gk' => 0,
                        'shot' => 0,
                        'total' => 0,
                    ),
                    'score' => array(
                        'total' => 0,
                        1 => 0,
                        2 => 0,
                        3 => 0,
                    ),
                    'shot' => array(
                        'total' => 0,
                        1 => 0,
                        2 => 0,
                        3 => 0,
                    ),
                ),
            ),
            'home' => array(
                'player' => array(
                    'gk' => array(
                        'age' => 0,
                        'assist' => 0,
                        'lineup_id' => 0,
                        'pass' => 0,
                        'player_id' => 0,
                        'power_nominal' => 0,
                        'power_real' => 0,
                        'shot' => 0,
                    ),
                    'field' => array(
                        'ld_1' => array(
                            'age' => 0,
                            'assist' => 0,
                            'lineup_id' => 0,
                            'penalty' => 0,
                            'player_id' => 0,
                            'plus_minus' => 0,
                            'power_nominal' => 0,
                            'power_real' => 0,
                            'score' => 0,
                            'shot' => 0,
                        ),
                        'rd_1' => array(
                            'age' => 0,
                            'assist' => 0,
                            'lineup_id' => 0,
                            'penalty' => 0,
                            'player_id' => 0,
                            'plus_minus' => 0,
                            'power_nominal' => 0,
                            'power_real' => 0,
                            'score' => 0,
                            'shot' => 0,
                        ),
                        'lf_1' => array(
                            'age' => 0,
                            'assist' => 0,
                            'lineup_id' => 0,
                            'penalty' => 0,
                            'player_id' => 0,
                            'plus_minus' => 0,
                            'power_nominal' => 0,
                            'power_real' => 0,
                            'score' => 0,
                            'shot' => 0,
                        ),
                        'c_1' => array(
                            'age' => 0,
                            'assist' => 0,
                            'lineup_id' => 0,
                            'penalty' => 0,
                            'player_id' => 0,
                            'plus_minus' => 0,
                            'power_nominal' => 0,
                            'power_real' => 0,
                            'score' => 0,
                            'shot' => 0,
                        ),
                        'rf_1' => array(
                            'age' => 0,
                            'assist' => 0,
                            'lineup_id' => 0,
                            'penalty' => 0,
                            'player_id' => 0,
                            'plus_minus' => 0,
                            'power_nominal' => 0,
                            'power_real' => 0,
                            'score' => 0,
                            'shot' => 0,
                        ),
                        'ld_2' => array(
                            'age' => 0,
                            'assist' => 0,
                            'lineup_id' => 0,
                            'penalty' => 0,
                            'player_id' => 0,
                            'plus_minus' => 0,
                            'power_nominal' => 0,
                            'power_real' => 0,
                            'score' => 0,
                            'shot' => 0,
                        ),
                        'rd_2' => array(
                            'age' => 0,
                            'assist' => 0,
                            'lineup_id' => 0,
                            'penalty' => 0,
                            'player_id' => 0,
                            'plus_minus' => 0,
                            'power_nominal' => 0,
                            'power_real' => 0,
                            'score' => 0,
                            'shot' => 0,
                        ),
                        'lf_2' => array(
                            'age' => 0,
                            'assist' => 0,
                            'lineup_id' => 0,
                            'penalty' => 0,
                            'player_id' => 0,
                            'plus_minus' => 0,
                            'power_nominal' => 0,
                            'power_real' => 0,
                            'score' => 0,
                            'shot' => 0,
                        ),
                        'c_2' => array(
                            'age' => 0,
                            'assist' => 0,
                            'lineup_id' => 0,
                            'penalty' => 0,
                            'player_id' => 0,
                            'plus_minus' => 0,
                            'power_nominal' => 0,
                            'power_real' => 0,
                            'score' => 0,
                            'shot' => 0,
                        ),
                        'rf_2' => array(
                            'age' => 0,
                            'assist' => 0,
                            'lineup_id' => 0,
                            'penalty' => 0,
                            'player_id' => 0,
                            'plus_minus' => 0,
                            'power_nominal' => 0,
                            'power_real' => 0,
                            'score' => 0,
                            'shot' => 0,
                        ),
                        'ld_3' => array(
                            'age' => 0,
                            'assist' => 0,
                            'lineup_id' => 0,
                            'penalty' => 0,
                            'player_id' => 0,
                            'plus_minus' => 0,
                            'power_nominal' => 0,
                            'power_real' => 0,
                            'score' => 0,
                            'shot' => 0,
                        ),
                        'rd_3' => array(
                            'age' => 0,
                            'assist' => 0,
                            'lineup_id' => 0,
                            'penalty' => 0,
                            'player_id' => 0,
                            'plus_minus' => 0,
                            'power_nominal' => 0,
                            'power_real' => 0,
                            'score' => 0,
                            'shot' => 0,
                        ),
                        'lf_3' => array(
                            'age' => 0,
                            'assist' => 0,
                            'lineup_id' => 0,
                            'penalty' => 0,
                            'player_id' => 0,
                            'plus_minus' => 0,
                            'power_nominal' => 0,
                            'power_real' => 0,
                            'score' => 0,
                            'shot' => 0,
                        ),
                        'c_3' => array(
                            'age' => 0,
                            'assist' => 0,
                            'lineup_id' => 0,
                            'penalty' => 0,
                            'player_id' => 0,
                            'plus_minus' => 0,
                            'power_nominal' => 0,
                            'power_real' => 0,
                            'score' => 0,
                            'shot' => 0,
                        ),
                        'rf_3' => array(
                            'age' => 0,
                            'assist' => 0,
                            'lineup_id' => 0,
                            'penalty' => 0,
                            'player_id' => 0,
                            'plus_minus' => 0,
                            'power_nominal' => 0,
                            'power_real' => 0,
                            'score' => 0,
                            'shot' => 0,
                        ),
                    ),
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
                        'gk' => 0,
                        'shot' => 0,
                        'total' => 0,
                    ),
                    'score' => array(
                        'total' => 0,
                        1 => 0,
                        2 => 0,
                        3 => 0,
                    ),
                    'shot' => array(
                        'total' => 0,
                        1 => 0,
                        2 => 0,
                        3 => 0,
                    ),
                ),
            ),
            'minute' => 0,
            'player' => 0,
            'assist_1' => 0,
            'assist_2' => 0,
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

        $game_result['guest']['player']['gk']['age']                        = $guest_lineup_array[0]['player_age'];
        $game_result['guest']['player']['gk']['lineup_id']                  = $guest_lineup_array[0]['lineup_id'];
        $game_result['guest']['player']['gk']['player_id']                  = $guest_lineup_array[0]['player_id'];
        $game_result['guest']['player']['gk']['power_nominal']              = $guest_lineup_array[0]['player_power_nominal'];
        $game_result['guest']['player']['gk']['power_real']                 = $guest_lineup_array[0]['player_power_real'];
        $game_result['guest']['player']['field']['ld_1']['age']             = $guest_lineup_array[1]['player_age'];
        $game_result['guest']['player']['field']['ld_1']['lineup_id']       = $guest_lineup_array[1]['lineup_id'];
        $game_result['guest']['player']['field']['ld_1']['player_id']       = $guest_lineup_array[1]['player_id'];
        $game_result['guest']['player']['field']['ld_1']['power_nominal']   = $guest_lineup_array[1]['player_power_nominal'];
        $game_result['guest']['player']['field']['ld_1']['power_real']      = $guest_lineup_array[1]['player_power_real'];
        $game_result['guest']['player']['field']['rd_1']['age']             = $guest_lineup_array[2]['player_age'];
        $game_result['guest']['player']['field']['rd_1']['lineup_id']       = $guest_lineup_array[2]['lineup_id'];
        $game_result['guest']['player']['field']['rd_1']['player_id']       = $guest_lineup_array[2]['player_id'];
        $game_result['guest']['player']['field']['rd_1']['power_nominal']   = $guest_lineup_array[2]['player_power_nominal'];
        $game_result['guest']['player']['field']['rd_1']['power_real']      = $guest_lineup_array[2]['player_power_real'];
        $game_result['guest']['player']['field']['lf_1']['age']             = $guest_lineup_array[3]['player_age'];
        $game_result['guest']['player']['field']['lf_1']['lineup_id']       = $guest_lineup_array[3]['lineup_id'];
        $game_result['guest']['player']['field']['lf_1']['player_id']       = $guest_lineup_array[3]['player_id'];
        $game_result['guest']['player']['field']['lf_1']['power_nominal']   = $guest_lineup_array[3]['player_power_nominal'];
        $game_result['guest']['player']['field']['lf_1']['power_real']      = $guest_lineup_array[3]['player_power_real'];
        $game_result['guest']['player']['field']['c_1']['age']              = $guest_lineup_array[4]['player_age'];
        $game_result['guest']['player']['field']['c_1']['lineup_id']        = $guest_lineup_array[4]['lineup_id'];
        $game_result['guest']['player']['field']['c_1']['player_id']        = $guest_lineup_array[4]['player_id'];
        $game_result['guest']['player']['field']['c_1']['power_nominal']    = $guest_lineup_array[4]['player_power_nominal'];
        $game_result['guest']['player']['field']['c_1']['power_real']       = $guest_lineup_array[4]['player_power_real'];
        $game_result['guest']['player']['field']['rf_1']['age']             = $guest_lineup_array[5]['player_age'];
        $game_result['guest']['player']['field']['rf_1']['lineup_id']       = $guest_lineup_array[5]['lineup_id'];
        $game_result['guest']['player']['field']['rf_1']['player_id']       = $guest_lineup_array[5]['player_id'];
        $game_result['guest']['player']['field']['rf_1']['power_nominal']   = $guest_lineup_array[5]['player_power_nominal'];
        $game_result['guest']['player']['field']['rf_1']['power_real']      = $guest_lineup_array[5]['player_power_real'];
        $game_result['guest']['player']['field']['ld_2']['age']             = $guest_lineup_array[6]['player_age'];
        $game_result['guest']['player']['field']['ld_2']['lineup_id']       = $guest_lineup_array[6]['lineup_id'];
        $game_result['guest']['player']['field']['ld_2']['player_id']       = $guest_lineup_array[6]['player_id'];
        $game_result['guest']['player']['field']['ld_2']['power_nominal']   = $guest_lineup_array[6]['player_power_nominal'];
        $game_result['guest']['player']['field']['ld_2']['power_real']      = $guest_lineup_array[6]['player_power_real'];
        $game_result['guest']['player']['field']['rd_2']['age']             = $guest_lineup_array[7]['player_age'];
        $game_result['guest']['player']['field']['rd_2']['lineup_id']       = $guest_lineup_array[7]['lineup_id'];
        $game_result['guest']['player']['field']['rd_2']['player_id']       = $guest_lineup_array[7]['player_id'];
        $game_result['guest']['player']['field']['rd_2']['power_nominal']   = $guest_lineup_array[7]['player_power_nominal'];
        $game_result['guest']['player']['field']['rd_2']['power_real']      = $guest_lineup_array[7]['player_power_real'];
        $game_result['guest']['player']['field']['lf_2']['age']             = $guest_lineup_array[8]['player_age'];
        $game_result['guest']['player']['field']['lf_2']['lineup_id']       = $guest_lineup_array[8]['lineup_id'];
        $game_result['guest']['player']['field']['lf_2']['player_id']       = $guest_lineup_array[8]['player_id'];
        $game_result['guest']['player']['field']['lf_2']['power_nominal']   = $guest_lineup_array[8]['player_power_nominal'];
        $game_result['guest']['player']['field']['lf_2']['power_real']      = $guest_lineup_array[8]['player_power_real'];
        $game_result['guest']['player']['field']['c_2']['age']              = $guest_lineup_array[9]['player_age'];
        $game_result['guest']['player']['field']['c_2']['lineup_id']        = $guest_lineup_array[9]['lineup_id'];
        $game_result['guest']['player']['field']['c_2']['player_id']        = $guest_lineup_array[9]['player_id'];
        $game_result['guest']['player']['field']['c_2']['power_nominal']    = $guest_lineup_array[9]['player_power_nominal'];
        $game_result['guest']['player']['field']['c_2']['power_real']       = $guest_lineup_array[9]['player_power_real'];
        $game_result['guest']['player']['field']['rf_2']['age']             = $guest_lineup_array[10]['player_age'];
        $game_result['guest']['player']['field']['rf_2']['lineup_id']       = $guest_lineup_array[10]['lineup_id'];
        $game_result['guest']['player']['field']['rf_2']['player_id']       = $guest_lineup_array[10]['player_id'];
        $game_result['guest']['player']['field']['rf_2']['power_nominal']   = $guest_lineup_array[10]['player_power_nominal'];
        $game_result['guest']['player']['field']['rf_2']['power_real']      = $guest_lineup_array[10]['player_power_real'];
        $game_result['guest']['player']['field']['ld_3']['age']             = $guest_lineup_array[11]['player_age'];
        $game_result['guest']['player']['field']['ld_3']['lineup_id']       = $guest_lineup_array[11]['lineup_id'];
        $game_result['guest']['player']['field']['ld_3']['player_id']       = $guest_lineup_array[11]['player_id'];
        $game_result['guest']['player']['field']['ld_3']['power_nominal']   = $guest_lineup_array[11]['player_power_nominal'];
        $game_result['guest']['player']['field']['ld_3']['power_real']      = $guest_lineup_array[11]['player_power_real'];
        $game_result['guest']['player']['field']['rd_3']['age']             = $guest_lineup_array[12]['player_age'];
        $game_result['guest']['player']['field']['rd_3']['lineup_id']       = $guest_lineup_array[12]['lineup_id'];
        $game_result['guest']['player']['field']['rd_3']['player_id']       = $guest_lineup_array[12]['player_id'];
        $game_result['guest']['player']['field']['rd_3']['power_nominal']   = $guest_lineup_array[12]['player_power_nominal'];
        $game_result['guest']['player']['field']['rd_3']['power_real']      = $guest_lineup_array[12]['player_power_real'];
        $game_result['guest']['player']['field']['lf_3']['age']             = $guest_lineup_array[13]['player_age'];
        $game_result['guest']['player']['field']['lf_3']['lineup_id']       = $guest_lineup_array[13]['lineup_id'];
        $game_result['guest']['player']['field']['lf_3']['player_id']       = $guest_lineup_array[13]['player_id'];
        $game_result['guest']['player']['field']['lf_3']['power_nominal']   = $guest_lineup_array[13]['player_power_nominal'];
        $game_result['guest']['player']['field']['lf_3']['power_real']      = $guest_lineup_array[13]['player_power_real'];
        $game_result['guest']['player']['field']['c_3']['age']              = $guest_lineup_array[14]['player_age'];
        $game_result['guest']['player']['field']['c_3']['lineup_id']        = $guest_lineup_array[14]['lineup_id'];
        $game_result['guest']['player']['field']['c_3']['player_id']        = $guest_lineup_array[14]['player_id'];
        $game_result['guest']['player']['field']['c_3']['power_nominal']    = $guest_lineup_array[14]['player_power_nominal'];
        $game_result['guest']['player']['field']['c_3']['power_real']       = $guest_lineup_array[14]['player_power_real'];
        $game_result['guest']['player']['field']['rf_3']['age']             = $guest_lineup_array[15]['player_age'];
        $game_result['guest']['player']['field']['rf_3']['lineup_id']       = $guest_lineup_array[15]['lineup_id'];
        $game_result['guest']['player']['field']['rf_3']['player_id']       = $guest_lineup_array[15]['player_id'];
        $game_result['guest']['player']['field']['rf_3']['power_nominal']   = $guest_lineup_array[15]['player_power_nominal'];
        $game_result['guest']['player']['field']['rf_3']['power_real']      = $guest_lineup_array[15]['player_power_real'];

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
            = $game_result['guest']['player']['field']['lf_1']['power_real']
            + $game_result['guest']['player']['field']['c_1']['power_real']
            + $game_result['guest']['player']['field']['rf_1']['power_real'];
        $game_result['guest']['team']['power']['forward'][2]
            = $game_result['guest']['player']['field']['lf_2']['power_real']
            + $game_result['guest']['player']['field']['c_2']['power_real']
            + $game_result['guest']['player']['field']['rf_2']['power_real'];
        $game_result['guest']['team']['power']['forward'][3]
            = $game_result['guest']['player']['field']['lf_2']['power_real']
            + $game_result['guest']['player']['field']['c_2']['power_real']
            + $game_result['guest']['player']['field']['rf_2']['power_real'];
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

        $game_result['home']['player']['gk']['age']                         = $home_lineup_array[0]['player_age'];
        $game_result['home']['player']['gk']['lineup_id']                   = $home_lineup_array[0]['lineup_id'];
        $game_result['home']['player']['gk']['player_id']                   = $home_lineup_array[0]['player_id'];
        $game_result['home']['player']['gk']['power_nominal']               = $home_lineup_array[0]['player_power_nominal'];
        $game_result['home']['player']['gk']['power_real']                  = round($home_lineup_array[0]['player_power_real'] * $home_bonus, 0);
        $game_result['home']['player']['field']['ld_1']['age']              = $home_lineup_array[1]['player_age'];
        $game_result['home']['player']['field']['ld_1']['lineup_id']        = $home_lineup_array[1]['lineup_id'];
        $game_result['home']['player']['field']['ld_1']['player_id']        = $home_lineup_array[1]['player_id'];
        $game_result['home']['player']['field']['ld_1']['power_nominal']    = $home_lineup_array[1]['player_power_nominal'];
        $game_result['home']['player']['field']['ld_1']['power_real']       = round($home_lineup_array[1]['player_power_real'] * $home_bonus, 0);
        $game_result['home']['player']['field']['rd_1']['age']              = $home_lineup_array[2]['player_age'];
        $game_result['home']['player']['field']['rd_1']['lineup_id']        = $home_lineup_array[2]['lineup_id'];
        $game_result['home']['player']['field']['rd_1']['player_id']        = $home_lineup_array[2]['player_id'];
        $game_result['home']['player']['field']['rd_1']['power_nominal']    = $home_lineup_array[2]['player_power_nominal'];
        $game_result['home']['player']['field']['rd_1']['power_real']       = round($home_lineup_array[2]['player_power_real'] * $home_bonus, 0);
        $game_result['home']['player']['field']['lf_1']['age']              = $home_lineup_array[3]['player_age'];
        $game_result['home']['player']['field']['lf_1']['lineup_id']        = $home_lineup_array[3]['lineup_id'];
        $game_result['home']['player']['field']['lf_1']['player_id']        = $home_lineup_array[3]['player_id'];
        $game_result['home']['player']['field']['lf_1']['power_nominal']    = $home_lineup_array[3]['player_power_nominal'];
        $game_result['home']['player']['field']['lf_1']['power_real']       = round($home_lineup_array[3]['player_power_real'] * $home_bonus, 0);
        $game_result['home']['player']['field']['c_1']['age']               = $home_lineup_array[4]['player_age'];
        $game_result['home']['player']['field']['c_1']['lineup_id']         = $home_lineup_array[4]['lineup_id'];
        $game_result['home']['player']['field']['c_1']['player_id']         = $home_lineup_array[4]['player_id'];
        $game_result['home']['player']['field']['c_1']['power_nominal']     = $home_lineup_array[4]['player_power_nominal'];
        $game_result['home']['player']['field']['c_1']['power_real']        = round($home_lineup_array[4]['player_power_real'] * $home_bonus, 0);
        $game_result['home']['player']['field']['rf_1']['age']              = $home_lineup_array[5]['player_age'];
        $game_result['home']['player']['field']['rf_1']['lineup_id']        = $home_lineup_array[5]['lineup_id'];
        $game_result['home']['player']['field']['rf_1']['player_id']        = $home_lineup_array[5]['player_id'];
        $game_result['home']['player']['field']['rf_1']['power_nominal']    = $home_lineup_array[5]['player_power_nominal'];
        $game_result['home']['player']['field']['rf_1']['power_real']       = round($home_lineup_array[5]['player_power_real'] * $home_bonus, 0);
        $game_result['home']['player']['field']['ld_2']['age']              = $home_lineup_array[6]['player_age'];
        $game_result['home']['player']['field']['ld_2']['lineup_id']        = $home_lineup_array[6]['lineup_id'];
        $game_result['home']['player']['field']['ld_2']['player_id']        = $home_lineup_array[6]['player_id'];
        $game_result['home']['player']['field']['ld_2']['power_nominal']    = $home_lineup_array[6]['player_power_nominal'];
        $game_result['home']['player']['field']['ld_2']['power_real']       = round($home_lineup_array[6]['player_power_real'] * $home_bonus, 0);
        $game_result['home']['player']['field']['rd_2']['age']              = $home_lineup_array[7]['player_age'];
        $game_result['home']['player']['field']['rd_2']['lineup_id']        = $home_lineup_array[7]['lineup_id'];
        $game_result['home']['player']['field']['rd_2']['player_id']        = $home_lineup_array[7]['player_id'];
        $game_result['home']['player']['field']['rd_2']['power_nominal']    = $home_lineup_array[7]['player_power_nominal'];
        $game_result['home']['player']['field']['rd_2']['power_real']       = round($home_lineup_array[7]['player_power_real'] * $home_bonus, 0);
        $game_result['home']['player']['field']['lf_2']['age']              = $home_lineup_array[8]['player_age'];
        $game_result['home']['player']['field']['lf_2']['lineup_id']        = $home_lineup_array[8]['lineup_id'];
        $game_result['home']['player']['field']['lf_2']['player_id']        = $home_lineup_array[8]['player_id'];
        $game_result['home']['player']['field']['lf_2']['power_nominal']    = $home_lineup_array[8]['player_power_nominal'];
        $game_result['home']['player']['field']['lf_2']['power_real']       = round($home_lineup_array[8]['player_power_real'] * $home_bonus, 0);
        $game_result['home']['player']['field']['c_2']['age']               = $home_lineup_array[9]['player_age'];
        $game_result['home']['player']['field']['c_2']['lineup_id']         = $home_lineup_array[9]['lineup_id'];
        $game_result['home']['player']['field']['c_2']['player_id']         = $home_lineup_array[9]['player_id'];
        $game_result['home']['player']['field']['c_2']['power_nominal']     = $home_lineup_array[9]['player_power_nominal'];
        $game_result['home']['player']['field']['c_2']['power_real']        = round($home_lineup_array[9]['player_power_real'] * $home_bonus, 0);
        $game_result['home']['player']['field']['rf_2']['age']              = $home_lineup_array[10]['player_age'];
        $game_result['home']['player']['field']['rf_2']['lineup_id']        = $home_lineup_array[10]['lineup_id'];
        $game_result['home']['player']['field']['rf_2']['player_id']        = $home_lineup_array[10]['player_id'];
        $game_result['home']['player']['field']['rf_2']['power_nominal']    = $home_lineup_array[10]['player_power_nominal'];
        $game_result['home']['player']['field']['rf_2']['power_real']       = round($home_lineup_array[10]['player_power_real'] * $home_bonus, 0);
        $game_result['home']['player']['field']['ld_3']['age']              = $home_lineup_array[11]['player_age'];
        $game_result['home']['player']['field']['ld_3']['lineup_id']        = $home_lineup_array[11]['lineup_id'];
        $game_result['home']['player']['field']['ld_3']['player_id']        = $home_lineup_array[11]['player_id'];
        $game_result['home']['player']['field']['ld_3']['power_nominal']    = $home_lineup_array[11]['player_power_nominal'];
        $game_result['home']['player']['field']['ld_3']['power_real']       = round($home_lineup_array[11]['player_power_real'] * $home_bonus, 0);
        $game_result['home']['player']['field']['rd_3']['age']              = $home_lineup_array[12]['player_age'];
        $game_result['home']['player']['field']['rd_3']['lineup_id']        = $home_lineup_array[12]['lineup_id'];
        $game_result['home']['player']['field']['rd_3']['player_id']        = $home_lineup_array[12]['player_id'];
        $game_result['home']['player']['field']['rd_3']['power_nominal']    = $home_lineup_array[12]['player_power_nominal'];
        $game_result['home']['player']['field']['rd_3']['power_real']       = round($home_lineup_array[12]['player_power_real'] * $home_bonus, 0);
        $game_result['home']['player']['field']['lf_3']['age']              = $home_lineup_array[13]['player_age'];
        $game_result['home']['player']['field']['lf_3']['lineup_id']        = $home_lineup_array[13]['lineup_id'];
        $game_result['home']['player']['field']['lf_3']['player_id']        = $home_lineup_array[13]['player_id'];
        $game_result['home']['player']['field']['lf_3']['power_nominal']    = $home_lineup_array[13]['player_power_nominal'];
        $game_result['home']['player']['field']['lf_3']['power_real']       = round($home_lineup_array[13]['player_power_real'] * $home_bonus, 0);
        $game_result['home']['player']['field']['c_3']['age']               = $home_lineup_array[14]['player_age'];
        $game_result['home']['player']['field']['c_3']['lineup_id']         = $home_lineup_array[14]['lineup_id'];
        $game_result['home']['player']['field']['c_3']['player_id']         = $home_lineup_array[14]['player_id'];
        $game_result['home']['player']['field']['c_3']['power_nominal']     = $home_lineup_array[14]['player_power_nominal'];
        $game_result['home']['player']['field']['c_3']['power_real']        = round($home_lineup_array[14]['player_power_real'] * $home_bonus, 0);
        $game_result['home']['player']['field']['rf_3']['age']              = $home_lineup_array[15]['player_age'];
        $game_result['home']['player']['field']['rf_3']['lineup_id']        = $home_lineup_array[15]['lineup_id'];
        $game_result['home']['player']['field']['rf_3']['player_id']        = $home_lineup_array[15]['player_id'];
        $game_result['home']['player']['field']['rf_3']['power_nominal']    = $home_lineup_array[15]['player_power_nominal'];
        $game_result['home']['player']['field']['rf_3']['power_real']       = round($home_lineup_array[15]['player_power_real'] * $home_bonus, 0);

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
            = $game_result['home']['player']['field']['lf_1']['power_real']
            + $game_result['home']['player']['field']['c_1']['power_real']
            + $game_result['home']['player']['field']['rf_1']['power_real'];
        $game_result['home']['team']['power']['forward'][2]
            = $game_result['home']['player']['field']['lf_2']['power_real']
            + $game_result['home']['player']['field']['c_2']['power_real']
            + $game_result['home']['player']['field']['rf_2']['power_real'];
        $game_result['home']['team']['power']['forward'][3]
            = $game_result['home']['player']['field']['lf_2']['power_real']
            + $game_result['home']['player']['field']['c_2']['power_real']
            + $game_result['home']['player']['field']['rf_2']['power_real'];
        $game_result['home']['team']['power']['total']
            = $game_result['home']['team']['power']['gk']
            + $game_result['home']['team']['power']['defence'][1]
            + $game_result['home']['team']['power']['defence'][2]
            + $game_result['home']['team']['power']['defence'][3]
            + $game_result['home']['team']['power']['forward'][1]
            + $game_result['home']['team']['power']['forward'][2]
            + $game_result['home']['team']['power']['forward'][3];

        for ($game_result['minute']=1; $game_result['minute']<60; $game_result['minute']++)
        {
            $game_result = f_igosja_home_defence($game_result);
            $game_result = f_igosja_home_forward($game_result);
            $game_result = f_igosja_guest_defence($game_result);
            $game_result = f_igosja_guest_forward($game_result);

            if (rand(0, 40) >= 34 && 1 == rand(0, 1))
            {
                $game_result['player'] = rand(1, 5);

                $game_result = f_igosja_event_home_penalty($game_result);
                $game_result = f_igosja_home_player_penalty_increase($game_result);
                $game_result = f_igosja_home_current_penalty_increase($game_result);
                $game_result = f_igosja_home_team_penalty_increase($game_result);
            }

            if (rand(0, 40) >= 34 && 1 == rand(0, 1))
            {
                $game_result['player'] = rand(1, 5);

                $game_result = f_igosja_event_guest_penalty($game_result);
                $game_result = f_igosja_guest_player_penalty_increase($game_result);
                $game_result = f_igosja_guest_current_penalty_increase($game_result);
                $game_result = f_igosja_guest_team_penalty_increase($game_result);
            }

            $game_result = f_igosja_home_current_penalty_decrease($game_result);
            $game_result = f_igosja_guest_current_penalty_decrease($game_result);

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
                    $game_result = f_igosja_home_select_player_shot($game_result);
                    $game_result = f_igosja_home_team_shot_increase($game_result);
                    $game_result = f_igosja_home_player_shot_increase($game_result);
                    $game_result = f_igosja_home_player_shot_power($game_result);

                    if (rand(
                            0,
                            $game_result['home']['team']['power']['shot']
                        ) > rand(
                            0,
                            $game_result['guest']['team']['power']['gk'] * 5
                        ))
                    {
                        $game_result = f_igosja_generator_assist_1($game_result);
                        $game_result = f_igosja_generator_assist_2($game_result);
                        $game_result = f_igosja_home_team_score_increase($game_result);
                        $game_result = f_igosja_event_home_score($game_result);
                        $game_result = f_igosja_home_plus_minus_increase($game_result);
                        $game_result = f_igosja_home_player_score_increase($game_result);
                        $game_result = f_igosja_home_player_assist_1_increase($game_result);
                        $game_result = f_igosja_home_player_assist_2_increase($game_result);
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
                    $game_result = f_igosja_guest_select_player_shot($game_result);
                    $game_result = f_igosja_guest_team_shot_increase($game_result);
                    $game_result = f_igosja_guest_team_shot_increase($game_result);
                    $game_result = f_igosja_guest_player_shot_increase($game_result);
                    $game_result = f_igosja_guest_player_shot_power($game_result);

                    if (rand(
                            0,
                            $game_result['guest']['team']['power']['shot']
                        ) > rand(
                            0,
                            $game_result['home']['team']['power']['gk'] * 5
                        ))
                    {
                        $game_result = f_igosja_generator_assist_1($game_result);
                        $game_result = f_igosja_generator_assist_2($game_result);
                        $game_result = f_igosja_guest_team_score_increase($game_result);
                        $game_result = f_igosja_event_guest_score($game_result);
                        $game_result = f_igosja_guest_plus_minus_increase($game_result);
                        $game_result = f_igosja_guest_player_score_increase($game_result);
                        $game_result = f_igosja_guest_player_assist_1_increase($game_result);
                        $game_result = f_igosja_guest_player_assist_2_increase($game_result);
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
                        `event_eventtextgoal_id`='" . $event['event_eventtextgoal_id'] . "',
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
                        `event_player_id`='" . $event['event_player_id'] . "',
                        `event_player_penalty_id`='" . $event['event_player_penalty_id'] . "',
                        `event_second`='" . $event['event_second'] . "',
                        `event_team_id`='" . $event['event_team_id'] . "'";
            f_igosja_mysqli_query($sql);
        }

        usleep(1);

        print '.';
        flush();
    }
}