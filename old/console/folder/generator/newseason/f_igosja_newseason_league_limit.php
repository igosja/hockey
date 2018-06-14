<?php

/**
 * Записуємо ліміти країн в ЛЧ на наступний сезон
 */
function f_igosja_newseason_league_limit()
{
    global $igosja_season_id;

    $sql = "SELECT `ratingcountry_country_id`,
                   `ratingcountry_league_place`
            FROM `ratingcountry`
            ORDER BY `ratingcountry_league_place` ASC";
    $country_sql = f_igosja_mysqli_query($sql);

    $country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

    $values = array();

    foreach ($country_array as $item)
    {
        if ($item['ratingcountry_league_place'] <= 4)
        {
            $values[] = '(' . $item['ratingcountry_country_id'] . ', 2, 1, 1, 0, ' . ($igosja_season_id + 2) . ')';
        }
        else
        {
            $values[] = '(' . $item['ratingcountry_country_id'] . ', 2, 1, 0, 1, ' . ($igosja_season_id + 2) . ')';
        }
    }

    $values = implode(',', $values);

    $sql = "INSERT INTO `leaguedistribution`
            (
                `leaguedistribution_country_id`,
                `leaguedistribution_group`,
                `leaguedistribution_qualification_3`,
                `leaguedistribution_qualification_2`,
                `leaguedistribution_qualification_1`,
                `leaguedistribution_season_id`
            )
            VALUES $values;";
    f_igosja_mysqli_query($sql);
}