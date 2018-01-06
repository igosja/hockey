<?php

/**
 * Записуємо ліміти країн в ЛЧ на наступний сезон
 */
function f_igosja_newseason_league_limit()
{
    global $igosja_season_id;

    $sql = "INSERT INTO `leaguedistribution`
        (
            `leaguedistribution_country_id`,
            `leaguedistribution_group`,
            `leaguedistribution_qualification_3`,
            `leaguedistribution_qualification_2`,
            `leaguedistribution_qualification_1`,
            `leaguedistribution_season_id`
        )
        VALUES (71, 2, 1, 1, 0, $igosja_season_id+2),
               (133, 2, 1, 1, 0, $igosja_season_id+2),
               (157, 2, 1, 1, 0, $igosja_season_id+2),
               (185, 2, 1, 1, 0, $igosja_season_id+2),
               (18, 2, 1, 0, 1, $igosja_season_id+2),
               (43, 2, 1, 0, 1, $igosja_season_id+2),
               (122, 2, 1, 0, 1, $igosja_season_id+2),
               (151, 2, 1, 0, 1, $igosja_season_id+2),
               (171, 2, 1, 0, 1, $igosja_season_id+2),
               (176, 2, 1, 0, 1, $igosja_season_id+2),
               (182, 2, 1, 0, 1, $igosja_season_id+2),
               (184, 2, 1, 0, 1, $igosja_season_id+2);";
    f_igosja_mysqli_query($sql);
}