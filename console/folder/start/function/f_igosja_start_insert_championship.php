<?php

/**
 * Формуємо таблиці та матчі національних чемпіонатів
 */
function f_igosja_start_insert_championship()
{
    $championship_country_array = array();

    $sql = "SELECT `city_country_id`
            FROM `team`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`city_id`
            WHERE `team_id`!=0
            GROUP BY `city_country_id`
            HAVING COUNT(`team_id`)>=16
            ORDER BY `city_country_id` ASC";
    $country_sql = f_igosja_mysqli_query($sql);

    $country_array = $country_sql->fetch_all(1);

    foreach ($country_array as $country)
    {
        $country_id = $country['city_country_id'];

        $championship_country_array[] = $country_id;

        $sql = "INSERT INTO `championship` (`championship_country_id`, `championship_division_id`, `championship_season_id`, `championship_team_id`)
                SELECT `city_country_id`, 1, 1, `team_id`
                FROM `team`
                LEFT JOIN `stadium`
                ON `team_stadium_id`=`stadium_id`
                LEFT JOIN `city`
                ON `stadium_city_id`=`city_id`
                WHERE `team_id`!=0
                AND `city_country_id`=$country_id
                ORDER BY `team_id` ASC
                LIMIT 16";
        f_igosja_mysqli_query($sql);

        $sql = "INSERT INTO `championship` (`championship_country_id`, `championship_division_id`, `championship_season_id`, `championship_team_id`)
                SELECT `city_country_id`, 2, 1, `team_id`
                FROM `team`
                LEFT JOIN `stadium`
                ON `team_stadium_id`=`stadium_id`
                LEFT JOIN `city`
                ON `stadium_city_id`=`city_id`
                WHERE `team_id`!=0
                AND `city_country_id`=$country_id
                ORDER BY `team_id` ASC
                LIMIT 16, 16";
        f_igosja_mysqli_query($sql);
    }

    $sql = "UPDATE `championship`
            SET `championship_place`=`championship_id`-((CEIL(`championship_id`/16)-1)*16)
            WHERE `championship_place`=0";
    f_igosja_mysqli_query($sql);

    $sql = "SELECT `shedule_id`
            FROM `shedule`
            WHERE `shedule_season_id`=1
            AND `shedule_tournamenttype_id`=" . TOURNAMENTTYPE_CHAMPIONSHIP . "
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
                    WHERE `championship_country_id`=$item
                    AND `championship_division_id`=$i
                    AND `championship_season_id`=1
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
}