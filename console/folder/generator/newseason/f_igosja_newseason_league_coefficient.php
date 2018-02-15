<?php

/**
 * Записуємо учасників ЛЧ наступного сезону в таблицю коефіцієнтів
 */
function f_igosja_newseason_league_coefficient()
{
    global $igosja_season_id;

    $sql = "INSERT INTO `leaguecoefficient` (`leaguecoefficient_country_id`, `leaguecoefficient_season_id`, `leaguecoefficient_team_id`)
            SELECT `city_country_id`, `participantleague_season_id`, `team_id`
            FROM `participantleague`
            LEFT JOIN `team`
            ON `participantleague_team_id`=`team_id`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`city_id`
            WHERE `participantleague_season_id`=$igosja_season_id+1";
    f_igosja_mysqli_query($sql);
}