<?php

/**
 * Звільняємо менеджерів з посад тренерів зайвих клубів
 */
function f_igosja_generator_user_fire_extra_team()
{
    $sql = "SELECT COUNT(`team_id`) AS `count_team`,
                   `user_id`
            FROM `team`
            LEFT JOIN `user`
            ON `team_user_id`=`user_id`
            WHERE `user_id`!=0
            AND `user_date_vip`<UNIX_TIMESTAMP()
            GROUP BY `user_id`
            HAVING COUNT(`team_id`)>1";
    $user_sql = f_igosja_mysqli_query($sql);

    $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($user_array as $item)
    {
        $user_id    = $item['user_id'];
        $limit      = $item['count_team'] - 1;

        $sql = "SELECT `team_id`
                FROM `team`
                LEFT JOIN `history`
                ON (`history_team_id`=`team_id`
                AND `history_user_id`=`team_user_id`)
                WHERE `team_user_id`=$user_id
                AND `history_historytext_id`=" . HISTORYTEXT_USER_MANAGER_TEAM_IN . "
                GROUP BY `team_id`
                ORDER BY MAX(`history_id`) DESC
                LIMIT $limit";
        $team_sql = f_igosja_mysqli_query($sql);

        $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

        foreach ($team_array as $team)
        {
            f_igosja_fire_user($user_id, $team['team_id']);
        }
    }
    $sql = "SELECT COUNT(`team_id`) AS `count_team`,
                   `user_id`
            FROM `team`
            LEFT JOIN `user`
            ON `team_user_id`=`user_id`
            WHERE `user_id`!=0
            AND `user_date_vip`>=UNIX_TIMESTAMP()
            GROUP BY `user_id`
            HAVING COUNT(`team_id`)>2";
    $user_sql = f_igosja_mysqli_query($sql);

    $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($user_array as $item)
    {
        $user_id    = $item['user_id'];
        $limit      = $item['count_team'] - 2;

        $sql = "SELECT `team_id`
                FROM `team`
                LEFT JOIN `history`
                ON (`history_team_id`=`team_id`
                AND `history_user_id`=`team_user_id`)
                WHERE `team_user_id`=$user_id
                AND `history_historytext_id`=" . HISTORYTEXT_USER_MANAGER_TEAM_IN . "
                GROUP BY `team_id`
                ORDER BY MAX(`history_id`) DESC
                LIMIT $limit";
        $team_sql = f_igosja_mysqli_query($sql);

        $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

        foreach ($team_array as $team)
        {
            f_igosja_fire_user($user_id, $team['team_id']);
        }
    }
}