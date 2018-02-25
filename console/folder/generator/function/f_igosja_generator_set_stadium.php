<?php

/**
 * Вызначаємо стадіони в матчах збірних
 */
function f_igosja_generator_set_stadium()
{
    $sql = "SELECT `game_id`,
                   `game_home_national_id`
            FROM `game`
            LEFT JOIN `schedule`
            ON `game_schedule_id`=`schedule_id`
            WHERE `game_played`=0
            AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_NATIONAL . "
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($game_array as $game)
    {
        $game_id        = $game['game_id'];
        $national_id    = $game['game_home_national_id'];

        $sql = "SELECT `stadium_id`
                FROM `stadium`
                LEFT JOIN `city`
                ON `stadium_city_id`=`city_id`
                LEFT JOIN `national`
                ON `city_country_id`=`national_country_id`
                WHERE `national_id`=$national_id
                ORDER BY `stadium_capacity` DESC, `stadium_id` ASC
                LIMIT 1";
        $stadium_sql = f_igosja_mysqli_query($sql);

        $stadium_array = $stadium_sql->fetch_all(MYSQLI_ASSOC);

        $stadium_id = $stadium_array[0]['stadium_id'];

        $sql = "UPDATE `game`
                SET `game_stadium_id`=$stadium_id
                WHERE `game_id`=$game_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }
}