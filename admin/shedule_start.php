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
    54, 54, 54, 55, 55, 55, 1,
    56, 56, 56, 56, 56,  1, 1
);
$shedule_conference_stage_array = array(
     2,  3,  4,  5,  6,  7, 1,
     8,  9, 10, 11, 12, 13, 1,
     2,  3,  4,  5,  6,  7, 1,
     8,  9, 10, 11, 12, 13, 1,
    14, 15, 16, 17, 18, 19, 1,
    20, 21, 22, 23, 24, 25, 1,
    26, 27, 28, 29, 30, 31, 1,
    32, 33, 34, 35, 36, 37, 1,
    38, 39, 40, 41, 42,  1, 1
);

$start_date = strtotime('Mon') + 12 * 60 * 60;

for ($i=0; $i<63; $i++)
{
    $date       = $start_date + $i * 24 * 60 *60;
    $conference = 0;

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
        $conference         = 1;
        $tournament_type    = TOURNAMENTTYPE_CHAMPIONSHIP;
        $tournament_type_c  = TOURNAMENTTYPE_CONFERENCE;
    }

    $shedule_insert_array[] = "('$date', '1', '$shedule_stage_array[$i]', '$tournament_type')";

    if ($conference)
    {
        $shedule_insert_array[] = "('$date', '1', '$shedule_conference_stage_array[$i]', '$tournament_type_c')";
    }
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
    $team_1_id      = $team_array[$i]['offseason_team_id'];
    $team_2_id      = $team_array[$i+1]['offseason_team_id'];
    $game_array[]   = "('$team_1_id', '$team_2_id', '$shedule_id')";
}

$game_array = implode(', ', $game_array);

$sql = "INSERT INTO `game` (`game_guest_team_id`, `game_home_team_id`, `game_shedule_id`)
        VALUES $game_array;";
igosja_db_query($sql);
//Конец формирования таблицы и матчей кубка межсезонья

//Начало формирования таблиц и матчей чемпионата
$championship_country_array = array();

$sql = "SELECT `city_country_id`
        FROM `team`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        WHERE `team_id`!='0'
        GROUP BY `city_country_id`
        HAVING COUNT(`team_id`)>='16'
        ORDER BY `city_country_id` ASC";
$country_sql = igosja_db_query($sql);

$country_array = $country_sql->fetch_all(1);

foreach ($country_array as $country)
{
    $country_id = $country['city_country_id'];

    $championship_country_array[] = $country_id;

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

$sql = "SELECT `shedule_id`
        FROM `shedule`
        WHERE `shedule_season_id`='$igosja_season_id'
        AND `shedule_tournamenttype_id`='" . TOURNAMENTTYPE_CHAMPIONSHIP . "'
        ORDER BY `shedule_id` ASC
        LIMIT 30";
$shedule_sql = igosja_db_query($sql);

$shedule_array = $shedule_sql->fetch_all(1);

$shedule_id_01 = $shedule_array[0]['shedule_id'];
$shedule_id_02 = $shedule_array[1]['shedule_id'];
$shedule_id_03 = $shedule_array[2]['shedule_id'];
$shedule_id_04 = $shedule_array[3]['shedule_id'];
$shedule_id_05 = $shedule_array[4]['shedule_id'];
$shedule_id_06 = $shedule_array[5]['shedule_id'];
$shedule_id_07 = $shedule_array[6]['shedule_id'];
$shedule_id_08 = $shedule_array[7]['shedule_id'];
$shedule_id_09 = $shedule_array[8]['shedule_id'];
$shedule_id_10 = $shedule_array[9]['shedule_id'];
$shedule_id_11 = $shedule_array[10]['shedule_id'];
$shedule_id_12 = $shedule_array[11]['shedule_id'];
$shedule_id_13 = $shedule_array[12]['shedule_id'];
$shedule_id_14 = $shedule_array[13]['shedule_id'];
$shedule_id_15 = $shedule_array[14]['shedule_id'];
$shedule_id_16 = $shedule_array[15]['shedule_id'];
$shedule_id_17 = $shedule_array[16]['shedule_id'];
$shedule_id_18 = $shedule_array[17]['shedule_id'];
$shedule_id_19 = $shedule_array[18]['shedule_id'];
$shedule_id_20 = $shedule_array[19]['shedule_id'];
$shedule_id_21 = $shedule_array[20]['shedule_id'];
$shedule_id_22 = $shedule_array[21]['shedule_id'];
$shedule_id_23 = $shedule_array[22]['shedule_id'];
$shedule_id_24 = $shedule_array[23]['shedule_id'];
$shedule_id_25 = $shedule_array[24]['shedule_id'];
$shedule_id_26 = $shedule_array[25]['shedule_id'];
$shedule_id_27 = $shedule_array[26]['shedule_id'];
$shedule_id_28 = $shedule_array[27]['shedule_id'];
$shedule_id_29 = $shedule_array[28]['shedule_id'];
$shedule_id_30 = $shedule_array[29]['shedule_id'];

foreach ($championship_country_array as $item)
{
    for ($i=1; $i<=2; $i++)
    {
        $sql = "SELECT `championship_team_id`
                FROM `championship`
                WHERE `championship_country_id`='$item'
                AND `championship_division_id`='$i'
                AND `championship_season_id`='$igosja_season_id'
                ORDER BY RAND()";
        $team_sql = igosja_db_query($sql);

        $team_array = $team_sql->fetch_all(1);

        $team_id_01 = $team_array[0]['championship_team_id'];
        $team_id_02 = $team_array[1]['championship_team_id'];
        $team_id_03 = $team_array[2]['championship_team_id'];
        $team_id_04 = $team_array[3]['championship_team_id'];
        $team_id_05 = $team_array[4]['championship_team_id'];
        $team_id_06 = $team_array[5]['championship_team_id'];
        $team_id_07 = $team_array[6]['championship_team_id'];
        $team_id_08 = $team_array[7]['championship_team_id'];
        $team_id_09 = $team_array[8]['championship_team_id'];
        $team_id_10 = $team_array[9]['championship_team_id'];
        $team_id_11 = $team_array[10]['championship_team_id'];
        $team_id_12 = $team_array[11]['championship_team_id'];
        $team_id_13 = $team_array[12]['championship_team_id'];
        $team_id_14 = $team_array[13]['championship_team_id'];
        $team_id_15 = $team_array[14]['championship_team_id'];
        $team_id_16 = $team_array[15]['championship_team_id'];

        $sql = "INSERT INTO `game` (`game_home_team_id`, `game_guest_team_id`, `game_shedule_id`)
                VALUES ('$team_id_02', '$team_id_01', '$shedule_id_01'),
                       ('$team_id_03', '$team_id_15', '$shedule_id_01'),
                       ('$team_id_04', '$team_id_14', '$shedule_id_01'),
                       ('$team_id_05', '$team_id_13', '$shedule_id_01'),
                       ('$team_id_06', '$team_id_12', '$shedule_id_01'),
                       ('$team_id_07', '$team_id_11', '$shedule_id_01'),
                       ('$team_id_08', '$team_id_10', '$shedule_id_01'),
                       ('$team_id_16', '$team_id_09', '$shedule_id_01'),
                       ('$team_id_01', '$team_id_03', '$shedule_id_02'),
                       ('$team_id_02', '$team_id_16', '$shedule_id_02'),
                       ('$team_id_10', '$team_id_09', '$shedule_id_02'),
                       ('$team_id_11', '$team_id_08', '$shedule_id_02'),
                       ('$team_id_12', '$team_id_07', '$shedule_id_02'),
                       ('$team_id_13', '$team_id_06', '$shedule_id_02'),
                       ('$team_id_14', '$team_id_05', '$shedule_id_02'),
                       ('$team_id_15', '$team_id_04', '$shedule_id_02'),
                       ('$team_id_03', '$team_id_02', '$shedule_id_03'),
                       ('$team_id_04', '$team_id_01', '$shedule_id_03'),
                       ('$team_id_05', '$team_id_15', '$shedule_id_03'),
                       ('$team_id_06', '$team_id_14', '$shedule_id_03'),
                       ('$team_id_07', '$team_id_13', '$shedule_id_03'),
                       ('$team_id_08', '$team_id_12', '$shedule_id_03'),
                       ('$team_id_09', '$team_id_11', '$shedule_id_03'),
                       ('$team_id_16', '$team_id_10', '$shedule_id_03'),
                       ('$team_id_01', '$team_id_05', '$shedule_id_04'),
                       ('$team_id_02', '$team_id_04', '$shedule_id_04'),
                       ('$team_id_03', '$team_id_16', '$shedule_id_04'),
                       ('$team_id_11', '$team_id_10', '$shedule_id_04'),
                       ('$team_id_12', '$team_id_09', '$shedule_id_04'),
                       ('$team_id_13', '$team_id_08', '$shedule_id_04'),
                       ('$team_id_14', '$team_id_07', '$shedule_id_04'),
                       ('$team_id_15', '$team_id_06', '$shedule_id_04'),
                       ('$team_id_04', '$team_id_03', '$shedule_id_05'),
                       ('$team_id_05', '$team_id_02', '$shedule_id_05'),
                       ('$team_id_06', '$team_id_01', '$shedule_id_05'),
                       ('$team_id_07', '$team_id_15', '$shedule_id_05'),
                       ('$team_id_08', '$team_id_14', '$shedule_id_05'),
                       ('$team_id_09', '$team_id_13', '$shedule_id_05'),
                       ('$team_id_10', '$team_id_12', '$shedule_id_05'),
                       ('$team_id_16', '$team_id_11', '$shedule_id_05'),
                       ('$team_id_01', '$team_id_07', '$shedule_id_06'),
                       ('$team_id_02', '$team_id_06', '$shedule_id_06'),
                       ('$team_id_03', '$team_id_05', '$shedule_id_06'),
                       ('$team_id_04', '$team_id_16', '$shedule_id_06'),
                       ('$team_id_12', '$team_id_11', '$shedule_id_06'),
                       ('$team_id_13', '$team_id_10', '$shedule_id_06'),
                       ('$team_id_14', '$team_id_09', '$shedule_id_06'),
                       ('$team_id_15', '$team_id_08', '$shedule_id_06'),
                       ('$team_id_05', '$team_id_04', '$shedule_id_07'),
                       ('$team_id_06', '$team_id_03', '$shedule_id_07'),
                       ('$team_id_07', '$team_id_02', '$shedule_id_07'),
                       ('$team_id_08', '$team_id_01', '$shedule_id_07'),
                       ('$team_id_09', '$team_id_15', '$shedule_id_07'),
                       ('$team_id_10', '$team_id_14', '$shedule_id_07'),
                       ('$team_id_11', '$team_id_13', '$shedule_id_07'),
                       ('$team_id_16', '$team_id_12', '$shedule_id_07'),
                       ('$team_id_01', '$team_id_09', '$shedule_id_08'),
                       ('$team_id_02', '$team_id_08', '$shedule_id_08'),
                       ('$team_id_03', '$team_id_07', '$shedule_id_08'),
                       ('$team_id_04', '$team_id_06', '$shedule_id_08'),
                       ('$team_id_05', '$team_id_16', '$shedule_id_08'),
                       ('$team_id_13', '$team_id_12', '$shedule_id_08'),
                       ('$team_id_14', '$team_id_11', '$shedule_id_08'),
                       ('$team_id_15', '$team_id_10', '$shedule_id_08'),
                       ('$team_id_06', '$team_id_05', '$shedule_id_09'),
                       ('$team_id_07', '$team_id_04', '$shedule_id_09'),
                       ('$team_id_08', '$team_id_03', '$shedule_id_09'),
                       ('$team_id_09', '$team_id_02', '$shedule_id_09'),
                       ('$team_id_10', '$team_id_01', '$shedule_id_09'),
                       ('$team_id_11', '$team_id_15', '$shedule_id_09'),
                       ('$team_id_12', '$team_id_14', '$shedule_id_09'),
                       ('$team_id_16', '$team_id_13', '$shedule_id_09'),
                       ('$team_id_01', '$team_id_11', '$shedule_id_10'),
                       ('$team_id_02', '$team_id_10', '$shedule_id_10'),
                       ('$team_id_03', '$team_id_09', '$shedule_id_10'),
                       ('$team_id_04', '$team_id_08', '$shedule_id_10'),
                       ('$team_id_05', '$team_id_07', '$shedule_id_10'),
                       ('$team_id_06', '$team_id_16', '$shedule_id_10'),
                       ('$team_id_14', '$team_id_13', '$shedule_id_10'),
                       ('$team_id_15', '$team_id_12', '$shedule_id_10'),
                       ('$team_id_07', '$team_id_06', '$shedule_id_11'),
                       ('$team_id_08', '$team_id_05', '$shedule_id_11'),
                       ('$team_id_09', '$team_id_04', '$shedule_id_11'),
                       ('$team_id_10', '$team_id_03', '$shedule_id_11'),
                       ('$team_id_11', '$team_id_02', '$shedule_id_11'),
                       ('$team_id_12', '$team_id_01', '$shedule_id_11'),
                       ('$team_id_13', '$team_id_15', '$shedule_id_11'),
                       ('$team_id_16', '$team_id_14', '$shedule_id_11'),
                       ('$team_id_01', '$team_id_13', '$shedule_id_12'),
                       ('$team_id_02', '$team_id_12', '$shedule_id_12'),
                       ('$team_id_03', '$team_id_11', '$shedule_id_12'),
                       ('$team_id_04', '$team_id_10', '$shedule_id_12'),
                       ('$team_id_05', '$team_id_09', '$shedule_id_12'),
                       ('$team_id_06', '$team_id_08', '$shedule_id_12'),
                       ('$team_id_07', '$team_id_16', '$shedule_id_12'),
                       ('$team_id_15', '$team_id_14', '$shedule_id_12'),
                       ('$team_id_08', '$team_id_07', '$shedule_id_13'),
                       ('$team_id_09', '$team_id_06', '$shedule_id_13'),
                       ('$team_id_10', '$team_id_05', '$shedule_id_13'),
                       ('$team_id_11', '$team_id_04', '$shedule_id_13'),
                       ('$team_id_12', '$team_id_03', '$shedule_id_13'),
                       ('$team_id_13', '$team_id_02', '$shedule_id_13'),
                       ('$team_id_14', '$team_id_01', '$shedule_id_13'),
                       ('$team_id_16', '$team_id_15', '$shedule_id_13'),
                       ('$team_id_01', '$team_id_15', '$shedule_id_14'),
                       ('$team_id_02', '$team_id_14', '$shedule_id_14'),
                       ('$team_id_03', '$team_id_13', '$shedule_id_14'),
                       ('$team_id_04', '$team_id_12', '$shedule_id_14'),
                       ('$team_id_05', '$team_id_11', '$shedule_id_14'),
                       ('$team_id_06', '$team_id_10', '$shedule_id_14'),
                       ('$team_id_07', '$team_id_09', '$shedule_id_14'),
                       ('$team_id_16', '$team_id_08', '$shedule_id_14'),
                       ('$team_id_09', '$team_id_08', '$shedule_id_15'),
                       ('$team_id_10', '$team_id_07', '$shedule_id_15'),
                       ('$team_id_11', '$team_id_06', '$shedule_id_15'),
                       ('$team_id_12', '$team_id_05', '$shedule_id_15'),
                       ('$team_id_13', '$team_id_04', '$shedule_id_15'),
                       ('$team_id_14', '$team_id_03', '$shedule_id_15'),
                       ('$team_id_15', '$team_id_02', '$shedule_id_15'),
                       ('$team_id_16', '$team_id_01', '$shedule_id_15'),
                       ('$team_id_01', '$team_id_02', '$shedule_id_16'),
                       ('$team_id_15', '$team_id_03', '$shedule_id_16'),
                       ('$team_id_14', '$team_id_04', '$shedule_id_16'),
                       ('$team_id_13', '$team_id_05', '$shedule_id_16'),
                       ('$team_id_12', '$team_id_06', '$shedule_id_16'),
                       ('$team_id_11', '$team_id_07', '$shedule_id_16'),
                       ('$team_id_10', '$team_id_08', '$shedule_id_16'),
                       ('$team_id_09', '$team_id_16', '$shedule_id_16'),
                       ('$team_id_03', '$team_id_01', '$shedule_id_17'),
                       ('$team_id_16', '$team_id_02', '$shedule_id_17'),
                       ('$team_id_09', '$team_id_10', '$shedule_id_17'),
                       ('$team_id_08', '$team_id_11', '$shedule_id_17'),
                       ('$team_id_07', '$team_id_12', '$shedule_id_17'),
                       ('$team_id_06', '$team_id_13', '$shedule_id_17'),
                       ('$team_id_05', '$team_id_14', '$shedule_id_17'),
                       ('$team_id_04', '$team_id_15', '$shedule_id_17'),
                       ('$team_id_02', '$team_id_03', '$shedule_id_18'),
                       ('$team_id_01', '$team_id_04', '$shedule_id_18'),
                       ('$team_id_15', '$team_id_05', '$shedule_id_18'),
                       ('$team_id_14', '$team_id_06', '$shedule_id_18'),
                       ('$team_id_13', '$team_id_07', '$shedule_id_18'),
                       ('$team_id_12', '$team_id_08', '$shedule_id_18'),
                       ('$team_id_11', '$team_id_09', '$shedule_id_18'),
                       ('$team_id_10', '$team_id_16', '$shedule_id_18'),
                       ('$team_id_05', '$team_id_01', '$shedule_id_19'),
                       ('$team_id_04', '$team_id_02', '$shedule_id_19'),
                       ('$team_id_16', '$team_id_03', '$shedule_id_19'),
                       ('$team_id_10', '$team_id_11', '$shedule_id_19'),
                       ('$team_id_09', '$team_id_12', '$shedule_id_19'),
                       ('$team_id_08', '$team_id_13', '$shedule_id_19'),
                       ('$team_id_07', '$team_id_14', '$shedule_id_19'),
                       ('$team_id_06', '$team_id_15', '$shedule_id_19'),
                       ('$team_id_03', '$team_id_04', '$shedule_id_20'),
                       ('$team_id_02', '$team_id_05', '$shedule_id_20'),
                       ('$team_id_01', '$team_id_06', '$shedule_id_20'),
                       ('$team_id_15', '$team_id_07', '$shedule_id_20'),
                       ('$team_id_14', '$team_id_08', '$shedule_id_20'),
                       ('$team_id_13', '$team_id_09', '$shedule_id_20'),
                       ('$team_id_12', '$team_id_10', '$shedule_id_20'),
                       ('$team_id_11', '$team_id_16', '$shedule_id_20'),
                       ('$team_id_07', '$team_id_01', '$shedule_id_21'),
                       ('$team_id_06', '$team_id_02', '$shedule_id_21'),
                       ('$team_id_05', '$team_id_03', '$shedule_id_21'),
                       ('$team_id_16', '$team_id_04', '$shedule_id_21'),
                       ('$team_id_11', '$team_id_12', '$shedule_id_21'),
                       ('$team_id_10', '$team_id_13', '$shedule_id_21'),
                       ('$team_id_09', '$team_id_14', '$shedule_id_21'),
                       ('$team_id_08', '$team_id_15', '$shedule_id_21'),
                       ('$team_id_04', '$team_id_05', '$shedule_id_22'),
                       ('$team_id_03', '$team_id_06', '$shedule_id_22'),
                       ('$team_id_02', '$team_id_07', '$shedule_id_22'),
                       ('$team_id_01', '$team_id_08', '$shedule_id_22'),
                       ('$team_id_15', '$team_id_09', '$shedule_id_22'),
                       ('$team_id_14', '$team_id_10', '$shedule_id_22'),
                       ('$team_id_13', '$team_id_11', '$shedule_id_22'),
                       ('$team_id_12', '$team_id_16', '$shedule_id_22'),
                       ('$team_id_09', '$team_id_01', '$shedule_id_23'),
                       ('$team_id_08', '$team_id_02', '$shedule_id_23'),
                       ('$team_id_07', '$team_id_03', '$shedule_id_23'),
                       ('$team_id_06', '$team_id_04', '$shedule_id_23'),
                       ('$team_id_16', '$team_id_05', '$shedule_id_23'),
                       ('$team_id_12', '$team_id_13', '$shedule_id_23'),
                       ('$team_id_11', '$team_id_14', '$shedule_id_23'),
                       ('$team_id_10', '$team_id_15', '$shedule_id_23'),
                       ('$team_id_05', '$team_id_06', '$shedule_id_24'),
                       ('$team_id_04', '$team_id_07', '$shedule_id_24'),
                       ('$team_id_03', '$team_id_08', '$shedule_id_24'),
                       ('$team_id_02', '$team_id_09', '$shedule_id_24'),
                       ('$team_id_01', '$team_id_10', '$shedule_id_24'),
                       ('$team_id_15', '$team_id_11', '$shedule_id_24'),
                       ('$team_id_14', '$team_id_12', '$shedule_id_24'),
                       ('$team_id_13', '$team_id_16', '$shedule_id_24'),
                       ('$team_id_11', '$team_id_01', '$shedule_id_25'),
                       ('$team_id_10', '$team_id_02', '$shedule_id_25'),
                       ('$team_id_09', '$team_id_03', '$shedule_id_25'),
                       ('$team_id_08', '$team_id_04', '$shedule_id_25'),
                       ('$team_id_07', '$team_id_05', '$shedule_id_25'),
                       ('$team_id_16', '$team_id_06', '$shedule_id_25'),
                       ('$team_id_13', '$team_id_14', '$shedule_id_25'),
                       ('$team_id_12', '$team_id_15', '$shedule_id_25'),
                       ('$team_id_06', '$team_id_07', '$shedule_id_26'),
                       ('$team_id_05', '$team_id_08', '$shedule_id_26'),
                       ('$team_id_04', '$team_id_09', '$shedule_id_26'),
                       ('$team_id_03', '$team_id_10', '$shedule_id_26'),
                       ('$team_id_02', '$team_id_11', '$shedule_id_26'),
                       ('$team_id_01', '$team_id_12', '$shedule_id_26'),
                       ('$team_id_15', '$team_id_13', '$shedule_id_26'),
                       ('$team_id_14', '$team_id_16', '$shedule_id_26'),
                       ('$team_id_13', '$team_id_01', '$shedule_id_27'),
                       ('$team_id_12', '$team_id_02', '$shedule_id_27'),
                       ('$team_id_11', '$team_id_03', '$shedule_id_27'),
                       ('$team_id_10', '$team_id_04', '$shedule_id_27'),
                       ('$team_id_09', '$team_id_05', '$shedule_id_27'),
                       ('$team_id_08', '$team_id_06', '$shedule_id_27'),
                       ('$team_id_16', '$team_id_07', '$shedule_id_27'),
                       ('$team_id_14', '$team_id_15', '$shedule_id_27'),
                       ('$team_id_07', '$team_id_08', '$shedule_id_28'),
                       ('$team_id_06', '$team_id_09', '$shedule_id_28'),
                       ('$team_id_05', '$team_id_10', '$shedule_id_28'),
                       ('$team_id_04', '$team_id_11', '$shedule_id_28'),
                       ('$team_id_03', '$team_id_12', '$shedule_id_28'),
                       ('$team_id_02', '$team_id_13', '$shedule_id_28'),
                       ('$team_id_01', '$team_id_14', '$shedule_id_28'),
                       ('$team_id_15', '$team_id_16', '$shedule_id_28'),
                       ('$team_id_15', '$team_id_01', '$shedule_id_29'),
                       ('$team_id_14', '$team_id_02', '$shedule_id_29'),
                       ('$team_id_13', '$team_id_03', '$shedule_id_29'),
                       ('$team_id_12', '$team_id_04', '$shedule_id_29'),
                       ('$team_id_11', '$team_id_05', '$shedule_id_29'),
                       ('$team_id_10', '$team_id_06', '$shedule_id_29'),
                       ('$team_id_09', '$team_id_07', '$shedule_id_29'),
                       ('$team_id_08', '$team_id_16', '$shedule_id_29'),
                       ('$team_id_08', '$team_id_09', '$shedule_id_30'),
                       ('$team_id_07', '$team_id_10', '$shedule_id_30'),
                       ('$team_id_06', '$team_id_11', '$shedule_id_30'),
                       ('$team_id_05', '$team_id_12', '$shedule_id_30'),
                       ('$team_id_04', '$team_id_13', '$shedule_id_30'),
                       ('$team_id_03', '$team_id_14', '$shedule_id_30'),
                       ('$team_id_02', '$team_id_15', '$shedule_id_30'),
                       ('$team_id_01', '$team_id_16', '$shedule_id_30');";
            igosja_db_query($sql);
    }
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
    $team_1_id      = $team_array[$i]['conference_team_id'];
    $team_2_id      = $team_array[$i+1]['conference_team_id'];
    $game_array[]   = "('$team_1_id', '$team_2_id', '$shedule_id')";
}

$game_array = implode(', ', $game_array);

$sql = "INSERT INTO `game` (`game_guest_team_id`, `game_home_team_id`, `game_shedule_id`)
        VALUES $game_array;";
igosja_db_query($sql);
//Конец формирования таблицы и матчей конференции

redirect('/admin/index.php');