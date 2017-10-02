<?php

/**
 * @var $igosja_season_id integer
 * @var $season_id integer
 */

include(__DIR__ . '/include/include.php');

$sql = "SELECT `statisticchapter_id`,
               `statisticchapter_name`,
               `statistictype_id`,
               `statistictype_name`
        FROM `statistictype`
        LEFT JOIN `statisticchapter`
        ON `statistictype_statisticchapter_id`=`statisticchapter_id`
        ORDER BY `statisticchapter_id` ASC, `statistictype_id` ASC";
$statistictype_sql = f_igosja_mysqli_query($sql, false);

$count_statistictype = $statistictype_sql->num_rows;
$statistictype_array = $statistictype_sql->fetch_all(1);

if (!$num_get = f_igosja_request_get('num'))
{
    $num_get = $statistictype_array[0]['statistictype_id'];
}

if (!$season_id = f_igosja_request_get('season_id'))
{
    $season_id = $igosja_season_id;
}

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
    STATISTIC_TEAM_NO_PASS,
    STATISTIC_TEAM_NO_SCORE,
    STATISTIC_TEAM_LOOSE,
    STATISTIC_TEAM_LOOSE_BULLET,
    STATISTIC_TEAM_LOOSE_OVER,
    STATISTIC_TEAM_PASS,
    STATISTIC_TEAM_SCORE,
    STATISTIC_TEAM_PENALTY,
    STATISTIC_TEAM_PENALTY_OPPONENT,
    STATISTIC_TEAM_WIN,
    STATISTIC_TEAM_WIN_BULLET,
    STATISTIC_TEAM_WIN_OVER,
    STATISTIC_TEAM_WIN_PERCENT,
)))
{
    $sql = "SELECT $select,
                   `city_name`,
                   `country_id`,
                   `country_name`,
                   `team_id`,
                   `team_name`
            FROM `statisticteam`
            LEFT JOIN `team`
            ON `statisticteam_team_id`=`team_id`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`city_id`
            LEFT JOIN `country`
            ON `city_country_id`=`country_id`
            WHERE `statisticteam_tournamenttype_id`=" . TOURNAMENTTYPE_OFFSEASON . "
            AND `statisticteam_season_id`=$season_id
            ORDER BY $select
            LIMIT 100";
}
elseif (in_array($num_get, array(
    STATISTIC_PLAYER_ASSIST,
    STATISTIC_PLAYER_ASSIST_POWER,
    STATISTIC_PLAYER_ASSIST_SHORT,
    STATISTIC_PLAYER_BULLET_WIN,
    STATISTIC_PLAYER_FACE_OFF,
    STATISTIC_PLAYER_FACE_OFF_PERCENT,
    STATISTIC_PLAYER_FACE_OFF_WIN,
    STATISTIC_PLAYER_GAME,
    STATISTIC_PLAYER_LOOSE,
    STATISTIC_PLAYER_PASS,
    STATISTIC_PLAYER_PASS_PER_GAME,
    STATISTIC_PLAYER_PENALTY,
    STATISTIC_PLAYER_PLUS_MINUS,
    STATISTIC_PLAYER_POINT,
    STATISTIC_PLAYER_SAVE,
    STATISTIC_PLAYER_SAVE_PERCENT,
    STATISTIC_PLAYER_SCORE,
    STATISTIC_PLAYER_SCORE_DRAW,
    STATISTIC_PLAYER_SCORE_POWER,
    STATISTIC_PLAYER_SCORE_SHORT,
    STATISTIC_PLAYER_SCORE_SHOT_PERCENT,
    STATISTIC_PLAYER_SCORE_WIN,
    STATISTIC_PLAYER_SHOT,
    STATISTIC_PLAYER_SHOT_GK,
    STATISTIC_PLAYER_SHOT_PER_GAME,
    STATISTIC_PLAYER_SHUTOUT,
    STATISTIC_PLAYER_WIN,
)))
{
    if (in_array($num_get, array(
        STATISTIC_PLAYER_PASS,
        STATISTIC_PLAYER_PASS_PER_GAME,
        STATISTIC_PLAYER_SAVE,
        STATISTIC_PLAYER_SAVE_PERCENT,
        STATISTIC_PLAYER_SHOT_GK,
    )))
    {
        $where = 'AND `statisticplayer_is_gk`=1';
    }
    else
    {
        $where = '';
    }

    $sql = "SELECT $select,
                   `city_name`,
                   `country_id`,
                   `country_name`,
                   `name_name`,
                   `player_id`,
                   `surname_name`,
                   `team_id`,
                   `team_name`
            FROM `statisticplayer`
            LEFT JOIN `player`
            ON `statisticplayer_player_id`=`player_id`
            LEFT JOIN `name`
            ON `player_name_id`=`name_id`
            LEFT JOIN `surname`
            ON `player_surname_id`=`surname_id`
            LEFT JOIN `team`
            ON `statisticplayer_team_id`=`team_id`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`city_id`
            LEFT JOIN `country`
            ON `city_country_id`=`country_id`
            WHERE `statisticplayer_tournamenttype_id`=" . TOURNAMENTTYPE_OFFSEASON . "
            AND `statisticplayer_season_id`=$season_id
            $where
            ORDER BY $select
            LIMIT 100";
}

$statistic_sql = f_igosja_mysqli_query($sql, false);

$count_statistic = $statistic_sql->num_rows;
$statistic_array = $statistic_sql->fetch_all(1);

$seo_title          = 'Статистика кубка межсезонья';
$seo_description    = 'Кубок межсезонья, статистика на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'кубок межсезонья статистика';

include(__DIR__ . '/view/layout/main.php');