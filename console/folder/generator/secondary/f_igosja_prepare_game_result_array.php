<?php

/**
 * Готуємо массив для генерації результату гри
 * @param $game_id integer
 * @param $game_home_national_id integer
 * @param $game_home_team_id integer
 * @param $game_guest_national_id integer
 * @param $game_guest_team_id integer
 * @param $tournamenttype_id integer
 * @return array
 */
function f_igosja_prepare_game_result_array($game_id, $game_home_national_id, $game_home_team_id, $game_guest_national_id, $game_guest_team_id, $tournamenttype_id)
{
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
                'assist_power'  => 0,
                'assist_short'  => 0,
                'bonus'         => 0,
                'bullet_win'    => 0,
                'face_off'      => 0,
                'face_off_win'  => 0,
                'game'          => 1,
                'lineup_id'     => 0,
                'loose'         => 0,
                'penalty'       => 0,
                'player_id'     => 0,
                'plus_minus'    => 0,
                'point'         => 0,
                'power_nominal' => 0,
                'power_optimal' => 0,
                'power_real'    => 0,
                'score'         => 0,
                'score_draw'    => 0,
                'score_power'   => 0,
                'score_short'   => 0,
                'score_win'     => 0,
                'shot'          => 0,
                'style'         => 0,
                'win'           => 0,
            );
        }
    }

    $team_array = array(
        'player' => array(
            'gk' => array(
                'age'               => 0,
                'assist'            => 0,
                'assist_power'      => 0,
                'assist_short'      => 0,
                'bonus'             => 0,
                'game'              => 1,
                'game_with_bullet'  => 0,
                'lineup_id'         => 0,
                'loose'             => 0,
                'pass'              => 0,
                'player_id'         => 0,
                'point'             => 0,
                'power_nominal'     => 0,
                'power_optimal'     => 0,
                'power_real'        => 0,
                'save'              => 0,
                'shot'              => 0,
                'shutout'           => 0,
                'win'               => 0,
            ),
            'field' => $field_player_array,
        ),
        'team' => array(
            'auto' => 0,
            'collision'  => array(
                1 => 0,
                2 => 0,
                3 => 0,
            ),
            'game' => 1,
            'leader' => 0,
            'loose' => 0,
            'loose_bullet' => 0,
            'loose_over' => 0,
            'mood' => 0,
            'no_pass' => 0,
            'no_score' => 0,
            'optimality_1' => 0,
            'optimality_2' => 0,
            'pass' => 0,
            'penalty' => array(
                1 => 0,
                2 => 0,
                3 => 0,
                'current' => array(),
                'opponent' => 0,
                'over' => 0,
                'total' => 0,
            ),
            'power' => array(
                'defence' => array(
                    1 => 0,
                    2 => 0,
                    3 => 0,
                    'current' => 0,
                ),
                'face_off' => 0,
                'forecast' => 0,
                'forward' => array(
                    1 => 0,
                    2 => 0,
                    3 => 0,
                    'current' => 0,
                ),
                'gk' => 0,
                'optimal' => 0,
                'percent' => 0,
                'shot' => 0,
                'total' => 0,
            ),
            'rude' => array(
                1 => 0,
                2 => 0,
                3 => 0,
            ),
            'score' => array(
                1 => 0,
                2 => 0,
                3 => 0,
                'bullet' => 0,
                'last' => array(
                    'bullet' => '',
                    'score' => '',
                ),
                'over' => 0,
                'total' => 0,
            ),
            'shot' => array(
                1 => 0,
                2 => 0,
                3 => 0,
                'over' => 0,
                'total' => 0,
            ),
            'style' => array(
                1 => 0,
                2 => 0,
                3 => 0,
            ),
            'tactic' => array(
                1 => 0,
                2 => 0,
                3 => 0,
                'current' => 0,
            ),
            'teamwork' => array(
                1 => 0,
                2 => 0,
                3 => 0,
            ),
            'win' => 0,
            'win_bullet' => 0,
            'win_over' => 0,
        ),
    );

    $game_result = array(
        'event'             => array(),
        'face_off_guest'    => 0,
        'face_off_home'     => 0,
        'game_info'         => array(
            'game_id'           => $game_id,
            'guest_national_id' => $game_guest_national_id,
            'guest_team_id'     => $game_guest_team_id,
            'home_bonus'        => 1,
            'home_national_id'  => $game_home_national_id,
            'home_team_id'      => $game_home_team_id,
            'tournamenttype_id' => $tournamenttype_id,
        ),
        'guest'             => $team_array,
        'home'              => $team_array,
        'minute'            => 0,
        'player'            => 0,
        'assist_1'          => 0,
        'assist_2'          => 0,
    );

    return $game_result;
}