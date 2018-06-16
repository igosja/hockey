<?php

/**
 * @var $num_get integer
 */

$select = 'team_id';

if (STATISTIC_TEAM_NO_PASS == $num_get)
{
    $select = 'statisticteam_game_no_pass';
}
elseif (STATISTIC_TEAM_NO_SCORE == $num_get)
{
    $select = 'statisticteam_game_no_score';
}
elseif (STATISTIC_TEAM_LOOSE == $num_get)
{
    $select = 'statisticteam_loose';
}
elseif (STATISTIC_TEAM_LOOSE_BULLET == $num_get)
{
    $select = 'statisticteam_loose_bullet';
}
elseif (STATISTIC_TEAM_LOOSE_OVER == $num_get)
{
    $select = 'statisticteam_loose_over';
}
elseif (STATISTIC_TEAM_PASS == $num_get)
{
    $select = 'statisticteam_pass';
}
elseif (STATISTIC_TEAM_SCORE == $num_get)
{
    $select = 'statisticteam_score';
}
elseif (STATISTIC_TEAM_PENALTY == $num_get)
{
    $select = 'statisticteam_penalty';
}
elseif (STATISTIC_TEAM_PENALTY_OPPONENT == $num_get)
{
    $select = 'statisticteam_penalty_opponent';
}
elseif (STATISTIC_TEAM_WIN == $num_get)
{
    $select = 'statisticteam_win';
}
elseif (STATISTIC_TEAM_WIN_BULLET == $num_get)
{
    $select = 'statisticteam_win_bullet';
}
elseif (STATISTIC_TEAM_WIN_OVER == $num_get)
{
    $select = 'statisticteam_win_over';
}
elseif (STATISTIC_TEAM_WIN_PERCENT == $num_get)
{
    $select = 'statisticteam_win_percent';
}
elseif (STATISTIC_PLAYER_ASSIST == $num_get)
{
    $select = 'statisticplayer_assist';
}
elseif (STATISTIC_PLAYER_ASSIST_POWER == $num_get)
{
    $select = 'statisticplayer_assist_power';
}
elseif (STATISTIC_PLAYER_ASSIST_SHORT == $num_get)
{
    $select = 'statisticplayer_assist_short';
}
elseif (STATISTIC_PLAYER_BULLET_WIN == $num_get)
{
    $select = 'statisticplayer_bullet_win';
}
elseif (STATISTIC_PLAYER_FACE_OFF == $num_get)
{
    $select = 'statisticplayer_face_off';
}
elseif (STATISTIC_PLAYER_FACE_OFF_PERCENT == $num_get)
{
    $select = 'statisticplayer_face_off_percent';
}
elseif (STATISTIC_PLAYER_FACE_OFF_WIN == $num_get)
{
    $select = 'statisticplayer_face_off_win';
}
elseif (STATISTIC_PLAYER_GAME == $num_get)
{
    $select = 'statisticplayer_game';
}
elseif (STATISTIC_PLAYER_LOOSE == $num_get)
{
    $select = 'statisticplayer_loose';
}
elseif (STATISTIC_PLAYER_PASS == $num_get)
{
    $select = 'statisticplayer_pass';
}
elseif (STATISTIC_PLAYER_PASS_PER_GAME == $num_get)
{
    $select = 'statisticplayer_pass_per_game';
}
elseif (STATISTIC_PLAYER_PENALTY == $num_get)
{
    $select = 'statisticplayer_penalty';
}
elseif (STATISTIC_PLAYER_PLUS_MINUS == $num_get)
{
    $select = 'statisticplayer_plus_minus';
}
elseif (STATISTIC_PLAYER_POINT == $num_get)
{
    $select = 'statisticplayer_point';
}
elseif (STATISTIC_PLAYER_SAVE == $num_get)
{
    $select = 'statisticplayer_save';
}
elseif (STATISTIC_PLAYER_SAVE_PERCENT == $num_get)
{
    $select = 'statisticplayer_save_percent';
}
elseif (STATISTIC_PLAYER_SCORE == $num_get)
{
    $select = 'statisticplayer_score';
}
elseif (STATISTIC_PLAYER_SCORE_DRAW == $num_get)
{
    $select = 'statisticplayer_score_draw';
}
elseif (STATISTIC_PLAYER_SCORE_POWER == $num_get)
{
    $select = 'statisticplayer_score_power';
}
elseif (STATISTIC_PLAYER_SCORE_SHORT == $num_get)
{
    $select = 'statisticplayer_score_short';
}
elseif (STATISTIC_PLAYER_SCORE_SHOT_PERCENT == $num_get)
{
    $select = 'statisticplayer_score_shot_percent';
}
elseif (STATISTIC_PLAYER_SCORE_WIN == $num_get)
{
    $select = 'statisticplayer_score_win';
}
elseif (STATISTIC_PLAYER_SHOT == $num_get)
{
    $select = 'statisticplayer_shot';
}
elseif (STATISTIC_PLAYER_SHOT_GK == $num_get)
{
    $select = 'statisticplayer_shot_gk';
}
elseif (STATISTIC_PLAYER_SHOT_PER_GAME == $num_get)
{
    $select = 'statisticplayer_shot_per_game';
}
elseif (STATISTIC_PLAYER_SHUTOUT == $num_get)
{
    $select = 'statisticplayer_shutout';
}
elseif (STATISTIC_PLAYER_WIN == $num_get)
{
    $select = 'statisticplayer_win';
}

if (in_array($num_get, array(
    STATISTIC_PLAYER_LOOSE,
    STATISTIC_PLAYER_PASS,
    STATISTIC_PLAYER_PASS_PER_GAME,
    STATISTIC_PLAYER_PENALTY,
    STATISTIC_TEAM_LOOSE,
    STATISTIC_TEAM_LOOSE_BULLET,
    STATISTIC_TEAM_LOOSE_OVER,
    STATISTIC_TEAM_NO_SCORE,
    STATISTIC_TEAM_PASS,
    STATISTIC_TEAM_PENALTY,
)))
{
    $sort = 'ASC';
}
else
{
    $sort = 'DESC';
}