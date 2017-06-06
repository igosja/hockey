<?php

/**
 * Позбавляємо користувачів їх команд за невідвідуваність більше 5 днів
 */
function f_igosja_generator_user_deprive_team()
{
    $sql = "SELECT `team_id`,
                   `user_id`
            FROM `team`
            LEFT JOIN `user`
            ON `team_user_id`=`user_id`
            WHERE `team_user_id`!=0
            AND `user_date_login`<UNIX_TIMESTAMP()-432000
            AND `user_holiday`=0
            ORDER BY `user_id` ASC";
    $team_sql = f_igosja_mysqli_query($sql);

    $team_array = $team_sql->fetch_all(1);

    foreach ($team_array as $item)
    {
        $team_id = $item['team_id'];

        $sql = "UPDATE `team`
                SET `team_user_id`=0
                WHERE `team_id`=$team_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $log = array(
            'history_historytext_id' => HISTORYTEXT_USER_MANAGER_TEAM_OUT,
            'history_team_id' => $team_id,
            'history_user_id' => $item['user_id'],
        );
        f_igosja_history($log);
    }

    usleep(1);

    print '.';
    flush();
}