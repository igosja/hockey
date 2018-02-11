<?php

/**
 * @var $select string
 * @var $sort string
 */

include(__DIR__ . '/include/include.php');

if (!$season_id = (int) f_igosja_request_get('season_id'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `country_name`,
               `division_name`
        FROM `championship`
        LEFT JOIN `country`
        ON `championship_country_id`=`country_id`
        LEFT JOIN `division`
        ON `championship_division_id`=`division_id`
        WHERE `championship_season_id`=$season_id
        LIMIT 1";
$country_sql = f_igosja_mysqli_query($sql);

if (0 == $country_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `statisticchapter_id`,
               `statisticchapter_name`,
               `statistictype_id`,
               `statistictype_name`
        FROM `statistictype`
        LEFT JOIN `statisticchapter`
        ON `statistictype_statisticchapter_id`=`statisticchapter_id`
        ORDER BY `statisticchapter_id` ASC, `statistictype_id` ASC";
$statistictype_sql = f_igosja_mysqli_query($sql);

$count_statistictype = $statistictype_sql->num_rows;
$statistictype_array = $statistictype_sql->fetch_all(MYSQLI_ASSOC);

if (!$num_get = f_igosja_request_get('num'))
{
    $num_get = $statistictype_array[0]['statistictype_id'];
}

include(__DIR__ . '/include/statistic_select_sort.php');

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
            WHERE `statisticteam_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
            AND `statisticteam_season_id`=$season_id
            ORDER BY $select $sort
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
            WHERE `statisticplayer_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
            AND `statisticplayer_season_id`=$season_id
            $where
            ORDER BY $select $sort
            LIMIT 100";
}

$statistic_sql = f_igosja_mysqli_query($sql);

$count_statistic = $statistic_sql->num_rows;
$statistic_array = $statistic_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = 'Статистика. Лига чемпионов';
$seo_description    = 'Лига чемпионов, статистика на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'лига чемпионов статистика';

include(__DIR__ . '/view/layout/main.php');