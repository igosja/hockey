<?php

/**
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

include(__DIR__ . '/include/sql/country_view.php');

$sql = "SELECT `leaguedistribution_group`,
               `leaguedistribution_qualification_3`,
               `leaguedistribution_qualification_2`,
               `leaguedistribution_qualification_1`,
               `leaguedistribution_season_id`
        FROM `leaguedistribution`
        WHERE `leaguedistribution_country_id`=$num_get
        ORDER BY `leaguedistribution_season_id` DESC
        LIMIT 1";
$leaguedistribution_sql = f_igosja_mysqli_query($sql);

$leaguedistribution_array = $leaguedistribution_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `participantleague_season_id`
        FROM `participantleague`
        LEFT JOIN `team`
        ON `participantleague_team_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        WHERE `city_country_id`=$num_get
        GROUP BY `participantleague_season_id`
        ORDER BY `participantleague_season_id` DESC";
$season_sql = f_igosja_mysqli_query($sql);

$season_array = $season_sql->fetch_all(MYSQLI_ASSOC);

for ($i=0; $i<$season_sql->num_rows; $i++)
{
    $season_id = $season_array[$i]['participantleague_season_id'];

    $sql = "SELECT `city_name`,
                   `leaguecoefficient_loose`,
                   `leaguecoefficient_loose_over`+`leaguecoefficient_loose_bullet` AS `leaguecoefficient_loose_over`,
                   `leaguecoefficient_point`,
                   `leaguecoefficient_win`,
                   `leaguecoefficient_win_over`+`leaguecoefficient_win_bullet` AS `leaguecoefficient_win_over`,
                   `stage_name`,
                   `team_id`,
                   `team_name`
            FROM `participantleague`
            LEFT JOIN `team`
            ON `participantleague_team_id`=`team_id`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`city_id`
            LEFT JOIN `leaguecoefficient`
            ON (`team_id`=`leaguecoefficient_team_id`
            AND `participantleague_season_id`=`leaguecoefficient_season_id`)
            LEFT JOIN `stage`
            ON `participantleague_stage_in`=`stage_id`
            WHERE `city_country_id`=$num_get
            AND `participantleague_season_id`=$season_id
            ORDER BY `leaguecoefficient_point` DESC";
    $team_sql = f_igosja_mysqli_query($sql);

    $season_array[$i]['team'] = $team_sql->fetch_all(MYSQLI_ASSOC);
}

$seo_title          = $country_array[0]['country_name'] . '. Лига чемпионов';
$seo_description    = $country_array[0]['country_name'] . '. Лига чемпионов на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $country_array[0]['country_name'] . ' лига чемпионов';

include(__DIR__ . '/view/layout/main.php');