<?php

/**
 * Формуємо таблиці та матчі національних чемпіонатів
 */
function f_igosja_newseason_worldcup()
{
    global $igosja_season_id;

    $sql = "SELECT `national_nationaltype_id`
            FROM `national`
            GROUP BY `national_nationaltype_id`
            ORDER BY `national_nationaltype_id` ASC";
    $nationaltype_sql = f_igosja_mysqli_query($sql);

    $nationaltype_array = $nationaltype_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($nationaltype_array as $nationaltype)
    {
        $nationaltype_id = $nationaltype['national_nationaltype_id'];

        $sql = "INSERT INTO `worldcup` (`worldcup_division_id`, `worldcup_national_id`, `worldcup_nationaltype_id`, `worldcup_season_id`)
                SELECT 1, `national_id`, $nationaltype_id, $igosja_season_id+1
                FROM `national`
                WHERE `national_nationaltype_id`=$nationaltype_id
                ORDER BY `national_id` ASC
                LIMIT 12";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `worldcup`
                SET `worldcup_place`=`worldcup_id`-((CEIL(`worldcup_id`/12)-1)*12)
                WHERE `worldcup_place`=0
                AND `worldcup_nationaltype_id`=$nationaltype_id
                AND `worldcup_season_id`=$igosja_season_id+1";
        f_igosja_mysqli_query($sql);
    }

    $sql = "SELECT `schedule_id`
            FROM `schedule`
            WHERE `schedule_season_id`=$igosja_season_id+1
            AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_NATIONAL . "
            ORDER BY `schedule_id` ASC
            LIMIT 11";
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

    foreach ($nationaltype_array as $nationaltype)
    {
        $nationaltype_id = $nationaltype['national_nationaltype_id'];

        $sql = "SELECT `worldcup_national_id`
                FROM `worldcup`
                WHERE `worldcup_nationaltype_id`=$nationaltype_id
                AND `worldcup_division_id`=1
                AND `worldcup_season_id`=$igosja_season_id+1
                ORDER BY RAND()";
        $national_sql = f_igosja_mysqli_query($sql);

        $national_array = $national_sql->fetch_all(MYSQLI_ASSOC);

        $national_id_01 = $national_array[0]['worldcup_national_id'];
        $national_id_02 = $national_array[1]['worldcup_national_id'];
        $national_id_03 = $national_array[2]['worldcup_national_id'];
        $national_id_04 = $national_array[3]['worldcup_national_id'];
        $national_id_05 = $national_array[4]['worldcup_national_id'];
        $national_id_06 = $national_array[5]['worldcup_national_id'];
        $national_id_07 = $national_array[6]['worldcup_national_id'];
        $national_id_08 = $national_array[7]['worldcup_national_id'];
        $national_id_09 = $national_array[8]['worldcup_national_id'];
        $national_id_10 = $national_array[9]['worldcup_national_id'];
        $national_id_11 = $national_array[10]['worldcup_national_id'];
        $national_id_12 = $national_array[11]['worldcup_national_id'];

        $sql = "INSERT INTO `game` (`game_bonus_home`, `game_home_national_id`, `game_guest_national_id`, `game_schedule_id`)
                VALUES (0, $national_id_01, $national_id_02, $schedule_id_01),
                       (0, $national_id_07, $national_id_12, $schedule_id_01),
                       (0, $national_id_08, $national_id_06, $schedule_id_01),
                       (0, $national_id_09, $national_id_05, $schedule_id_01),
                       (0, $national_id_10, $national_id_04, $schedule_id_01),
                       (0, $national_id_11, $national_id_03, $schedule_id_01),
                       (0, $national_id_03, $national_id_01, $schedule_id_02),
                       (0, $national_id_04, $national_id_11, $schedule_id_02),
                       (0, $national_id_05, $national_id_10, $schedule_id_02),
                       (0, $national_id_06, $national_id_09, $schedule_id_02),
                       (0, $national_id_07, $national_id_08, $schedule_id_02),
                       (0, $national_id_12, $national_id_02, $schedule_id_02),
                       (0, $national_id_01, $national_id_04, $schedule_id_03),
                       (0, $national_id_02, $national_id_03, $schedule_id_03),
                       (0, $national_id_08, $national_id_12, $schedule_id_03),
                       (0, $national_id_09, $national_id_07, $schedule_id_03),
                       (0, $national_id_10, $national_id_06, $schedule_id_03),
                       (0, $national_id_11, $national_id_05, $schedule_id_03),
                       (0, $national_id_04, $national_id_02, $schedule_id_04),
                       (0, $national_id_05, $national_id_01, $schedule_id_04),
                       (0, $national_id_06, $national_id_11, $schedule_id_04),
                       (0, $national_id_07, $national_id_10, $schedule_id_04),
                       (0, $national_id_08, $national_id_09, $schedule_id_04),
                       (0, $national_id_12, $national_id_03, $schedule_id_04),
                       (0, $national_id_01, $national_id_06, $schedule_id_05),
                       (0, $national_id_02, $national_id_05, $schedule_id_05),
                       (0, $national_id_03, $national_id_04, $schedule_id_05),
                       (0, $national_id_09, $national_id_12, $schedule_id_05),
                       (0, $national_id_10, $national_id_08, $schedule_id_05),
                       (0, $national_id_11, $national_id_07, $schedule_id_05),
                       (0, $national_id_05, $national_id_03, $schedule_id_06),
                       (0, $national_id_06, $national_id_02, $schedule_id_06),
                       (0, $national_id_07, $national_id_01, $schedule_id_06),
                       (0, $national_id_08, $national_id_11, $schedule_id_06),
                       (0, $national_id_09, $national_id_10, $schedule_id_06),
                       (0, $national_id_12, $national_id_04, $schedule_id_06),
                       (0, $national_id_01, $national_id_08, $schedule_id_07),
                       (0, $national_id_02, $national_id_07, $schedule_id_07),
                       (0, $national_id_03, $national_id_06, $schedule_id_07),
                       (0, $national_id_04, $national_id_05, $schedule_id_07),
                       (0, $national_id_10, $national_id_12, $schedule_id_07),
                       (0, $national_id_11, $national_id_09, $schedule_id_07),
                       (0, $national_id_06, $national_id_04, $schedule_id_08),
                       (0, $national_id_07, $national_id_03, $schedule_id_08),
                       (0, $national_id_08, $national_id_02, $schedule_id_08),
                       (0, $national_id_09, $national_id_01, $schedule_id_08),
                       (0, $national_id_10, $national_id_11, $schedule_id_08),
                       (0, $national_id_12, $national_id_05, $schedule_id_08),
                       (0, $national_id_01, $national_id_10, $schedule_id_09),
                       (0, $national_id_02, $national_id_09, $schedule_id_09),
                       (0, $national_id_03, $national_id_08, $schedule_id_09),
                       (0, $national_id_04, $national_id_07, $schedule_id_09),
                       (0, $national_id_05, $national_id_06, $schedule_id_09),
                       (0, $national_id_11, $national_id_12, $schedule_id_09),
                       (0, $national_id_07, $national_id_05, $schedule_id_10),
                       (0, $national_id_08, $national_id_04, $schedule_id_10),
                       (0, $national_id_09, $national_id_03, $schedule_id_10),
                       (0, $national_id_10, $national_id_02, $schedule_id_10),
                       (0, $national_id_11, $national_id_01, $schedule_id_10),
                       (0, $national_id_12, $national_id_06, $schedule_id_10),
                       (0, $national_id_01, $national_id_12, $schedule_id_11),
                       (0, $national_id_02, $national_id_11, $schedule_id_11),
                       (0, $national_id_03, $national_id_10, $schedule_id_11),
                       (0, $national_id_04, $national_id_09, $schedule_id_11),
                       (0, $national_id_05, $national_id_08, $schedule_id_11),
                       (0, $national_id_06, $national_id_07, $schedule_id_11);";
        f_igosja_mysqli_query($sql);
    }
}