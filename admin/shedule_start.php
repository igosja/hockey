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
        HAVING COUNT(`team_id`)>='16'
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

2	1
3	15
4	14
5	13
6	12
7	11
8	10
16	9
1	3
2	16
10	9
11	8
12	7
13	6
14	5
15	4
3	2
4	1
5	15
6	14
7	13
8	12
9	11
16	10
1	5
2	4
3	16
11	10
12	9
13	8
14	7
15	6
4	3
5	2
6	1
7	15
8	14
9	13
10	12
16	11
1	7
2	6
3	5
4	16
12	11
13	10
14	9
15	8
5	4
6	3
7	2
8	1
9	15
10	14
11	13
16	12
1	9
2	8
3	7
4	6
5	16
13	12
14	11
15	10
6	5
7	4
8	3
9	2
10	1
11	15
12	14
16	13
1	11
2	10
3	9
4	8
5	7
6	16
14	13
15	12
7	6
8	5
9	4
10	3
11	2
12	1
13	15
16	14
1	13
2	12
3	11
4	10
5	9
6	8
7	16
15	14
8	7
9	6
10	5
11	4
12	3
13	2
14	1
16	15
1	15
2	14
3	13
4	12
5	11
6	10
7	9
16	8
9	8
10	7
11	6
12	5
13	4
14	3
15	2
16	1
1	2
15	3
14	4
13	5
12	6
11	7
10	8
9	16
3	1
16	2
9	10
8	11
7	12
6	13
5	14
4	15
2	3
1	4
15	5
14	6
13	7
12	8
11	9
10	16
5	1
4	2
16	3
10	11
9	12
8	13
7	14
6	15
3	4
2	5
1	6
15	7
14	8
13	9
12	10
11	16
7	1
6	2
5	3
16	4
11	12
10	13
9	14
8	15
4	5
3	6
2	7
1	8
15	9
14	10
13	11
12	16
9	1
8	2
7	3
6	4
16	5
12	13
11	14
10	15
5	6
4	7
3	8
2	9
1	10
15	11
14	12
13	16
11	1
10	2
9	3
8	4
7	5
16	6
13	14
12	15
6	7
5	8
4	9
3	10
2	11
1	12
15	13
14	16
13	1
12	2
11	3
10	4
9	5
8	6
16	7
14	15
7	8
6	9
5	10
4	11
3	12
2	13
1	14
15	16
15	1
14	2
13	3
12	4
11	5
10	6
9	7
8	16
8	9
7	10
6	11
5	12
4	13
3	14
2	15
1	16

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