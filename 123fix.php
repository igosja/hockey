<?php

$start_time = microtime(true);

date_default_timezone_set('Europe/Moscow');

include(__DIR__ . '/include/function.php');
include(__DIR__ . '/include/constant.php');

$file_list = scandir(__DIR__ . '/console/folder/generator/secondary');
$file_list = array_slice($file_list, 2);

foreach ($file_list as $item) {
    include(__DIR__ . '/console/folder/generator/secondary/' . $item);
}

$game_score_array = array();
$game_score_wdl_array = array();
$game_score_dif_array = array();
$score_sum = 0;

$max_i = 5000;
$power_bonus = 25;

for ($game_list = 0; $game_list < $max_i; $game_list++) {

    $field_player_array = array();

    for ($h = 0; $h < 2; $h++) {
        for ($j = 1; $j <= 3; $j++) {
            for ($k = POSITION_LD; $k <= POSITION_RW; $k++) {
                if (POSITION_LD == $k) {
                    $key = 'ld';
                } elseif (POSITION_RD == $k) {
                    $key = 'rd';
                } elseif (POSITION_LW == $k) {
                    $key = 'lw';
                } elseif (POSITION_C == $k) {
                    $key = 'c';
                } else {
                    $key = 'rw';
                }

                $key = $key . '_' . $j;

                $field_player_array[$key] = array(
                    'age' => 0,
                    'assist' => 0,
                    'assist_power' => 0,
                    'assist_short' => 0,
                    'bonus' => 0,
                    'bullet_win' => 0,
                    'face_off' => 0,
                    'face_off_win' => 0,
                    'game' => 1,
                    'lineup_id' => 0,
                    'loose' => 0,
                    'penalty' => 0,
                    'player_id' => 0,
                    'plus_minus' => 0,
                    'point' => 0,
                    'power_nominal' => 0,
                    'power_optimal' => 0,
                    'power_real' => 50 + $h * $power_bonus,
                    'score' => 0,
                    'score_draw' => 0,
                    'score_power' => 0,
                    'score_short' => 0,
                    'score_win' => 0,
                    'shot' => 0,
                    'style' => 0,
                    'win' => 0,
                );
            }
        }

        $team_array[$h] = array(
            'player' => array(
                'gk' => array(
                    'age' => 0,
                    'assist' => 0,
                    'assist_power' => 0,
                    'assist_short' => 0,
                    'bonus' => 0,
                    'game' => 1,
                    'game_with_bullet' => 0,
                    'lineup_id' => 0,
                    'loose' => 0,
                    'pass' => 0,
                    'player_id' => 0,
                    'point' => 0,
                    'power_nominal' => 0,
                    'power_optimal' => 0,
                    'power_real' => 50 + $h * $power_bonus,
                    'save' => 0,
                    'shot' => 0,
                    'shutout' => 0,
                    'win' => 0,
                ),
                'field' => $field_player_array,
            ),
            'team' => array(
                'auto' => 0,
                'collision' => array(
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
        'event' => array(),
        'face_off_guest' => 0,
        'face_off_home' => 0,
        'game_info' => array(
            'home_bonus' => 1,
        ),
        'guest' => $team_array[0],
        'home' => $team_array[1],
        'minute' => 0,
        'player' => 0,
        'assist_1' => 0,
        'assist_2' => 0,
    );

    for ($i = 0; $i < 2; $i++) {
        if (0 == $i) {
            $team = TEAM_HOME;
        } else {
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

    for ($game_result['minute'] = 0; $game_result['minute'] < 60; $game_result['minute']++) {
        $game_result = f_igosja_defence($game_result);
        $game_result = f_igosja_forward($game_result);

        $rude_home = $game_result['home']['team']['rude'][$game_result['minute'] % 3 + 1];
        $rude_guest = $game_result['guest']['team']['rude'][$game_result['minute'] % 3 + 1];

        if (rand(0, 40) >= 34 - $rude_home * RUDE_PENALTY && 1 == rand(0, 1)) {
            $game_result['player'] = rand(POSITION_LD, POSITION_RW);

            $game_result = f_igosja_player_penalty_increase($game_result, 'home');
            $game_result = f_igosja_current_penalty_increase($game_result, 'home');
            $game_result = f_igosja_team_penalty_increase($game_result, 'home');
        }

        if (rand(0, 40) >= 34 - $rude_guest * RUDE_PENALTY && 1 == rand(0, 1)) {
            $game_result['player'] = rand(POSITION_LD, POSITION_RW);

            $game_result = f_igosja_player_penalty_increase($game_result, 'guest');
            $game_result = f_igosja_current_penalty_increase($game_result, 'guest');
            $game_result = f_igosja_team_penalty_increase($game_result, 'guest');
        }

        $game_result = f_igosja_current_penalty_decrease($game_result);
        $game_result = f_igosja_face_off($game_result);

        $home_penalty_current = count($game_result['home']['team']['penalty']['current']);

        if ($home_penalty_current > 2) {
            $home_penalty_current = 2;
        }

        $guest_penalty_current = count($game_result['guest']['team']['penalty']['current']);

        if ($guest_penalty_current > 2) {
            $guest_penalty_current = 2;
        }

        $defence = $game_result['home']['team']['power']['defence']['current'] / (1 + $home_penalty_current);
        $forward = $game_result['guest']['team']['power']['forward']['current'] / (2 + $guest_penalty_current);

        if (rand(0, $defence) > rand(0, $forward)) {
            $forward = $game_result['home']['team']['power']['forward']['current'] / (1 + $home_penalty_current);
            $defence = $game_result['guest']['team']['power']['defence']['current'] / (2 + $guest_penalty_current);

            if (rand(0, $forward) > rand(0, $defence)) {
                $game_result = f_igosja_select_player_shot($game_result, 'home');
                $game_result = f_igosja_team_shot_increase($game_result, 'home', 'guest');
                $game_result = f_igosja_player_shot_increase($game_result, 'home');
                $game_result = f_igosja_player_shot_power($game_result, 'home');

                $shot_power = $game_result['home']['team']['power']['shot'];
                $gk_power = $game_result['guest']['team']['power']['gk'];

                $score_koeff = (100 + 10 / ($game_result['home']['team']['score']['total'] + 1) * 10 - 55) / 100;
                $score_koeff = 1;

                if (rand($shot_power / 5, $shot_power * $score_koeff) > rand($gk_power / 5, $gk_power * 6)) {
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

        if (rand(0, $defence) > rand(0, $forward)) {
            $forward = $game_result['guest']['team']['power']['forward']['current'] / (1 + $guest_penalty_current);
            $defence = $game_result['home']['team']['power']['defence']['current'] / (2 + $home_penalty_current);

            if (rand(0, $forward) > rand(0, $defence)) {
                $game_result = f_igosja_select_player_shot($game_result, 'guest');
                $game_result = f_igosja_team_shot_increase($game_result, 'guest', 'home');
                $game_result = f_igosja_player_shot_increase($game_result, 'guest');
                $game_result = f_igosja_player_shot_power($game_result, 'guest');

                $shot_power = $game_result['guest']['team']['power']['shot'];
                $gk_power = $game_result['home']['team']['power']['gk'];

                $score_koeff = (100 + 10 / ($game_result['guest']['team']['score']['total'] + 1) * 10 - 55) / 100;
                $score_koeff = 1;

                if (rand($shot_power / 5, $shot_power * $score_koeff) > rand($gk_power / 5, $gk_power * 6)) {
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
    if (isset($game_score_array[$score])) {
        $game_score_array[$score]++;
    } else {
        $game_score_array[$score] = 1;
    }

    $score_sum = $score_sum + $game_result['home']['team']['score']['total'] + $game_result['guest']['team']['score']['total'];

    $score_dif = $game_result['home']['team']['score']['total'] - $game_result['guest']['team']['score']['total'];
    if (isset($game_score_dif_array[$score_dif])) {
        $game_score_dif_array[$score_dif]++;
    } else {
        $game_score_dif_array[$score_dif] = 1;
    }

    if ($score_dif < 0) {
        if (isset($game_score_wdl_array['l'])) {
            $game_score_wdl_array['l']++;
        } else {
            $game_score_wdl_array['l'] = 1;
        }
    } elseif ($score_dif > 0) {
        if (isset($game_score_wdl_array['w'])) {
            $game_score_wdl_array['w']++;
        } else {
            $game_score_wdl_array['w'] = 1;
        }
    } else {
        if (isset($game_score_wdl_array['d'])) {
            $game_score_wdl_array['d']++;
        } else {
            $game_score_wdl_array['d'] = 1;
        }
    }
}

asort($game_score_array);
ksort($game_score_dif_array);

//foreach ($game_score_array as $key => $value) {
//    $game_score_array[$key] = round($value / $max_i * 100, 1);
//}
//
//foreach ($game_score_dif_array as $key => $value) {
//    $game_score_dif_array[$key] = round($value / $max_i * 100, 1);
//}
//
//foreach ($game_score_wdl_array as $key => $value) {
//    $game_score_wdl_array[$key] = round($value / $max_i * 100, 1);
//}

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
?>
<p class="text-justify">Опираясь на результаты последнего голосавания подготовлены изменения в генератор, которые уменьшили <a href="https://ru.wikipedia.org/wiki/%D0%9D%D0%BE%D1%80%D0%BC%D0%B0%D0%BB%D1%8C%D0%BD%D0%BE%D0%B5_%D1%80%D0%B0%D1%81%D0%BF%D1%80%D0%B5%D0%B4%D0%B5%D0%BB%D0%B5%D0%BD%D0%B8%D0%B5" target="_blank">отклонение в кривой нормального распределения</a> результатов матчей.</p>
<p class="text-justify">Каждый отдельный матч может по прежнему закончиться с практически любым результатом, но вероятность "нелогичного" итога уменьшена. Таблицы ниже показывают примерное распределение результатов на 5000 матчей без учета настроек грубости, тактики, настроя и других поправочных параметров.</p>
<div class="table-responsive text-center">
    <p>Вероятность победы (в процентах)</p>
    <table class="table table-bordered table-hover">
        <tr>
            <th>Соотношение сил</th>
            <th colspan="2">50%-50%</th>
            <th colspan="2">55%-45%</th>
            <th colspan="2">60%-40%</th>
        </tr>
        <tr>
            <th></th>
            <th class="col-13">Было</th>
            <th class="col-13">Будет</th>
            <th class="col-13">Было</th>
            <th class="col-13">Будет</th>
            <th class="col-13">Было</th>
            <th class="col-13">Будет</th>
        </tr>
        <tr>
            <td>Победа 1-ой команды</td>
            <td>40%</td>
            <td>40%</td>
            <td>69,9%</td>
            <td>74,66%</td>
            <td>92,02%</td>
            <td>94,62%</td>
        </tr>
        <tr>
            <td>Ничья/овертайм</td>
            <td>20%</td>
            <td>20%</td>
            <td>13,66%</td>
            <td>13,46%</td>
            <td>5,4%</td>
            <td>3,8%</td>
        </tr>
        <tr>
            <td>Победа 2-ой команды</td>
            <td>40%</td>
            <td>40%</td>
            <td>16,44%</td>
            <td>11,88%</td>
            <td>2,58%</td>
            <td>1,58%</td>
        </tr>
    </table>
    <p>Разница в счете (в абсолютных величинах)</p>
    <table class="table table-bordered table-hover">
        <tr>
            <th>Соотношение сил</th>
            <th colspan="2">50%-50%</th>
            <th colspan="2">55%-45%</th>
            <th colspan="2">60%-40%</th>
        </tr>
        <tr>
            <th></th>
            <th class="col-13">Было</th>
            <th class="col-13">Будет</th>
            <th class="col-13">Было</th>
            <th class="col-13">Будет</th>
            <th class="col-13">Было</th>
            <th class="col-13">Будет</th>
        </tr>
        <tr>
            <td>-9 шайб и менее</td>
            <td>0</td>
            <td>1</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>
        <tr>
            <td>-8 шайб</td>
            <td>4</td>
            <td>0</td>
            <td>1</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>
        <tr>
            <td>-7 шайб</td>
            <td>4</td>
            <td>2</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>
        <tr>
            <td>-6 шайб</td>
            <td>21</td>
            <td>13</td>
            <td>1</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>
        <tr>
            <td>-5 шайб</td>
            <td>60</td>
            <td>48</td>
            <td>4</td>
            <td>2</td>
            <td>0</td>
            <td>0</td>
        </tr>
        <tr>
            <td>-4 шайбы</td>
            <td>174</td>
            <td>153</td>
            <td>29</td>
            <td>10</td>
            <td>2</td>
            <td>1</td>
        </tr>
        <tr>
            <td>-3 шайбы</td>
            <td>373</td>
            <td>299</td>
            <td>85</td>
            <td>47</td>
            <td>7</td>
            <td>3</td>
        </tr>
        <tr>
            <td>-2 шайбы</td>
            <td>594</td>
            <td>595</td>
            <td>225</td>
            <td>142</td>
            <td>27</td>
            <td>18</td>
        </tr>
        <tr>
            <td>-1 шайба</td>
            <td>806</td>
            <td>918</td>
            <td>477</td>
            <td>393</td>
            <td>93</td>
            <td>57</td>
        </tr>
        <tr>
            <td>0 шайб</td>
            <td>970</td>
            <td>1012</td>
            <td>683</td>
            <td>673</td>
            <td>270</td>
            <td>190</td>
        </tr>
        <tr>
            <td>+1 шайба</td>
            <td>814</td>
            <td>921</td>
            <td>868</td>
            <td>969</td>
            <td>478</td>
            <td>418</td>
        </tr>
        <tr>
            <td>+2 шайбы</td>
            <td>606</td>
            <td>559</td>
            <td>891</td>
            <td>1005</td>
            <td>698</td>
            <td>663</td>
        </tr>
        <tr>
            <td>+3 шайбы</td>
            <td>328</td>
            <td>301</td>
            <td>717</td>
            <td>818</td>
            <td>855</td>
            <td>927</td>
        </tr>
        <tr>
            <td>+4 шайбы</td>
            <td>146</td>
            <td>120</td>
            <td>483</td>
            <td>491</td>
            <td>839</td>
            <td>873</td>
        </tr>
        <tr>
            <td>+5 шайб</td>
            <td>65</td>
            <td>41</td>
            <td>307</td>
            <td>247</td>
            <td>712</td>
            <td>756</td>
        </tr>
        <tr>
            <td>+6 шайб</td>
            <td>28</td>
            <td>14</td>
            <td>122</td>
            <td>136</td>
            <td>466</td>
            <td>529</td>
        </tr>
        <tr>
            <td>+7 шайб</td>
            <td>4</td>
            <td>2</td>
            <td>73</td>
            <td>48</td>
            <td>296</td>
            <td>313</td>
        </tr>
        <tr>
            <td>+8 шайб</td>
            <td>3</td>
            <td>1</td>
            <td>16</td>
            <td>16</td>
            <td>159</td>
            <td>140</td>
        </tr>
        <tr>
            <td>+9 шайб и более</td>
            <td>0</td>
            <td>0</td>
            <td>18</td>
            <td>3</td>
            <td>109</td>
            <td>112</td>
        </tr>
    </table>
</div>
<p class="text-justify">Данные таблиц означают, что в текущем варианте генератора при соотношении сил 60%/40% слабая команда выиграет у сильной с перевесом в 1 шайбу 93 игры из 5000 (1,9%). После обновления вероятность победись в 1 шайбу уменьшиться до 57 игр из 5000 (1,1%)</p>
<p class="text-justify">Измениния вступят в силу во время завтрашней генерации.</p>