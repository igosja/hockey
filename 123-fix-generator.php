<?php

include(__DIR__ . '/include/generator.php');

$total_count = 1;

$result_array = array(
    'score_per_game' => 0,
    'score' => array(),
    'diff' => array(),
    'shot_home' => 0,
    'shot_guest' => 0,
);

$game_id            = 1;
$stage_id           = 1;
$guest_national_id  = 0;
$guest_team_id      = 1;
$game_guest_team_id = $guest_team_id;
$home_national_id   = 0;
$home_team_id       = 2;
$game_home_team_id  = $home_team_id;
$tournamenttype_id  = TOURNAMENTTYPE_CHAMPIONSHIP;
$igosja_season_id   = 1;

for ($z=0; $z<$total_count; $z++)
{
$game_result = f_igosja_prepare_game_result_array($game_id, $home_national_id, $home_team_id, $guest_national_id, $guest_team_id, $tournamenttype_id);

$game_result['guest']['team']['auto']      = 0;
$game_result['guest']['team']['mood']      = MOOD_NORMAL;
$game_result['guest']['team']['rude'][1]   = RUDE_NORMAL;
$game_result['guest']['team']['rude'][2]   = RUDE_NORMAL;
$game_result['guest']['team']['rude'][3]   = RUDE_NORMAL;
$game_result['guest']['team']['style'][1]  = STYLE_NORMAL;
$game_result['guest']['team']['style'][2]  = STYLE_NORMAL;
$game_result['guest']['team']['style'][3]  = STYLE_NORMAL;
$game_result['guest']['team']['tactic'][1] = TACTIC_ATACK;
$game_result['guest']['team']['tactic'][2] = TACTIC_ATACK;
$game_result['guest']['team']['tactic'][3] = TACTIC_ATACK;
$game_result['home']['team']['auto']       = 0;
$game_result['home']['team']['mood']       = MOOD_NORMAL;
$game_result['home']['team']['rude'][1]    = RUDE_NORMAL;
$game_result['home']['team']['rude'][2]    = RUDE_NORMAL;
$game_result['home']['team']['rude'][3]    = RUDE_NORMAL;
$game_result['home']['team']['style'][1]   = STYLE_NORMAL;
$game_result['home']['team']['style'][2]   = STYLE_NORMAL;
$game_result['home']['team']['style'][3]   = STYLE_NORMAL;
$game_result['home']['team']['tactic'][1]  = TACTIC_NORMAL;
$game_result['home']['team']['tactic'][2]  = TACTIC_NORMAL;
$game_result['home']['team']['tactic'][3]  = TACTIC_NORMAL;

$game_result = f_igosja_count_home_bonus($game_result, 0, 10000, 10000);

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

    $game_result[$team]['player']['gk']['age']              = 18;
    $game_result[$team]['player']['gk']['lineup_id']        = 1;
    $game_result[$team]['player']['gk']['player_id']        = 1;
    $game_result[$team]['player']['gk']['power_nominal']    = 100*($i+1);
    $game_result[$team]['player']['gk']['power_nominal']    = 100;
    $game_result[$team]['player']['gk']['power_optimal']    = 100*($i+1);
    $game_result[$team]['player']['gk']['power_optimal']    = 100;

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

        $game_result[$team]['player']['field'][$key]['age']             = 18;
        $game_result[$team]['player']['field'][$key]['lineup_id']       = 1;
        $game_result[$team]['player']['field'][$key]['player_id']       = 1;
        $game_result[$team]['player']['field'][$key]['power_nominal']   = 100*($i+1);
        $game_result[$team]['player']['field'][$key]['power_nominal']   = 100;
        $game_result[$team]['player']['field'][$key]['power_optimal']   = 100*($i+1);
        $game_result[$team]['player']['field'][$key]['power_optimal']   = 100;
        $game_result[$team]['player']['field'][$key]['style']           = STYLE_NORMAL;
    }
}

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

    $game_result[$team]['player']['gk']['power_optimal'] = round(
        $game_result[$team]['player']['gk']['power_optimal']
        * (10 - $game_result[$team]['team']['mood'] + 2) / 10
    );

    for ($line=1; $line<=3; $line++)
    {
        for ($k=POSITION_LD; $k<=POSITION_RW; $k++)
        {
            if     (POSITION_LD == $k) { $key = 'ld'; }
            elseif (POSITION_RD == $k) { $key = 'rd'; }
            elseif (POSITION_LW == $k) { $key = 'lw'; }
            elseif (POSITION_C  == $k) { $key =  'c'; }
            else                       { $key = 'rw'; }

            $key = $key . '_' . $line;

            if (in_array($k, array(POSITION_LD, POSITION_RD)))
            {
                if (TACTIC_ATACK_SUPER == $game_result[$team]['team']['tactic'][$line])
                {
                    $tactic = -10 / 2;
                }
                elseif (TACTIC_ATACK == $game_result[$team]['team']['tactic'][$line])
                {
                    $tactic = -5 / 2;
                }
                elseif (TACTIC_DEFENCE == $game_result[$team]['team']['tactic'][$line])
                {
                    $tactic = 5 / 2;
                }
                elseif (TACTIC_DEFENCE_SUPER == $game_result[$team]['team']['tactic'][$line])
                {
                    $tactic = 10 / 2;
                }
                else
                {
                    $tactic = 0;
                }
            }
            else
            {
                if (TACTIC_ATACK_SUPER == $game_result[$team]['team']['tactic'][$line])
                {
                    $tactic = 10 / 3;
                }
                elseif (TACTIC_ATACK == $game_result[$team]['team']['tactic'][$line])
                {
                    $tactic = 5 / 3;
                }
                elseif (TACTIC_DEFENCE == $game_result[$team]['team']['tactic'][$line])
                {
                    $tactic = -5 / 3;
                }
                elseif (TACTIC_DEFENCE_SUPER == $game_result[$team]['team']['tactic'][$line])
                {
                    $tactic = -10 / 3;
                }
                else
                {
                    $tactic = 0;
                }
            }

            $game_result[$team]['player']['field'][$key]['power_optimal'] = round(
                $game_result[$team]['player']['field'][$key]['power_optimal']
                * (10 - $game_result[$team]['team']['mood'] + 2) / 10
                * (100 + $game_result[$team]['team']['rude'][$line] - 1) / 100
                * (100 + $tactic) / 100
            );
        }
    }
}

//$game_result = f_igosja_count_player_bonus($game_result);
//$game_result = f_igosja_get_teamwork($game_result);
//$game_result = f_igosja_set_teamwork($game_result);
//$game_result = f_igosja_collision($game_result);
//$game_result = f_igosja_player_optimal_power($game_result);
//$game_result = f_igosja_get_player_real_power_from_optimal($game_result);
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

//if ($game_result['home']['team']['power']['percent'] > 52 && $game_result['home']['player']['gk']['power_real'] / $game_result['guest']['team']['power']['total'] * 16 >= 0.75)
//{
//    $should_win = 1;
//}
//elseif ($game_result['guest']['team']['power']['percent'] > 52 && $game_result['guest']['player']['gk']['power_real'] / $game_result['home']['team']['power']['total'] * 16 >= 0.75)
//{
//    $should_win = -1;
//}

for ($game_result['minute']=0; $game_result['minute']<60; $game_result['minute']++)
{
    $game_result = f_igosja_defence($game_result);
    $game_result = f_igosja_forward($game_result);

    $rude_home  = $game_result['home']['team']['rude'][$game_result['minute'] % 3 + 1];
    $rude_guest = $game_result['guest']['team']['rude'][$game_result['minute'] % 3 + 1];

    if (rand(0, 40) >= 38 - $rude_home * RUDE_PENALTY && 1 == rand(0, 1))
    {
        $game_result['player'] = rand(POSITION_LD, POSITION_RW);

        $game_result = f_igosja_event_penalty($game_result, 'home');
        $game_result = f_igosja_player_penalty_increase($game_result, 'home');
        $game_result = f_igosja_current_penalty_increase($game_result, 'home');
        $game_result = f_igosja_team_penalty_increase($game_result, 'home');
    }

    if (rand(0, 40) >= 38 - $rude_guest * RUDE_PENALTY && 1 == rand(0, 1))
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

            if (rand($shot_power / 5, $shot_power) > rand($gk_power / 5, $gk_power * 6) && f_igosja_can_score($game_result, $should_win, 'home', 'guest'))
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

            if (rand($shot_power / 5, $shot_power) > rand($gk_power / 5, $gk_power * 6) && f_igosja_can_score($game_result, $should_win, 'guest', 'home'))
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

        if (rand(0, 40) >= 37 && 1 == rand(0, 1))
        {
            $game_result['player'] = rand(POSITION_LD, POSITION_RW);

            $game_result = f_igosja_event_penalty($game_result, 'home');
            $game_result = f_igosja_player_penalty_increase($game_result, 'home');
            $game_result = f_igosja_current_penalty_increase($game_result, 'home');
            $game_result = f_igosja_team_penalty_increase($game_result, 'home');
        }

        if (rand(0, 40) >= 37 && 1 == rand(0, 1))
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

                if (rand($shot_power / 5, $shot_power) > rand($gk_power / 5, $gk_power * 6) && f_igosja_can_score($game_result, $should_win, 'home', 'guest'))
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

        if ($game_result['minute'] < 65)
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

                    if (rand($shot_power / 5, $shot_power) > rand($gk_power / 5, $gk_power * 6) && f_igosja_can_score($game_result, $should_win, 'guest', 'home'))
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

$diff = $game_result['home']['team']['score']['total'] - $game_result['guest']['team']['score']['total'];
$total = $game_result['home']['team']['score']['total'] + $game_result['guest']['team']['score']['total'];
if (!isset($result_array['diff'][$diff])) {
    $result_array['diff'][$diff] = 0;
}
if (!isset($result_array['score'][$total])) {
    $result_array['score'][$total] = 0;
}
$result_array['diff'][$diff]++;
$result_array['score'][$total]++;
$result_array['score_per_game'] = $result_array['score_per_game'] + $total;
$result_array['shot_guest'] = $result_array['shot_guest'] + $game_result['guest']['team']['shot']['total'];
$result_array['shot_home'] = $result_array['shot_home'] + $game_result['home']['team']['shot']['total'];
}
ksort($result_array['diff']);
ksort($result_array['score']);
$result_array['score_per_game'] = $result_array['score_per_game'] / $total_count;
$result_array['shot_guest'] = $result_array['shot_guest'] / $total_count;
$result_array['shot_home'] = $result_array['shot_home'] / $total_count;

print_r($game_result['guest']['player']['gk']['power_real']);
print "\r\n";
print_r($game_result['guest']['player']['field']['rd_1']['power_real']);
print "\r\n";
print_r($game_result['guest']['player']['field']['ld_1']['power_real']);
print "\r\n";
print_r($game_result['guest']['player']['field']['rw_1']['power_real']);
print "\r\n";
print_r($game_result['guest']['player']['field']['c_1']['power_real']);
print "\r\n";
print_r($game_result['guest']['player']['field']['lw_1']['power_real']);
print "\r\n";
print_r($result_array);
exit;