<?php

include(__DIR__ . '/include/generator.php');

$game_score_array = array();
$game_score_wdl_array = array();
$game_score_dif_array = array();
$score_sum = 0;

$max_i = 1000;

for ($game_list = 0; $game_list<$max_i; $game_list++)
{

$field_player_array = array();

for ($h=0; $h<2; $h++)
{
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
            'power_real'    => 50 + $h * 25,
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

$team_array[$h] = array(
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
            'power_real'        => 50 + $h * 25,
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
}

$game_result = array(
    'event'             => array(),
    'face_off_guest'    => 0,
    'face_off_home'     => 0,
    'game_info'         => array(
        'home_bonus'        => 1,
    ),
    'guest'             => $team_array[0],
    'home'              => $team_array[1],
    'minute'            => 0,
    'player'            => 0,
    'assist_1'          => 0,
    'assist_2'          => 0,
);

for ($i=0; $i<2; $i++)
{
    if (0 == $i)
    {
        $team = TEAM_HOME;
    }
    else
    {
        $team = TEAM_GUEST;
    }

    $game_result[$team]['team']['power']['gk'] = $game_result[$team]['player']['gk']['power_real'];
    $game_result[$team]['team']['power']['defence'][1]
        = $game_result[$team]['player']['field']['ld_1']['power_real']
        + $game_result[$team]['player']['field']['rd_1']['power_real'];
    $game_result[$team]['team']['power']['defence'][2]
        = $game_result[$team]['player']['field']['ld_2']['power_real']
        + $game_result[$team]['player']['field']['rd_2']['power_real'];
    $game_result[$team]['team']['power']['defence'][3]
        = $game_result[$team]['player']['field']['ld_3']['power_real']
        + $game_result[$team]['player']['field']['rd_3']['power_real'];
    $game_result[$team]['team']['power']['forward'][1]
        = $game_result[$team]['player']['field']['lw_1']['power_real']
        + $game_result[$team]['player']['field']['c_1']['power_real']
        + $game_result[$team]['player']['field']['rw_1']['power_real'];
    $game_result[$team]['team']['power']['forward'][2]
        = $game_result[$team]['player']['field']['lw_2']['power_real']
        + $game_result[$team]['player']['field']['c_2']['power_real']
        + $game_result[$team]['player']['field']['rw_2']['power_real'];
    $game_result[$team]['team']['power']['forward'][3]
        = $game_result[$team]['player']['field']['lw_3']['power_real']
        + $game_result[$team]['player']['field']['c_3']['power_real']
        + $game_result[$team]['player']['field']['rw_3']['power_real'];
    $game_result[$team]['team']['power']['total']
        = $game_result[$team]['team']['power']['gk']
        + $game_result[$team]['team']['power']['defence'][1]
        + $game_result[$team]['team']['power']['defence'][2]
        + $game_result[$team]['team']['power']['defence'][3]
        + $game_result[$team]['team']['power']['forward'][1]
        + $game_result[$team]['team']['power']['forward'][2]
        + $game_result[$team]['team']['power']['forward'][3];
    $game_result[$team]['team']['power']['optimal']
        = $game_result[$team]['player']['gk']['power_optimal']
        + $game_result[$team]['player']['field']['ld_1']['power_optimal']
        + $game_result[$team]['player']['field']['rd_1']['power_optimal']
        + $game_result[$team]['player']['field']['lw_1']['power_optimal']
        + $game_result[$team]['player']['field']['c_1']['power_optimal']
        + $game_result[$team]['player']['field']['rw_1']['power_optimal']
        + $game_result[$team]['player']['field']['ld_2']['power_optimal']
        + $game_result[$team]['player']['field']['rd_2']['power_optimal']
        + $game_result[$team]['player']['field']['lw_2']['power_optimal']
        + $game_result[$team]['player']['field']['c_2']['power_optimal']
        + $game_result[$team]['player']['field']['rw_2']['power_optimal']
        + $game_result[$team]['player']['field']['ld_3']['power_optimal']
        + $game_result[$team]['player']['field']['rd_3']['power_optimal']
        + $game_result[$team]['player']['field']['lw_3']['power_optimal']
        + $game_result[$team]['player']['field']['c_3']['power_optimal']
        + $game_result[$team]['player']['field']['rw_3']['power_optimal'];
}

for ($game_result['minute']=0; $game_result['minute']<60; $game_result['minute']++)
{
    $game_result = f_igosja_defence($game_result);
    $game_result = f_igosja_forward($game_result);

    $rude_home  = $game_result['home']['team']['rude'][$game_result['minute'] % 3 + 1];
    $rude_guest = $game_result['guest']['team']['rude'][$game_result['minute'] % 3 + 1];

    if (rand(0, 40) >= 34 - $rude_home * RUDE_PENALTY && 1 == rand(0, 1))
    {
        $game_result['player'] = rand(POSITION_LD, POSITION_RW);

        $game_result = f_igosja_player_penalty_increase($game_result, 'home');
        $game_result = f_igosja_current_penalty_increase($game_result, 'home');
        $game_result = f_igosja_team_penalty_increase($game_result, 'home');
    }

    if (rand(0, 40) >= 34 - $rude_guest * RUDE_PENALTY && 1 == rand(0, 1))
    {
        $game_result['player'] = rand(POSITION_LD, POSITION_RW);

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

            $score_koeff = (100 + 10 / ($game_result['home']['team']['score']['total'] + 1) * 10 - 55) / 100;
            $score_koeff = 1;

            if (rand(0, $shot_power * $score_koeff) > rand(0, $gk_power * 6))
            {
                $game_result = f_igosja_assist_1($game_result, 'home');
                $game_result = f_igosja_assist_2($game_result, 'home');
                $game_result = f_igosja_team_score_increase($game_result, 'home', 'guest');
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

            $score_koeff = (100 + 10 / ($game_result['guest']['team']['score']['total'] + 1) * 10 - 55) / 100;
            $score_koeff = 1;

            if (rand(0, $shot_power * $score_koeff) > rand(0, $gk_power * 6))
            {
                $game_result = f_igosja_assist_1($game_result, 'guest');
                $game_result = f_igosja_assist_2($game_result, 'guest');
                $game_result = f_igosja_team_score_increase($game_result, 'guest', 'home');
                $game_result = f_igosja_plus_minus_increase($game_result, 'guest', 'home');
                $game_result = f_igosja_player_score_increase($game_result, 'guest', 'home');
                $game_result = f_igosja_player_assist_1_increase($game_result, 'guest', 'home');
                $game_result = f_igosja_player_assist_2_increase($game_result, 'guest', 'home');
                $game_result = f_igosja_current_penalty_decrease_after_goal($game_result, 'guest', 'home');
            }
        }
    }
}

$score = $game_result['home']['team']['score']['total'] . ':' . $game_result['guest']['team']['score']['total'];
if (isset($game_score_array[$score]))
{
    $game_score_array[$score]++;
}
else
{
    $game_score_array[$score] = 1;
}

$score_sum = $score_sum + $game_result['home']['team']['score']['total'] + $game_result['guest']['team']['score']['total'];

$score_dif = $game_result['home']['team']['score']['total'] - $game_result['guest']['team']['score']['total'];
if (isset($game_score_dif_array[$score_dif]))
{
    $game_score_dif_array[$score_dif]++;
}
else
{
    $game_score_dif_array[$score_dif] = 1;
}

if ($score_dif < 0)
{
    if (isset($game_score_wdl_array['l']))
    {
        $game_score_wdl_array['l']++;
    }
    else
    {
        $game_score_wdl_array['l'] = 1;
    }
}
elseif ($score_dif > 0)
{
    if (isset($game_score_wdl_array['w']))
    {
        $game_score_wdl_array['w']++;
    }
    else
    {
        $game_score_wdl_array['w'] = 1;
    }
}
else
{
    if (isset($game_score_wdl_array['d']))
    {
        $game_score_wdl_array['d']++;
    }
    else
    {
        $game_score_wdl_array['d'] = 1;
    }
}
}

asort($game_score_array);
ksort($game_score_dif_array);

foreach ($game_score_array as $key => $value)
{
    $game_score_array[$key] = round($value / $max_i * 100, 1);
}

foreach ($game_score_dif_array as $key => $value)
{
    $game_score_dif_array[$key] = round($value / $max_i * 100, 1);
}

$score_sum = round($score_sum / $max_i, 2);

print "\r\n";
print_r($score_sum);
//print "\r\n";
//print_r($game_score_array);
print "\r\n";
print_r($game_score_dif_array);
print "\r\n";
print_r($game_score_wdl_array);
exit;