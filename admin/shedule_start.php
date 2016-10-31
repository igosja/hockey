<?php

include (__DIR__ . '/../include/include.php');

//Начало формирования календаря
$shedule_insert_array       = array();
$shedule_friendly_array     = array(6, 13, 20, 27, 34, 41, 48, 55, 61, 62);
$shedule_offseason_array    = array(0, 1, 2, 3, 4, 5, 7, 8, 9, 10, 11, 12);
$shedule_stage_array        = array(
     2,  3,  4,  5,  6,  7, 1,
     8,  9, 10, 11, 12, 13, 1,
     2,  3,  4,  5,  6,  7, 1,
     8,  9, 10, 11, 12, 13, 1,
    14, 15, 16, 17, 18, 19, 1,
    20, 21, 22, 23, 24, 25, 1,
    26, 27, 28, 29, 30, 31, 1,
    43, 43, 43, 44, 44, 44, 1,
    45, 45, 45, 45, 45,  1, 1
);

$start_date = strtotime('Mon') + 12 * 60 * 60;

for ($i=0; $i<63; $i++)
{
    $date = $start_date + $i * 24 * 60 *60;

    if (in_array($i, $shedule_friendly_array))
    {
        $tournament_type = TOURNAMENTTYPE_FRIENDLY;
    }
    elseif (in_array($i, $shedule_offseason_array))
    {
        $tournament_type = TOURNAMENTTYPE_OFFSEASON;
    }
    else
    {
        $tournament_type = TOURNAMENTTYPE_CHAMPIONSHIP;
    }

    $shedule_insert_array[] = "('$date', '1', '$shedule_stage_array[$i]', '$tournament_type')";
}

$shedule_insert_array = implode(',', $shedule_insert_array);

$sql = "INSERT INTO `shedule` (`shedule_date`, `shedule_season_id`, `shedule_stage_id`, `shedule_tournamenttype_id`)
        VALUES $shedule_insert_array;";
igosja_db_query($sql);
//Конец формирования календаря

//Начало формирования таблицы и матчей кубка межсезонья
$game_array = array();

$sql = "INSERT INTO `offseason` (`offseason_season_id`, `offseason_team_id`)
        SELECT '$igosja_season_id', `team_id`
        FROM `team`
        WHERE `team_id`!='0'
        ORDER BY `team_id` ASC";
igosja_db_query($sql);

$sql = "SELECT `shedule_id`
        FROM `shedule`
        WHERE `shedule_tournamenttype_id`='" . TOURNAMENTTYPE_OFFSEASON . "'
        AND `shedule_stage_id`='" . STAGE_1_TOUR . "'
        AND `shedule_season_id`='$igosja_season_id'
        LIMIT 1";
$shedule_sql = igosja_db_query($sql);

$shedule_array = $shedule_sql->fetch_all(1);

$shedule_id = $shedule_array[0]['shedule_id'];

$sql = "SELECT `offseason_team_id`
        FROM `offseason`
        WHERE `offseason_season_id`='$igosja_season_id'
        ORDER BY RAND()";
$team_sql = igosja_db_query($sql);

$count_team = $team_sql->num_rows;
$team_array = $team_sql->fetch_all(1);

for ($i=0; $i<$count_team; $i=$i+2)
{
    $team_1_id      = $team_array[$i]['team_id'];
    $team_2_id      = $team_array[$i+1]['team_id'];
    $game_array[]   = "('$team_1_id', '$team_2_id', '$shedule_id')";
}

$game_array = implode(', ', $game_array);

$sql = "INSERT INTO `game` (`game_guest_team_id`, `game_home_team_id`, `game_shedule_id`)
        VALUES $game_array;";
igosja_db_query($sql);
//Конец формирования таблицы и матчей кубка межсезонья

//Начало формирования таблиц и матчей чемпионата
$sql = "SELECT `city_country_id`
        FROM `team`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        WHERE `team_id`!='0'
        GROUP BY `city_country_id`
        ORDER BY `city_country_id` ASC";
$country_sql = igosja_db_query($sql);

$country_array = $country_sql->fetch_all(1);

foreach ($country_array as $country)
{
    $country_id = $country['city_country_id'];

    $sql = "INSERT INTO `championship` (`championship_country_id`, `championship_division_id`, `championship_season_id`, `championship_team_id`)
            SELECT `city_country_id`, '1', '$igosja_season_id', `team_id`
            FROM `team`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`city_id`
            WHERE `team_id`!='0'
            AND `city_country_id`='$country_id'
            ORDER BY `team_id` ASC
            LIMIT 16";
    igosja_db_query($sql);

    $sql = "INSERT INTO `championship` (`championship_country_id`, `championship_division_id`, `championship_season_id`, `championship_team_id`)
            SELECT `city_country_id`, '2', '$igosja_season_id', `team_id`
            FROM `team`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`city_id`
            WHERE `team_id`!='0'
            AND `city_country_id`='$country_id'
            ORDER BY `team_id` ASC
            LIMIT 16, 16";
    igosja_db_query($sql);
}
//Конец формирования таблиц и матчей чемпионата

//Начало формирования таблицы и матчей конференции
$game_array = array();

$sql = "INSERT INTO `conference` (`conference_season_id`, `conference_team_id`)
        SELECT '$igosja_season_id', `team_id`
        FROM `team`
        WHERE `team_id`!='0'
        AND `team_id` NOT IN
        (
            SELECT `championship_team_id`
            FROM `championship`
            WHERE `championship_season_id`='$igosja_season_id'
        )
        ORDER BY `team_id` ASC";
igosja_db_query($sql);

$sql = "SELECT `shedule_id`
        FROM `shedule`
        WHERE `shedule_tournamenttype_id`='" . TOURNAMENTTYPE_CONFERENCE . "'
        AND `shedule_stage_id`='" . STAGE_1_TOUR . "'
        AND `shedule_season_id`='$igosja_season_id'
        LIMIT 1";
$shedule_sql = igosja_db_query($sql);

$shedule_array = $shedule_sql->fetch_all(1);

$shedule_id = $shedule_array[0]['shedule_id'];

$sql = "SELECT `conference_team_id`
        FROM `conference`
        WHERE `conference_season_id`='$igosja_season_id'
        ORDER BY RAND()";
$team_sql = igosja_db_query($sql);

$count_team = $team_sql->num_rows;
$team_array = $team_sql->fetch_all(1);

for ($i=0; $i<$count_team; $i=$i+2)
{
    $team_1_id      = $team_array[$i]['team_id'];
    $team_2_id      = $team_array[$i+1]['team_id'];
    $game_array[]   = "('$team_1_id', '$team_2_id', '$shedule_id')";
}

$game_array = implode(', ', $game_array);

$sql = "INSERT INTO `game` (`game_guest_team_id`, `game_home_team_id`, `game_shedule_id`)
        VALUES $game_array;";
igosja_db_query($sql);
//Конец формирования таблицы и матчей конференции

redirect('/admin/index.php');