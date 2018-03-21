<?php

/**
 * Звільняємо менеджерів з посад тренерів клубів
 */
function f_igosja_generator_user_fire()
{
    $sql = "SELECT `team_id`,
                   `user_id`
            FROM `team`
            LEFT JOIN `user`
            ON `team_user_id`=`user_id`
            WHERE `user_id`!=0
            AND `user_date_vip`<UNIX_TIMESTAMP()
            AND `team_auto`>=5
            AND `user_holiday`=0
            ORDER BY `user_id` ASC";
    $team_sql = f_igosja_mysqli_query($sql);

    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($team_array as $item)
    {
        f_igosja_fire_user($item['user_id'], $item['team_id']);
    }

    $sql = "SELECT `team_id`,
                   `user_id`
            FROM `team`
            LEFT JOIN `user`
            ON `team_user_id`=`user_id`
            WHERE `user_id`!=0
            AND `user_date_vip`<UNIX_TIMESTAMP()
            AND `user_date_login`<UNIX_TIMESTAMP()-1296000
            AND `user_holiday`=0
            ORDER BY `user_id` ASC";//15 днів для не VIP
    $team_sql = f_igosja_mysqli_query($sql);

    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($team_array as $item)
    {
        f_igosja_fire_user($item['user_id'], $item['team_id']);
    }

    $sql = "SELECT `team_id`,
                   `user_id`
            FROM `team`
            LEFT JOIN `user`
            ON `team_user_id`=`user_id`
            WHERE `user_id`!=0
            AND `user_date_vip`>=UNIX_TIMESTAMP()
            AND `user_date_login`<UNIX_TIMESTAMP()-5184000
            AND `user_holiday`=0
            ORDER BY `user_id` ASC";//60 днів для VIP
    $team_sql = f_igosja_mysqli_query($sql);

    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($team_array as $item)
    {
        f_igosja_fire_user($item['user_id'], $item['team_id']);
    }
}