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

    $country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

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

    $sql = "SELECT `schedule_id`
            FROM `schedule`
            WHERE `schedule_season_id`=1
            AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_CHAMPIONSHIP . "
            ORDER BY `schedule_id` ASC
            LIMIT 30";
    $schedule_sql = f_igosja_mysqli_query($sql);

    $schedule_array = $schedule_sql->fetch_all(MYSQLI_ASSOC);

    $schedule_id_01 = $schedule_array[0]['schedule_id'];
    $schedule_id_02 = $schedule_array[1]['schedule_id'];
    $schedule_id_03 = $schedule_array[2]['schedule_id'];
    $schedule_id_04 = $schedule_array[3]['schedule_id'];
    $schedule_id_05 = $schedule_array[4]['schedule_id'];
    $schedule_id_06 = $schedule_array[5]['schedule_id'];
    $schedule_id_07 = $schedule_array[6]['schedule_id'];
    $schedule_id_08 = $schedule_array[7]['schedule_id'];
    $schedule_id_09 = $schedule_array[8]['schedule_id'];
    $schedule_id_10 = $schedule_array[9]['schedule_id'];
    $schedule_id_11 = $schedule_array[10]['schedule_id'];
    $schedule_id_12 = $schedule_array[11]['schedule_id'];
    $schedule_id_13 = $schedule_array[12]['schedule_id'];
    $schedule_id_14 = $schedule_array[13]['schedule_id'];
    $schedule_id_15 = $schedule_array[14]['schedule_id'];
    $schedule_id_16 = $schedule_array[15]['schedule_id'];
    $schedule_id_17 = $schedule_array[16]['schedule_id'];
    $schedule_id_18 = $schedule_array[17]['schedule_id'];
    $schedule_id_19 = $schedule_array[18]['schedule_id'];
    $schedule_id_20 = $schedule_array[19]['schedule_id'];
    $schedule_id_21 = $schedule_array[20]['schedule_id'];
    $schedule_id_22 = $schedule_array[21]['schedule_id'];
    $schedule_id_23 = $schedule_array[22]['schedule_id'];
    $schedule_id_24 = $schedule_array[23]['schedule_id'];
    $schedule_id_25 = $schedule_array[24]['schedule_id'];
    $schedule_id_26 = $schedule_array[25]['schedule_id'];
    $schedule_id_27 = $schedule_array[26]['schedule_id'];
    $schedule_id_28 = $schedule_array[27]['schedule_id'];
    $schedule_id_29 = $schedule_array[28]['schedule_id'];
    $schedule_id_30 = $schedule_array[29]['schedule_id'];

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

            $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

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

            $sql = "INSERT INTO `game` (`game_home_team_id`, `game_guest_team_id`, `game_schedule_id`, `game_stadium_id`)
                    VALUES ($team_id_02, $team_id_01, $schedule_id_01, $stadium_id_02),
                           ($team_id_03, $team_id_15, $schedule_id_01, $stadium_id_03),
                           ($team_id_04, $team_id_14, $schedule_id_01, $stadium_id_04),
                           ($team_id_05, $team_id_13, $schedule_id_01, $stadium_id_05),
                           ($team_id_06, $team_id_12, $schedule_id_01, $stadium_id_06),
                           ($team_id_07, $team_id_11, $schedule_id_01, $stadium_id_07),
                           ($team_id_08, $team_id_10, $schedule_id_01, $stadium_id_08),
                           ($team_id_16, $team_id_09, $schedule_id_01, $stadium_id_16),
                           ($team_id_01, $team_id_03, $schedule_id_02, $stadium_id_01),
                           ($team_id_02, $team_id_16, $schedule_id_02, $stadium_id_02),
                           ($team_id_10, $team_id_09, $schedule_id_02, $stadium_id_10),
                           ($team_id_11, $team_id_08, $schedule_id_02, $stadium_id_11),
                           ($team_id_12, $team_id_07, $schedule_id_02, $stadium_id_12),
                           ($team_id_13, $team_id_06, $schedule_id_02, $stadium_id_13),
                           ($team_id_14, $team_id_05, $schedule_id_02, $stadium_id_14),
                           ($team_id_15, $team_id_04, $schedule_id_02, $stadium_id_15),
                           ($team_id_03, $team_id_02, $schedule_id_03, $stadium_id_03),
                           ($team_id_04, $team_id_01, $schedule_id_03, $stadium_id_04),
                           ($team_id_05, $team_id_15, $schedule_id_03, $stadium_id_05),
                           ($team_id_06, $team_id_14, $schedule_id_03, $stadium_id_06),
                           ($team_id_07, $team_id_13, $schedule_id_03, $stadium_id_07),
                           ($team_id_08, $team_id_12, $schedule_id_03, $stadium_id_08),
                           ($team_id_09, $team_id_11, $schedule_id_03, $stadium_id_09),
                           ($team_id_16, $team_id_10, $schedule_id_03, $stadium_id_16),
                           ($team_id_01, $team_id_05, $schedule_id_04, $stadium_id_01),
                           ($team_id_02, $team_id_04, $schedule_id_04, $stadium_id_02),
                           ($team_id_03, $team_id_16, $schedule_id_04, $stadium_id_03),
                           ($team_id_11, $team_id_10, $schedule_id_04, $stadium_id_11),
                           ($team_id_12, $team_id_09, $schedule_id_04, $stadium_id_12),
                           ($team_id_13, $team_id_08, $schedule_id_04, $stadium_id_13),
                           ($team_id_14, $team_id_07, $schedule_id_04, $stadium_id_14),
                           ($team_id_15, $team_id_06, $schedule_id_04, $stadium_id_15),
                           ($team_id_04, $team_id_03, $schedule_id_05, $stadium_id_04),
                           ($team_id_05, $team_id_02, $schedule_id_05, $stadium_id_05),
                           ($team_id_06, $team_id_01, $schedule_id_05, $stadium_id_06),
                           ($team_id_07, $team_id_15, $schedule_id_05, $stadium_id_07),
                           ($team_id_08, $team_id_14, $schedule_id_05, $stadium_id_08),
                           ($team_id_09, $team_id_13, $schedule_id_05, $stadium_id_09),
                           ($team_id_10, $team_id_12, $schedule_id_05, $stadium_id_10),
                           ($team_id_16, $team_id_11, $schedule_id_05, $stadium_id_16),
                           ($team_id_01, $team_id_07, $schedule_id_06, $stadium_id_01),
                           ($team_id_02, $team_id_06, $schedule_id_06, $stadium_id_02),
                           ($team_id_03, $team_id_05, $schedule_id_06, $stadium_id_03),
                           ($team_id_04, $team_id_16, $schedule_id_06, $stadium_id_04),
                           ($team_id_12, $team_id_11, $schedule_id_06, $stadium_id_12),
                           ($team_id_13, $team_id_10, $schedule_id_06, $stadium_id_13),
                           ($team_id_14, $team_id_09, $schedule_id_06, $stadium_id_14),
                           ($team_id_15, $team_id_08, $schedule_id_06, $stadium_id_15),
                           ($team_id_05, $team_id_04, $schedule_id_07, $stadium_id_05),
                           ($team_id_06, $team_id_03, $schedule_id_07, $stadium_id_06),
                           ($team_id_07, $team_id_02, $schedule_id_07, $stadium_id_07),
                           ($team_id_08, $team_id_01, $schedule_id_07, $stadium_id_08),
                           ($team_id_09, $team_id_15, $schedule_id_07, $stadium_id_09),
                           ($team_id_10, $team_id_14, $schedule_id_07, $stadium_id_10),
                           ($team_id_11, $team_id_13, $schedule_id_07, $stadium_id_11),
                           ($team_id_16, $team_id_12, $schedule_id_07, $stadium_id_16),
                           ($team_id_01, $team_id_09, $schedule_id_08, $stadium_id_01),
                           ($team_id_02, $team_id_08, $schedule_id_08, $stadium_id_02),
                           ($team_id_03, $team_id_07, $schedule_id_08, $stadium_id_03),
                           ($team_id_04, $team_id_06, $schedule_id_08, $stadium_id_04),
                           ($team_id_05, $team_id_16, $schedule_id_08, $stadium_id_05),
                           ($team_id_13, $team_id_12, $schedule_id_08, $stadium_id_13),
                           ($team_id_14, $team_id_11, $schedule_id_08, $stadium_id_14),
                           ($team_id_15, $team_id_10, $schedule_id_08, $stadium_id_15),
                           ($team_id_06, $team_id_05, $schedule_id_09, $stadium_id_06),
                           ($team_id_07, $team_id_04, $schedule_id_09, $stadium_id_07),
                           ($team_id_08, $team_id_03, $schedule_id_09, $stadium_id_08),
                           ($team_id_09, $team_id_02, $schedule_id_09, $stadium_id_09),
                           ($team_id_10, $team_id_01, $schedule_id_09, $stadium_id_10),
                           ($team_id_11, $team_id_15, $schedule_id_09, $stadium_id_11),
                           ($team_id_12, $team_id_14, $schedule_id_09, $stadium_id_12),
                           ($team_id_16, $team_id_13, $schedule_id_09, $stadium_id_16),
                           ($team_id_01, $team_id_11, $schedule_id_10, $stadium_id_01),
                           ($team_id_02, $team_id_10, $schedule_id_10, $stadium_id_02),
                           ($team_id_03, $team_id_09, $schedule_id_10, $stadium_id_03),
                           ($team_id_04, $team_id_08, $schedule_id_10, $stadium_id_04),
                           ($team_id_05, $team_id_07, $schedule_id_10, $stadium_id_05),
                           ($team_id_06, $team_id_16, $schedule_id_10, $stadium_id_06),
                           ($team_id_14, $team_id_13, $schedule_id_10, $stadium_id_14),
                           ($team_id_15, $team_id_12, $schedule_id_10, $stadium_id_15),
                           ($team_id_07, $team_id_06, $schedule_id_11, $stadium_id_07),
                           ($team_id_08, $team_id_05, $schedule_id_11, $stadium_id_08),
                           ($team_id_09, $team_id_04, $schedule_id_11, $stadium_id_09),
                           ($team_id_10, $team_id_03, $schedule_id_11, $stadium_id_10),
                           ($team_id_11, $team_id_02, $schedule_id_11, $stadium_id_11),
                           ($team_id_12, $team_id_01, $schedule_id_11, $stadium_id_12),
                           ($team_id_13, $team_id_15, $schedule_id_11, $stadium_id_13),
                           ($team_id_16, $team_id_14, $schedule_id_11, $stadium_id_16),
                           ($team_id_01, $team_id_13, $schedule_id_12, $stadium_id_01),
                           ($team_id_02, $team_id_12, $schedule_id_12, $stadium_id_02),
                           ($team_id_03, $team_id_11, $schedule_id_12, $stadium_id_03),
                           ($team_id_04, $team_id_10, $schedule_id_12, $stadium_id_04),
                           ($team_id_05, $team_id_09, $schedule_id_12, $stadium_id_05),
                           ($team_id_06, $team_id_08, $schedule_id_12, $stadium_id_06),
                           ($team_id_07, $team_id_16, $schedule_id_12, $stadium_id_07),
                           ($team_id_15, $team_id_14, $schedule_id_12, $stadium_id_15),
                           ($team_id_08, $team_id_07, $schedule_id_13, $stadium_id_08),
                           ($team_id_09, $team_id_06, $schedule_id_13, $stadium_id_09),
                           ($team_id_10, $team_id_05, $schedule_id_13, $stadium_id_10),
                           ($team_id_11, $team_id_04, $schedule_id_13, $stadium_id_11),
                           ($team_id_12, $team_id_03, $schedule_id_13, $stadium_id_12),
                           ($team_id_13, $team_id_02, $schedule_id_13, $stadium_id_13),
                           ($team_id_14, $team_id_01, $schedule_id_13, $stadium_id_14),
                           ($team_id_16, $team_id_15, $schedule_id_13, $stadium_id_16),
                           ($team_id_01, $team_id_15, $schedule_id_14, $stadium_id_01),
                           ($team_id_02, $team_id_14, $schedule_id_14, $stadium_id_02),
                           ($team_id_03, $team_id_13, $schedule_id_14, $stadium_id_03),
                           ($team_id_04, $team_id_12, $schedule_id_14, $stadium_id_04),
                           ($team_id_05, $team_id_11, $schedule_id_14, $stadium_id_05),
                           ($team_id_06, $team_id_10, $schedule_id_14, $stadium_id_06),
                           ($team_id_07, $team_id_09, $schedule_id_14, $stadium_id_07),
                           ($team_id_16, $team_id_08, $schedule_id_14, $stadium_id_16),
                           ($team_id_09, $team_id_08, $schedule_id_15, $stadium_id_09),
                           ($team_id_10, $team_id_07, $schedule_id_15, $stadium_id_10),
                           ($team_id_11, $team_id_06, $schedule_id_15, $stadium_id_11),
                           ($team_id_12, $team_id_05, $schedule_id_15, $stadium_id_12),
                           ($team_id_13, $team_id_04, $schedule_id_15, $stadium_id_13),
                           ($team_id_14, $team_id_03, $schedule_id_15, $stadium_id_14),
                           ($team_id_15, $team_id_02, $schedule_id_15, $stadium_id_15),
                           ($team_id_16, $team_id_01, $schedule_id_15, $stadium_id_16),
                           ($team_id_01, $team_id_02, $schedule_id_16, $stadium_id_01),
                           ($team_id_15, $team_id_03, $schedule_id_16, $stadium_id_15),
                           ($team_id_14, $team_id_04, $schedule_id_16, $stadium_id_14),
                           ($team_id_13, $team_id_05, $schedule_id_16, $stadium_id_13),
                           ($team_id_12, $team_id_06, $schedule_id_16, $stadium_id_12),
                           ($team_id_11, $team_id_07, $schedule_id_16, $stadium_id_11),
                           ($team_id_10, $team_id_08, $schedule_id_16, $stadium_id_10),
                           ($team_id_09, $team_id_16, $schedule_id_16, $stadium_id_09),
                           ($team_id_03, $team_id_01, $schedule_id_17, $stadium_id_03),
                           ($team_id_16, $team_id_02, $schedule_id_17, $stadium_id_16),
                           ($team_id_09, $team_id_10, $schedule_id_17, $stadium_id_09),
                           ($team_id_08, $team_id_11, $schedule_id_17, $stadium_id_08),
                           ($team_id_07, $team_id_12, $schedule_id_17, $stadium_id_07),
                           ($team_id_06, $team_id_13, $schedule_id_17, $stadium_id_06),
                           ($team_id_05, $team_id_14, $schedule_id_17, $stadium_id_05),
                           ($team_id_04, $team_id_15, $schedule_id_17, $stadium_id_04),
                           ($team_id_02, $team_id_03, $schedule_id_18, $stadium_id_02),
                           ($team_id_01, $team_id_04, $schedule_id_18, $stadium_id_01),
                           ($team_id_15, $team_id_05, $schedule_id_18, $stadium_id_15),
                           ($team_id_14, $team_id_06, $schedule_id_18, $stadium_id_14),
                           ($team_id_13, $team_id_07, $schedule_id_18, $stadium_id_13),
                           ($team_id_12, $team_id_08, $schedule_id_18, $stadium_id_12),
                           ($team_id_11, $team_id_09, $schedule_id_18, $stadium_id_11),
                           ($team_id_10, $team_id_16, $schedule_id_18, $stadium_id_10),
                           ($team_id_05, $team_id_01, $schedule_id_19, $stadium_id_05),
                           ($team_id_04, $team_id_02, $schedule_id_19, $stadium_id_04),
                           ($team_id_16, $team_id_03, $schedule_id_19, $stadium_id_16),
                           ($team_id_10, $team_id_11, $schedule_id_19, $stadium_id_10),
                           ($team_id_09, $team_id_12, $schedule_id_19, $stadium_id_09),
                           ($team_id_08, $team_id_13, $schedule_id_19, $stadium_id_08),
                           ($team_id_07, $team_id_14, $schedule_id_19, $stadium_id_07),
                           ($team_id_06, $team_id_15, $schedule_id_19, $stadium_id_06),
                           ($team_id_03, $team_id_04, $schedule_id_20, $stadium_id_03),
                           ($team_id_02, $team_id_05, $schedule_id_20, $stadium_id_02),
                           ($team_id_01, $team_id_06, $schedule_id_20, $stadium_id_01),
                           ($team_id_15, $team_id_07, $schedule_id_20, $stadium_id_15),
                           ($team_id_14, $team_id_08, $schedule_id_20, $stadium_id_14),
                           ($team_id_13, $team_id_09, $schedule_id_20, $stadium_id_13),
                           ($team_id_12, $team_id_10, $schedule_id_20, $stadium_id_12),
                           ($team_id_11, $team_id_16, $schedule_id_20, $stadium_id_11),
                           ($team_id_07, $team_id_01, $schedule_id_21, $stadium_id_07),
                           ($team_id_06, $team_id_02, $schedule_id_21, $stadium_id_06),
                           ($team_id_05, $team_id_03, $schedule_id_21, $stadium_id_05),
                           ($team_id_16, $team_id_04, $schedule_id_21, $stadium_id_16),
                           ($team_id_11, $team_id_12, $schedule_id_21, $stadium_id_11),
                           ($team_id_10, $team_id_13, $schedule_id_21, $stadium_id_10),
                           ($team_id_09, $team_id_14, $schedule_id_21, $stadium_id_09),
                           ($team_id_08, $team_id_15, $schedule_id_21, $stadium_id_08),
                           ($team_id_04, $team_id_05, $schedule_id_22, $stadium_id_04),
                           ($team_id_03, $team_id_06, $schedule_id_22, $stadium_id_03),
                           ($team_id_02, $team_id_07, $schedule_id_22, $stadium_id_02),
                           ($team_id_01, $team_id_08, $schedule_id_22, $stadium_id_01),
                           ($team_id_15, $team_id_09, $schedule_id_22, $stadium_id_15),
                           ($team_id_14, $team_id_10, $schedule_id_22, $stadium_id_14),
                           ($team_id_13, $team_id_11, $schedule_id_22, $stadium_id_13),
                           ($team_id_12, $team_id_16, $schedule_id_22, $stadium_id_12),
                           ($team_id_09, $team_id_01, $schedule_id_23, $stadium_id_09),
                           ($team_id_08, $team_id_02, $schedule_id_23, $stadium_id_08),
                           ($team_id_07, $team_id_03, $schedule_id_23, $stadium_id_07),
                           ($team_id_06, $team_id_04, $schedule_id_23, $stadium_id_06),
                           ($team_id_16, $team_id_05, $schedule_id_23, $stadium_id_16),
                           ($team_id_12, $team_id_13, $schedule_id_23, $stadium_id_12),
                           ($team_id_11, $team_id_14, $schedule_id_23, $stadium_id_11),
                           ($team_id_10, $team_id_15, $schedule_id_23, $stadium_id_10),
                           ($team_id_05, $team_id_06, $schedule_id_24, $stadium_id_05),
                           ($team_id_04, $team_id_07, $schedule_id_24, $stadium_id_04),
                           ($team_id_03, $team_id_08, $schedule_id_24, $stadium_id_03),
                           ($team_id_02, $team_id_09, $schedule_id_24, $stadium_id_02),
                           ($team_id_01, $team_id_10, $schedule_id_24, $stadium_id_01),
                           ($team_id_15, $team_id_11, $schedule_id_24, $stadium_id_15),
                           ($team_id_14, $team_id_12, $schedule_id_24, $stadium_id_14),
                           ($team_id_13, $team_id_16, $schedule_id_24, $stadium_id_13),
                           ($team_id_11, $team_id_01, $schedule_id_25, $stadium_id_11),
                           ($team_id_10, $team_id_02, $schedule_id_25, $stadium_id_10),
                           ($team_id_09, $team_id_03, $schedule_id_25, $stadium_id_09),
                           ($team_id_08, $team_id_04, $schedule_id_25, $stadium_id_08),
                           ($team_id_07, $team_id_05, $schedule_id_25, $stadium_id_07),
                           ($team_id_16, $team_id_06, $schedule_id_25, $stadium_id_16),
                           ($team_id_13, $team_id_14, $schedule_id_25, $stadium_id_13),
                           ($team_id_12, $team_id_15, $schedule_id_25, $stadium_id_12),
                           ($team_id_06, $team_id_07, $schedule_id_26, $stadium_id_06),
                           ($team_id_05, $team_id_08, $schedule_id_26, $stadium_id_05),
                           ($team_id_04, $team_id_09, $schedule_id_26, $stadium_id_04),
                           ($team_id_03, $team_id_10, $schedule_id_26, $stadium_id_03),
                           ($team_id_02, $team_id_11, $schedule_id_26, $stadium_id_02),
                           ($team_id_01, $team_id_12, $schedule_id_26, $stadium_id_01),
                           ($team_id_15, $team_id_13, $schedule_id_26, $stadium_id_15),
                           ($team_id_14, $team_id_16, $schedule_id_26, $stadium_id_14),
                           ($team_id_13, $team_id_01, $schedule_id_27, $stadium_id_13),
                           ($team_id_12, $team_id_02, $schedule_id_27, $stadium_id_12),
                           ($team_id_11, $team_id_03, $schedule_id_27, $stadium_id_11),
                           ($team_id_10, $team_id_04, $schedule_id_27, $stadium_id_10),
                           ($team_id_09, $team_id_05, $schedule_id_27, $stadium_id_09),
                           ($team_id_08, $team_id_06, $schedule_id_27, $stadium_id_08),
                           ($team_id_16, $team_id_07, $schedule_id_27, $stadium_id_16),
                           ($team_id_14, $team_id_15, $schedule_id_27, $stadium_id_14),
                           ($team_id_07, $team_id_08, $schedule_id_28, $stadium_id_07),
                           ($team_id_06, $team_id_09, $schedule_id_28, $stadium_id_06),
                           ($team_id_05, $team_id_10, $schedule_id_28, $stadium_id_05),
                           ($team_id_04, $team_id_11, $schedule_id_28, $stadium_id_04),
                           ($team_id_03, $team_id_12, $schedule_id_28, $stadium_id_03),
                           ($team_id_02, $team_id_13, $schedule_id_28, $stadium_id_02),
                           ($team_id_01, $team_id_14, $schedule_id_28, $stadium_id_01),
                           ($team_id_15, $team_id_16, $schedule_id_28, $stadium_id_15),
                           ($team_id_15, $team_id_01, $schedule_id_29, $stadium_id_15),
                           ($team_id_14, $team_id_02, $schedule_id_29, $stadium_id_14),
                           ($team_id_13, $team_id_03, $schedule_id_29, $stadium_id_13),
                           ($team_id_12, $team_id_04, $schedule_id_29, $stadium_id_12),
                           ($team_id_11, $team_id_05, $schedule_id_29, $stadium_id_11),
                           ($team_id_10, $team_id_06, $schedule_id_29, $stadium_id_10),
                           ($team_id_09, $team_id_07, $schedule_id_29, $stadium_id_09),
                           ($team_id_08, $team_id_16, $schedule_id_29, $stadium_id_08),
                           ($team_id_08, $team_id_09, $schedule_id_30, $stadium_id_08),
                           ($team_id_07, $team_id_10, $schedule_id_30, $stadium_id_07),
                           ($team_id_06, $team_id_11, $schedule_id_30, $stadium_id_06),
                           ($team_id_05, $team_id_12, $schedule_id_30, $stadium_id_05),
                           ($team_id_04, $team_id_13, $schedule_id_30, $stadium_id_04),
                           ($team_id_03, $team_id_14, $schedule_id_30, $stadium_id_03),
                           ($team_id_02, $team_id_15, $schedule_id_30, $stadium_id_02),
                           ($team_id_01, $team_id_16, $schedule_id_30, $stadium_id_01);";
            f_igosja_mysqli_query($sql);
        }
    }
}