<?php

set_time_limit(0);

include (__DIR__ . '/../include/include.php');

$sql = "INSERT INTO `user`
        SET `user_code`='f296a47aebb6b66620d44652a59db37a',
            `user_date_confirm`='0',
            `user_date_login`=UNIX_TIMESTAMP(),
            `user_date_register`=UNIX_TIMESTAMP(),
            `user_email`='fanat16rus@yandex.ru',
            `user_login`='Fanat16Rus',
            `user_password`='42f807e146b7db018c9560ea179535b6'";
f_igosja_mysqli_query($sql);

$sql = "INSERT INTO `user`
        SET `user_code`='883a889016dafef5c1c17d4227988ae1',
            `user_date_confirm`='0',
            `user_date_login`=UNIX_TIMESTAMP(),
            `user_date_register`=UNIX_TIMESTAMP(),
            `user_email`='pavel87desant38@gmail.com',
            `user_login`='Fanfar',
            `user_password`='6cee822c8723d6ff4c6470fbf66ed096'";
f_igosja_mysqli_query($sql);

$team_array = array(
//    array('team_name' => 'Адмирал', 'team_stadium_id' => 8),
//    array('team_name' => 'Автомобилист', 'team_stadium_id' => 15),
//    array('team_name' => 'Ак Барс', 'team_stadium_id' => 16),
//    array('team_name' => 'Металлург', 'team_stadium_id' => 20),
//    array('team_name' => 'Динамо', 'team_stadium_id' => 22),
//    array('team_name' => 'Спартак', 'team_stadium_id' => 24),
//    array('team_name' => 'ЦСКА', 'team_stadium_id' => 25),
//    array('team_name' => 'Нефтехимик', 'team_stadium_id' => 28),
//    array('team_name' => 'Торпедо', 'team_stadium_id' => 29),
//    array('team_name' => 'Сибирь', 'team_stadium_id' => 31),
//    array('team_name' => 'Авангард', 'team_stadium_id' => 36),
//    array('team_name' => 'СКА', 'team_stadium_id' => 43),
//    array('team_name' => 'Сочи', 'team_stadium_id' => 49),
//    array('team_name' => 'Салават Юлаев', 'team_stadium_id' => 54),
//    array('team_name' => 'Трактор', 'team_stadium_id' => 58),
//    array('team_name' => 'Локомотив', 'team_stadium_id' => 64),
//    array('team_name' => 'Анахайм Дакс', 'team_stadium_id' => 2),
//    array('team_name' => 'Бостон Брюинз', 'team_stadium_id' => 5),
//    array('team_name' => 'Вашингтон Кэпиталз', 'team_stadium_id' => 7),
//    array('team_name' => 'Даллас Старз', 'team_stadium_id' => 11),
//    array('team_name' => 'Детройт Ред Уингз', 'team_stadium_id' => 14),
//    array('team_name' => 'Лос-Анджелес Кингз', 'team_stadium_id' => 19),
//    array('team_name' => 'Нью-Йорк Айлендерс', 'team_stadium_id' => 32),
//    array('team_name' => 'Нью-Йорк Рейнджерс', 'team_stadium_id' => 33),
//    array('team_name' => 'Нэшвилл Предаторз', 'team_stadium_id' => 35),
//    array('team_name' => 'Питтсбург Пингвинз', 'team_stadium_id' => 38),
//    array('team_name' => 'Сан-Хосе Шаркс', 'team_stadium_id' => 42),
//    array('team_name' => 'Флорида Пантерз', 'team_stadium_id' => 44),
//    array('team_name' => 'Сент-Луис Блюз', 'team_stadium_id' => 47),
//    array('team_name' => 'Тампа-Бэй Лайтнинг', 'team_stadium_id' => 51),
//    array('team_name' => 'Филадельфия Флайерз', 'team_stadium_id' => 55),
//    array('team_name' => 'Чикаго Блэкхокс', 'team_stadium_id' => 61),
//    array('team_name' => 'Нефтяник', 'team_stadium_id' => 1),
//    array('team_name' => 'МВД', 'team_stadium_id' => 3),
//    array('team_name' => 'Крылья Советов', 'team_stadium_id' => 23),
//    array('team_name' => 'Атлант', 'team_stadium_id' => 26),
//    array('team_name' => 'Торос', 'team_stadium_id' => 27),
//    array('team_name' => 'Металлург', 'team_stadium_id' => 30),
//    array('team_name' => 'Дизель', 'team_stadium_id' => 37),
//    array('team_name' => 'Витязь', 'team_stadium_id' => 39),
//    array('team_name' => 'Кристалл', 'team_stadium_id' => 45),
//    array('team_name' => 'Лада', 'team_stadium_id' => 52),
//    array('team_name' => 'Рубин', 'team_stadium_id' => 53),
//    array('team_name' => 'Амур', 'team_stadium_id' => 56),
//    array('team_name' => 'Югра', 'team_stadium_id' => 57),
//    array('team_name' => 'Челмет', 'team_stadium_id' => 59),
//    array('team_name' => 'Северсталь', 'team_stadium_id' => 60),
//    array('team_name' => 'Кристалл', 'team_stadium_id' => 63),
//    array('team_name' => 'Бейкерсфилд Кондорс', 'team_stadium_id' => 4),
//    array('team_name' => 'Баффало Сейбрз', 'team_stadium_id' => 6),
//    array('team_name' => 'Аризона Койотс', 'team_stadium_id' => 9),
//    array('team_name' => 'Гранд-Рапидс Гриффинс', 'team_stadium_id' => 10),
//    array('team_name' => 'Айова Уайлд', 'team_stadium_id' => 12),
//    array('team_name' => 'Колорадо Эвеланш', 'team_stadium_id' => 13),
//    array('team_name' => 'Лейк Эри Монстерз', 'team_stadium_id' => 17),
//    array('team_name' => 'Коламбус Блу Джекетс', 'team_stadium_id' => 18),
//    array('team_name' => 'Милуоки Эдмиралс', 'team_stadium_id' => 21),
//    array('team_name' => 'Нью-Джерси Девилз', 'team_stadium_id' => 34),
//    array('team_name' => 'Рокфорд Айсхогс', 'team_stadium_id' => 40),
//    array('team_name' => 'Каролина Харрикейнз', 'team_stadium_id' => 41),
//    array('team_name' => 'Техас Старз', 'team_stadium_id' => 46),
//    array('team_name' => 'Миннесота Уайлд', 'team_stadium_id' => 48),
//    array('team_name' => 'Стоктон Хит', 'team_stadium_id' => 50),
//    array('team_name' => 'Чикаго Вулвз', 'team_stadium_id' => 62),
    array('team_name' => 'Монреаль Канадиенс', 'team_stadium_id' => 65),
    array('team_name' => 'Оттава Сенаторз', 'team_stadium_id' => 66),
    array('team_name' => 'Торонто Мейпл Лифс', 'team_stadium_id' => 67),
    array('team_name' => 'Ванкувер Кэнакс', 'team_stadium_id' => 68),
    array('team_name' => 'Калгари Флэймз', 'team_stadium_id' => 69),
    array('team_name' => 'Эдмонтон Ойлерз', 'team_stadium_id' => 70),
);

foreach ($team_array as $team)
{
    $team_name          = $team['team_name'];
    $team_stadium_id    = $team['team_stadium_id'];

    $sql = "INSERT INTO `team`
            SET `team_name`='$team_name',
                `team_stadium_id`='$team_stadium_id'";
    f_igosja_mysqli_query($sql);

    $num_get = $mysqli->insert_id;

    $log = array(
        'log_logtext_id' => LOGTEXT_TEAM_REGISTER,
        'log_team_id' => $num_get
    );
    f_igosja_log($log);
    f_igosja_create_team_players($num_get);

    usleep(1);

    print '.';
    flush();
}

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
$start_date = time();

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
    }

    $shedule_insert_array[] = "('$date', '1', '$shedule_stage_array[$i]', '$tournament_type')";

    if ($conference)
    {
        $tournament_type_c  = TOURNAMENTTYPE_CONFERENCE;
        $shedule_insert_array[] = "('$date', '1', '$shedule_conference_stage_array[$i]', '$tournament_type_c')";
    }
}

$shedule_insert_array = implode(',', $shedule_insert_array);

$sql = "INSERT INTO `shedule` (`shedule_date`, `shedule_season_id`, `shedule_stage_id`, `shedule_tournamenttype_id`)
        VALUES $shedule_insert_array;";
f_igosja_mysqli_query($sql);
//Конец формирования календаря

//Начало формирования таблицы и матчей кубка межсезонья
$game_array = array();

$sql = "INSERT INTO `offseason` (`offseason_season_id`, `offseason_team_id`)
        SELECT '$igosja_season_id', `team_id`
        FROM `team`
        WHERE `team_id`!='0'
        ORDER BY `team_id` ASC";
f_igosja_mysqli_query($sql);

$sql = "SELECT `shedule_id`
        FROM `shedule`
        WHERE `shedule_tournamenttype_id`='" . TOURNAMENTTYPE_OFFSEASON . "'
        AND `shedule_stage_id`='" . STAGE_1_TOUR . "'
        AND `shedule_season_id`='$igosja_season_id'
        LIMIT 1";
$shedule_sql = f_igosja_mysqli_query($sql);

$shedule_array = $shedule_sql->fetch_all(1);

$shedule_id = $shedule_array[0]['shedule_id'];

$sql = "SELECT `offseason_team_id`,
               `stadium_id`
        FROM `offseason`
        LEFT JOIN `team`
        ON `offseason_team_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        WHERE `offseason_season_id`='$igosja_season_id'
        ORDER BY RAND()";
$team_sql = f_igosja_mysqli_query($sql);

$count_team = $team_sql->num_rows;
$team_array = $team_sql->fetch_all(1);

for ($i=0; $i<$count_team; $i=$i+2)
{
    $team_1_id      = $team_array[$i]['offseason_team_id'];
    $team_2_id      = $team_array[$i+1]['offseason_team_id'];
    $stadium_id     = $team_array[$i]['stadium_id'];
    $game_array[]   = "('$team_1_id', '$team_2_id', '$shedule_id', '$stadium_id')";
}

$game_array = implode(', ', $game_array);

$sql = "INSERT INTO `game` (`game_guest_team_id`, `game_home_team_id`, `game_shedule_id`, `game_stadium_id`)
        VALUES $game_array;";
f_igosja_mysqli_query($sql);
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
$country_sql = f_igosja_mysqli_query($sql);

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
    f_igosja_mysqli_query($sql);

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
    f_igosja_mysqli_query($sql);
}

$sql = "SELECT `shedule_id`
        FROM `shedule`
        WHERE `shedule_season_id`='$igosja_season_id'
        AND `shedule_tournamenttype_id`='" . TOURNAMENTTYPE_CHAMPIONSHIP . "'
        ORDER BY `shedule_id` ASC
        LIMIT 30";
$shedule_sql = f_igosja_mysqli_query($sql);

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
        $sql = "SELECT `championship_team_id`,
                       `stadium_id`
                FROM `championship`
                LEFT JOIN `team`
                ON `championship_team_id`=`team_id`
                LEFT JOIN `stadium`
                ON `team_stadium_id`=`stadium_id`
                WHERE `championship_country_id`='$item'
                AND `championship_division_id`='$i'
                AND `championship_season_id`='$igosja_season_id'
                ORDER BY RAND()";
        $team_sql = f_igosja_mysqli_query($sql);

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

        $stadium_id_01 = $team_array[0]['stadium_id'];
        $stadium_id_02 = $team_array[1]['stadium_id'];
        $stadium_id_03 = $team_array[2]['stadium_id'];
        $stadium_id_04 = $team_array[3]['stadium_id'];
        $stadium_id_05 = $team_array[4]['stadium_id'];
        $stadium_id_06 = $team_array[5]['stadium_id'];
        $stadium_id_07 = $team_array[6]['stadium_id'];
        $stadium_id_08 = $team_array[7]['stadium_id'];
        $stadium_id_09 = $team_array[8]['stadium_id'];
        $stadium_id_10 = $team_array[9]['stadium_id'];
        $stadium_id_11 = $team_array[10]['stadium_id'];
        $stadium_id_12 = $team_array[11]['stadium_id'];
        $stadium_id_13 = $team_array[12]['stadium_id'];
        $stadium_id_14 = $team_array[13]['stadium_id'];
        $stadium_id_15 = $team_array[14]['stadium_id'];
        $stadium_id_16 = $team_array[15]['stadium_id'];

        $sql = "INSERT INTO `game` (`game_home_team_id`, `game_guest_team_id`, `game_shedule_id`, `game_stadium_id`)
                VALUES ('$team_id_02', '$team_id_01', '$shedule_id_01', '$stadium_id_02'),
                       ('$team_id_03', '$team_id_15', '$shedule_id_01', '$stadium_id_03'),
                       ('$team_id_04', '$team_id_14', '$shedule_id_01', '$stadium_id_04'),
                       ('$team_id_05', '$team_id_13', '$shedule_id_01', '$stadium_id_05'),
                       ('$team_id_06', '$team_id_12', '$shedule_id_01', '$stadium_id_06'),
                       ('$team_id_07', '$team_id_11', '$shedule_id_01', '$stadium_id_07'),
                       ('$team_id_08', '$team_id_10', '$shedule_id_01', '$stadium_id_08'),
                       ('$team_id_16', '$team_id_09', '$shedule_id_01', '$stadium_id_16'),
                       ('$team_id_01', '$team_id_03', '$shedule_id_02', '$stadium_id_01'),
                       ('$team_id_02', '$team_id_16', '$shedule_id_02', '$stadium_id_02'),
                       ('$team_id_10', '$team_id_09', '$shedule_id_02', '$stadium_id_10'),
                       ('$team_id_11', '$team_id_08', '$shedule_id_02', '$stadium_id_11'),
                       ('$team_id_12', '$team_id_07', '$shedule_id_02', '$stadium_id_12'),
                       ('$team_id_13', '$team_id_06', '$shedule_id_02', '$stadium_id_13'),
                       ('$team_id_14', '$team_id_05', '$shedule_id_02', '$stadium_id_14'),
                       ('$team_id_15', '$team_id_04', '$shedule_id_02', '$stadium_id_15'),
                       ('$team_id_03', '$team_id_02', '$shedule_id_03', '$stadium_id_03'),
                       ('$team_id_04', '$team_id_01', '$shedule_id_03', '$stadium_id_04'),
                       ('$team_id_05', '$team_id_15', '$shedule_id_03', '$stadium_id_05'),
                       ('$team_id_06', '$team_id_14', '$shedule_id_03', '$stadium_id_06'),
                       ('$team_id_07', '$team_id_13', '$shedule_id_03', '$stadium_id_07'),
                       ('$team_id_08', '$team_id_12', '$shedule_id_03', '$stadium_id_08'),
                       ('$team_id_09', '$team_id_11', '$shedule_id_03', '$stadium_id_09'),
                       ('$team_id_16', '$team_id_10', '$shedule_id_03', '$stadium_id_16'),
                       ('$team_id_01', '$team_id_05', '$shedule_id_04', '$stadium_id_01'),
                       ('$team_id_02', '$team_id_04', '$shedule_id_04', '$stadium_id_02'),
                       ('$team_id_03', '$team_id_16', '$shedule_id_04', '$stadium_id_03'),
                       ('$team_id_11', '$team_id_10', '$shedule_id_04', '$stadium_id_11'),
                       ('$team_id_12', '$team_id_09', '$shedule_id_04', '$stadium_id_12'),
                       ('$team_id_13', '$team_id_08', '$shedule_id_04', '$stadium_id_13'),
                       ('$team_id_14', '$team_id_07', '$shedule_id_04', '$stadium_id_14'),
                       ('$team_id_15', '$team_id_06', '$shedule_id_04', '$stadium_id_15'),
                       ('$team_id_04', '$team_id_03', '$shedule_id_05', '$stadium_id_04'),
                       ('$team_id_05', '$team_id_02', '$shedule_id_05', '$stadium_id_05'),
                       ('$team_id_06', '$team_id_01', '$shedule_id_05', '$stadium_id_06'),
                       ('$team_id_07', '$team_id_15', '$shedule_id_05', '$stadium_id_07'),
                       ('$team_id_08', '$team_id_14', '$shedule_id_05', '$stadium_id_08'),
                       ('$team_id_09', '$team_id_13', '$shedule_id_05', '$stadium_id_09'),
                       ('$team_id_10', '$team_id_12', '$shedule_id_05', '$stadium_id_10'),
                       ('$team_id_16', '$team_id_11', '$shedule_id_05', '$stadium_id_16'),
                       ('$team_id_01', '$team_id_07', '$shedule_id_06', '$stadium_id_01'),
                       ('$team_id_02', '$team_id_06', '$shedule_id_06', '$stadium_id_02'),
                       ('$team_id_03', '$team_id_05', '$shedule_id_06', '$stadium_id_03'),
                       ('$team_id_04', '$team_id_16', '$shedule_id_06', '$stadium_id_04'),
                       ('$team_id_12', '$team_id_11', '$shedule_id_06', '$stadium_id_12'),
                       ('$team_id_13', '$team_id_10', '$shedule_id_06', '$stadium_id_13'),
                       ('$team_id_14', '$team_id_09', '$shedule_id_06', '$stadium_id_14'),
                       ('$team_id_15', '$team_id_08', '$shedule_id_06', '$stadium_id_15'),
                       ('$team_id_05', '$team_id_04', '$shedule_id_07', '$stadium_id_05'),
                       ('$team_id_06', '$team_id_03', '$shedule_id_07', '$stadium_id_06'),
                       ('$team_id_07', '$team_id_02', '$shedule_id_07', '$stadium_id_07'),
                       ('$team_id_08', '$team_id_01', '$shedule_id_07', '$stadium_id_08'),
                       ('$team_id_09', '$team_id_15', '$shedule_id_07', '$stadium_id_09'),
                       ('$team_id_10', '$team_id_14', '$shedule_id_07', '$stadium_id_10'),
                       ('$team_id_11', '$team_id_13', '$shedule_id_07', '$stadium_id_11'),
                       ('$team_id_16', '$team_id_12', '$shedule_id_07', '$stadium_id_16'),
                       ('$team_id_01', '$team_id_09', '$shedule_id_08', '$stadium_id_01'),
                       ('$team_id_02', '$team_id_08', '$shedule_id_08', '$stadium_id_02'),
                       ('$team_id_03', '$team_id_07', '$shedule_id_08', '$stadium_id_03'),
                       ('$team_id_04', '$team_id_06', '$shedule_id_08', '$stadium_id_04'),
                       ('$team_id_05', '$team_id_16', '$shedule_id_08', '$stadium_id_05'),
                       ('$team_id_13', '$team_id_12', '$shedule_id_08', '$stadium_id_13'),
                       ('$team_id_14', '$team_id_11', '$shedule_id_08', '$stadium_id_14'),
                       ('$team_id_15', '$team_id_10', '$shedule_id_08', '$stadium_id_15'),
                       ('$team_id_06', '$team_id_05', '$shedule_id_09', '$stadium_id_06'),
                       ('$team_id_07', '$team_id_04', '$shedule_id_09', '$stadium_id_07'),
                       ('$team_id_08', '$team_id_03', '$shedule_id_09', '$stadium_id_08'),
                       ('$team_id_09', '$team_id_02', '$shedule_id_09', '$stadium_id_09'),
                       ('$team_id_10', '$team_id_01', '$shedule_id_09', '$stadium_id_10'),
                       ('$team_id_11', '$team_id_15', '$shedule_id_09', '$stadium_id_11'),
                       ('$team_id_12', '$team_id_14', '$shedule_id_09', '$stadium_id_12'),
                       ('$team_id_16', '$team_id_13', '$shedule_id_09', '$stadium_id_16'),
                       ('$team_id_01', '$team_id_11', '$shedule_id_10', '$stadium_id_01'),
                       ('$team_id_02', '$team_id_10', '$shedule_id_10', '$stadium_id_02'),
                       ('$team_id_03', '$team_id_09', '$shedule_id_10', '$stadium_id_03'),
                       ('$team_id_04', '$team_id_08', '$shedule_id_10', '$stadium_id_04'),
                       ('$team_id_05', '$team_id_07', '$shedule_id_10', '$stadium_id_05'),
                       ('$team_id_06', '$team_id_16', '$shedule_id_10', '$stadium_id_06'),
                       ('$team_id_14', '$team_id_13', '$shedule_id_10', '$stadium_id_14'),
                       ('$team_id_15', '$team_id_12', '$shedule_id_10', '$stadium_id_15'),
                       ('$team_id_07', '$team_id_06', '$shedule_id_11', '$stadium_id_07'),
                       ('$team_id_08', '$team_id_05', '$shedule_id_11', '$stadium_id_08'),
                       ('$team_id_09', '$team_id_04', '$shedule_id_11', '$stadium_id_09'),
                       ('$team_id_10', '$team_id_03', '$shedule_id_11', '$stadium_id_10'),
                       ('$team_id_11', '$team_id_02', '$shedule_id_11', '$stadium_id_11'),
                       ('$team_id_12', '$team_id_01', '$shedule_id_11', '$stadium_id_12'),
                       ('$team_id_13', '$team_id_15', '$shedule_id_11', '$stadium_id_13'),
                       ('$team_id_16', '$team_id_14', '$shedule_id_11', '$stadium_id_16'),
                       ('$team_id_01', '$team_id_13', '$shedule_id_12', '$stadium_id_01'),
                       ('$team_id_02', '$team_id_12', '$shedule_id_12', '$stadium_id_02'),
                       ('$team_id_03', '$team_id_11', '$shedule_id_12', '$stadium_id_03'),
                       ('$team_id_04', '$team_id_10', '$shedule_id_12', '$stadium_id_04'),
                       ('$team_id_05', '$team_id_09', '$shedule_id_12', '$stadium_id_05'),
                       ('$team_id_06', '$team_id_08', '$shedule_id_12', '$stadium_id_06'),
                       ('$team_id_07', '$team_id_16', '$shedule_id_12', '$stadium_id_07'),
                       ('$team_id_15', '$team_id_14', '$shedule_id_12', '$stadium_id_15'),
                       ('$team_id_08', '$team_id_07', '$shedule_id_13', '$stadium_id_08'),
                       ('$team_id_09', '$team_id_06', '$shedule_id_13', '$stadium_id_09'),
                       ('$team_id_10', '$team_id_05', '$shedule_id_13', '$stadium_id_10'),
                       ('$team_id_11', '$team_id_04', '$shedule_id_13', '$stadium_id_11'),
                       ('$team_id_12', '$team_id_03', '$shedule_id_13', '$stadium_id_12'),
                       ('$team_id_13', '$team_id_02', '$shedule_id_13', '$stadium_id_13'),
                       ('$team_id_14', '$team_id_01', '$shedule_id_13', '$stadium_id_14'),
                       ('$team_id_16', '$team_id_15', '$shedule_id_13', '$stadium_id_16'),
                       ('$team_id_01', '$team_id_15', '$shedule_id_14', '$stadium_id_01'),
                       ('$team_id_02', '$team_id_14', '$shedule_id_14', '$stadium_id_02'),
                       ('$team_id_03', '$team_id_13', '$shedule_id_14', '$stadium_id_03'),
                       ('$team_id_04', '$team_id_12', '$shedule_id_14', '$stadium_id_04'),
                       ('$team_id_05', '$team_id_11', '$shedule_id_14', '$stadium_id_05'),
                       ('$team_id_06', '$team_id_10', '$shedule_id_14', '$stadium_id_06'),
                       ('$team_id_07', '$team_id_09', '$shedule_id_14', '$stadium_id_07'),
                       ('$team_id_16', '$team_id_08', '$shedule_id_14', '$stadium_id_16'),
                       ('$team_id_09', '$team_id_08', '$shedule_id_15', '$stadium_id_09'),
                       ('$team_id_10', '$team_id_07', '$shedule_id_15', '$stadium_id_10'),
                       ('$team_id_11', '$team_id_06', '$shedule_id_15', '$stadium_id_11'),
                       ('$team_id_12', '$team_id_05', '$shedule_id_15', '$stadium_id_12'),
                       ('$team_id_13', '$team_id_04', '$shedule_id_15', '$stadium_id_13'),
                       ('$team_id_14', '$team_id_03', '$shedule_id_15', '$stadium_id_14'),
                       ('$team_id_15', '$team_id_02', '$shedule_id_15', '$stadium_id_15'),
                       ('$team_id_16', '$team_id_01', '$shedule_id_15', '$stadium_id_16'),
                       ('$team_id_01', '$team_id_02', '$shedule_id_16', '$stadium_id_01'),
                       ('$team_id_15', '$team_id_03', '$shedule_id_16', '$stadium_id_15'),
                       ('$team_id_14', '$team_id_04', '$shedule_id_16', '$stadium_id_14'),
                       ('$team_id_13', '$team_id_05', '$shedule_id_16', '$stadium_id_13'),
                       ('$team_id_12', '$team_id_06', '$shedule_id_16', '$stadium_id_12'),
                       ('$team_id_11', '$team_id_07', '$shedule_id_16', '$stadium_id_11'),
                       ('$team_id_10', '$team_id_08', '$shedule_id_16', '$stadium_id_10'),
                       ('$team_id_09', '$team_id_16', '$shedule_id_16', '$stadium_id_09'),
                       ('$team_id_03', '$team_id_01', '$shedule_id_17', '$stadium_id_03'),
                       ('$team_id_16', '$team_id_02', '$shedule_id_17', '$stadium_id_16'),
                       ('$team_id_09', '$team_id_10', '$shedule_id_17', '$stadium_id_09'),
                       ('$team_id_08', '$team_id_11', '$shedule_id_17', '$stadium_id_08'),
                       ('$team_id_07', '$team_id_12', '$shedule_id_17', '$stadium_id_07'),
                       ('$team_id_06', '$team_id_13', '$shedule_id_17', '$stadium_id_06'),
                       ('$team_id_05', '$team_id_14', '$shedule_id_17', '$stadium_id_05'),
                       ('$team_id_04', '$team_id_15', '$shedule_id_17', '$stadium_id_04'),
                       ('$team_id_02', '$team_id_03', '$shedule_id_18', '$stadium_id_02'),
                       ('$team_id_01', '$team_id_04', '$shedule_id_18', '$stadium_id_01'),
                       ('$team_id_15', '$team_id_05', '$shedule_id_18', '$stadium_id_15'),
                       ('$team_id_14', '$team_id_06', '$shedule_id_18', '$stadium_id_14'),
                       ('$team_id_13', '$team_id_07', '$shedule_id_18', '$stadium_id_13'),
                       ('$team_id_12', '$team_id_08', '$shedule_id_18', '$stadium_id_12'),
                       ('$team_id_11', '$team_id_09', '$shedule_id_18', '$stadium_id_11'),
                       ('$team_id_10', '$team_id_16', '$shedule_id_18', '$stadium_id_10'),
                       ('$team_id_05', '$team_id_01', '$shedule_id_19', '$stadium_id_05'),
                       ('$team_id_04', '$team_id_02', '$shedule_id_19', '$stadium_id_04'),
                       ('$team_id_16', '$team_id_03', '$shedule_id_19', '$stadium_id_16'),
                       ('$team_id_10', '$team_id_11', '$shedule_id_19', '$stadium_id_10'),
                       ('$team_id_09', '$team_id_12', '$shedule_id_19', '$stadium_id_09'),
                       ('$team_id_08', '$team_id_13', '$shedule_id_19', '$stadium_id_08'),
                       ('$team_id_07', '$team_id_14', '$shedule_id_19', '$stadium_id_07'),
                       ('$team_id_06', '$team_id_15', '$shedule_id_19', '$stadium_id_06'),
                       ('$team_id_03', '$team_id_04', '$shedule_id_20', '$stadium_id_03'),
                       ('$team_id_02', '$team_id_05', '$shedule_id_20', '$stadium_id_02'),
                       ('$team_id_01', '$team_id_06', '$shedule_id_20', '$stadium_id_01'),
                       ('$team_id_15', '$team_id_07', '$shedule_id_20', '$stadium_id_15'),
                       ('$team_id_14', '$team_id_08', '$shedule_id_20', '$stadium_id_14'),
                       ('$team_id_13', '$team_id_09', '$shedule_id_20', '$stadium_id_13'),
                       ('$team_id_12', '$team_id_10', '$shedule_id_20', '$stadium_id_12'),
                       ('$team_id_11', '$team_id_16', '$shedule_id_20', '$stadium_id_11'),
                       ('$team_id_07', '$team_id_01', '$shedule_id_21', '$stadium_id_07'),
                       ('$team_id_06', '$team_id_02', '$shedule_id_21', '$stadium_id_06'),
                       ('$team_id_05', '$team_id_03', '$shedule_id_21', '$stadium_id_05'),
                       ('$team_id_16', '$team_id_04', '$shedule_id_21', '$stadium_id_16'),
                       ('$team_id_11', '$team_id_12', '$shedule_id_21', '$stadium_id_11'),
                       ('$team_id_10', '$team_id_13', '$shedule_id_21', '$stadium_id_10'),
                       ('$team_id_09', '$team_id_14', '$shedule_id_21', '$stadium_id_09'),
                       ('$team_id_08', '$team_id_15', '$shedule_id_21', '$stadium_id_08'),
                       ('$team_id_04', '$team_id_05', '$shedule_id_22', '$stadium_id_04'),
                       ('$team_id_03', '$team_id_06', '$shedule_id_22', '$stadium_id_03'),
                       ('$team_id_02', '$team_id_07', '$shedule_id_22', '$stadium_id_02'),
                       ('$team_id_01', '$team_id_08', '$shedule_id_22', '$stadium_id_01'),
                       ('$team_id_15', '$team_id_09', '$shedule_id_22', '$stadium_id_15'),
                       ('$team_id_14', '$team_id_10', '$shedule_id_22', '$stadium_id_14'),
                       ('$team_id_13', '$team_id_11', '$shedule_id_22', '$stadium_id_13'),
                       ('$team_id_12', '$team_id_16', '$shedule_id_22', '$stadium_id_12'),
                       ('$team_id_09', '$team_id_01', '$shedule_id_23', '$stadium_id_09'),
                       ('$team_id_08', '$team_id_02', '$shedule_id_23', '$stadium_id_08'),
                       ('$team_id_07', '$team_id_03', '$shedule_id_23', '$stadium_id_07'),
                       ('$team_id_06', '$team_id_04', '$shedule_id_23', '$stadium_id_06'),
                       ('$team_id_16', '$team_id_05', '$shedule_id_23', '$stadium_id_16'),
                       ('$team_id_12', '$team_id_13', '$shedule_id_23', '$stadium_id_12'),
                       ('$team_id_11', '$team_id_14', '$shedule_id_23', '$stadium_id_11'),
                       ('$team_id_10', '$team_id_15', '$shedule_id_23', '$stadium_id_10'),
                       ('$team_id_05', '$team_id_06', '$shedule_id_24', '$stadium_id_05'),
                       ('$team_id_04', '$team_id_07', '$shedule_id_24', '$stadium_id_04'),
                       ('$team_id_03', '$team_id_08', '$shedule_id_24', '$stadium_id_03'),
                       ('$team_id_02', '$team_id_09', '$shedule_id_24', '$stadium_id_02'),
                       ('$team_id_01', '$team_id_10', '$shedule_id_24', '$stadium_id_01'),
                       ('$team_id_15', '$team_id_11', '$shedule_id_24', '$stadium_id_15'),
                       ('$team_id_14', '$team_id_12', '$shedule_id_24', '$stadium_id_14'),
                       ('$team_id_13', '$team_id_16', '$shedule_id_24', '$stadium_id_13'),
                       ('$team_id_11', '$team_id_01', '$shedule_id_25', '$stadium_id_11'),
                       ('$team_id_10', '$team_id_02', '$shedule_id_25', '$stadium_id_10'),
                       ('$team_id_09', '$team_id_03', '$shedule_id_25', '$stadium_id_09'),
                       ('$team_id_08', '$team_id_04', '$shedule_id_25', '$stadium_id_08'),
                       ('$team_id_07', '$team_id_05', '$shedule_id_25', '$stadium_id_07'),
                       ('$team_id_16', '$team_id_06', '$shedule_id_25', '$stadium_id_16'),
                       ('$team_id_13', '$team_id_14', '$shedule_id_25', '$stadium_id_13'),
                       ('$team_id_12', '$team_id_15', '$shedule_id_25', '$stadium_id_12'),
                       ('$team_id_06', '$team_id_07', '$shedule_id_26', '$stadium_id_06'),
                       ('$team_id_05', '$team_id_08', '$shedule_id_26', '$stadium_id_05'),
                       ('$team_id_04', '$team_id_09', '$shedule_id_26', '$stadium_id_04'),
                       ('$team_id_03', '$team_id_10', '$shedule_id_26', '$stadium_id_03'),
                       ('$team_id_02', '$team_id_11', '$shedule_id_26', '$stadium_id_02'),
                       ('$team_id_01', '$team_id_12', '$shedule_id_26', '$stadium_id_01'),
                       ('$team_id_15', '$team_id_13', '$shedule_id_26', '$stadium_id_15'),
                       ('$team_id_14', '$team_id_16', '$shedule_id_26', '$stadium_id_14'),
                       ('$team_id_13', '$team_id_01', '$shedule_id_27', '$stadium_id_13'),
                       ('$team_id_12', '$team_id_02', '$shedule_id_27', '$stadium_id_12'),
                       ('$team_id_11', '$team_id_03', '$shedule_id_27', '$stadium_id_11'),
                       ('$team_id_10', '$team_id_04', '$shedule_id_27', '$stadium_id_10'),
                       ('$team_id_09', '$team_id_05', '$shedule_id_27', '$stadium_id_09'),
                       ('$team_id_08', '$team_id_06', '$shedule_id_27', '$stadium_id_08'),
                       ('$team_id_16', '$team_id_07', '$shedule_id_27', '$stadium_id_16'),
                       ('$team_id_14', '$team_id_15', '$shedule_id_27', '$stadium_id_14'),
                       ('$team_id_07', '$team_id_08', '$shedule_id_28', '$stadium_id_07'),
                       ('$team_id_06', '$team_id_09', '$shedule_id_28', '$stadium_id_06'),
                       ('$team_id_05', '$team_id_10', '$shedule_id_28', '$stadium_id_05'),
                       ('$team_id_04', '$team_id_11', '$shedule_id_28', '$stadium_id_04'),
                       ('$team_id_03', '$team_id_12', '$shedule_id_28', '$stadium_id_03'),
                       ('$team_id_02', '$team_id_13', '$shedule_id_28', '$stadium_id_02'),
                       ('$team_id_01', '$team_id_14', '$shedule_id_28', '$stadium_id_01'),
                       ('$team_id_15', '$team_id_16', '$shedule_id_28', '$stadium_id_15'),
                       ('$team_id_15', '$team_id_01', '$shedule_id_29', '$stadium_id_15'),
                       ('$team_id_14', '$team_id_02', '$shedule_id_29', '$stadium_id_14'),
                       ('$team_id_13', '$team_id_03', '$shedule_id_29', '$stadium_id_13'),
                       ('$team_id_12', '$team_id_04', '$shedule_id_29', '$stadium_id_12'),
                       ('$team_id_11', '$team_id_05', '$shedule_id_29', '$stadium_id_11'),
                       ('$team_id_10', '$team_id_06', '$shedule_id_29', '$stadium_id_10'),
                       ('$team_id_09', '$team_id_07', '$shedule_id_29', '$stadium_id_09'),
                       ('$team_id_08', '$team_id_16', '$shedule_id_29', '$stadium_id_08'),
                       ('$team_id_08', '$team_id_09', '$shedule_id_30', '$stadium_id_08'),
                       ('$team_id_07', '$team_id_10', '$shedule_id_30', '$stadium_id_07'),
                       ('$team_id_06', '$team_id_11', '$shedule_id_30', '$stadium_id_06'),
                       ('$team_id_05', '$team_id_12', '$shedule_id_30', '$stadium_id_05'),
                       ('$team_id_04', '$team_id_13', '$shedule_id_30', '$stadium_id_04'),
                       ('$team_id_03', '$team_id_14', '$shedule_id_30', '$stadium_id_03'),
                       ('$team_id_02', '$team_id_15', '$shedule_id_30', '$stadium_id_02'),
                       ('$team_id_01', '$team_id_16', '$shedule_id_30', '$stadium_id_01');";
            f_igosja_mysqli_query($sql);
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
f_igosja_mysqli_query($sql);

$sql = "SELECT `shedule_id`
        FROM `shedule`
        WHERE `shedule_tournamenttype_id`='" . TOURNAMENTTYPE_CONFERENCE . "'
        AND `shedule_stage_id`='" . STAGE_1_TOUR . "'
        AND `shedule_season_id`='$igosja_season_id'
        LIMIT 1";
$shedule_sql = f_igosja_mysqli_query($sql);

$shedule_array = $shedule_sql->fetch_all(1);

$shedule_id = $shedule_array[0]['shedule_id'];

$sql = "SELECT `conference_team_id`,
               `stadium_id`
        FROM `conference`
        LEFT JOIN `team`
        ON `conference_team_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        WHERE `conference_season_id`='$igosja_season_id'
        ORDER BY RAND()";
$team_sql = f_igosja_mysqli_query($sql);

$count_team = $team_sql->num_rows;
$team_array = $team_sql->fetch_all(1);

for ($i=0; $i<$count_team; $i=$i+2)
{
    $team_1_id      = $team_array[$i]['conference_team_id'];
    $team_2_id      = $team_array[$i+1]['conference_team_id'];
    $stadium_id     = $team_array[$i]['stadium_id'];
    $game_array[]   = "('$team_1_id', '$team_2_id', '$shedule_id', '$stadium_id')";
}

$game_array = implode(', ', $game_array);

$sql = "INSERT INTO `game` (`game_guest_team_id`, `game_home_team_id`, `game_shedule_id`, `game_stadium_id`)
        VALUES $game_array;";
f_igosja_mysqli_query($sql);
//Конец формирования таблицы и матчей конференции

print '<br/><a href="/admin/index.php">Ready</a>';