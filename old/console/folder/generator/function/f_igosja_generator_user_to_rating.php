<?php

/**
 * Записуємо менеджерів в таблиці рейтингу
 */
function f_igosja_generator_user_to_rating()
{
    global $igosja_season_id;

    $sql = "SELECT `user_id`
            FROM `user`
            LEFT JOIN `team`
            ON `user_id`=`team_user_id`
            WHERE `team_id` IS NOT NULL
            AND `user_id`!=0
            ORDER BY `user_id` ASC";
    $user_sql = f_igosja_mysqli_query($sql);

    $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($user_array as $game)
    {
        $user_id = $game['user_id'];

        $sql = "SELECT COUNT(`userrating_id`) AS `count`
                FROM `userrating`
                WHERE `userrating_user_id`=$user_id
                AND `userrating_season_id`=0";
        $check_sql = f_igosja_mysqli_query($sql);

        $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

        if (0 == $check_array[0]['count'])
        {
            $sql = "INSERT INTO `userrating`
                    SET `userrating_user_id`=$user_id,
                        `userrating_season_id`=0";
            f_igosja_mysqli_query($sql);
        }

        $sql = "SELECT COUNT(`userrating_id`) AS `count`
                FROM `userrating`
                WHERE `userrating_user_id`=$user_id
                AND `userrating_season_id`=$igosja_season_id";
        $check_sql = f_igosja_mysqli_query($sql);

        $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

        if (0 == $check_array[0]['count'])
        {
            $sql = "INSERT INTO `userrating`
                    SET `userrating_user_id`=$user_id,
                        `userrating_season_id`=$igosja_season_id";
            f_igosja_mysqli_query($sql);
        }
    }
}