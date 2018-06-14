<?php

/**
 * Звільняємо тренерів збірних
 */
function f_igosja_newseason_fire_national()
{
    $sql = "SELECT `national_id`,
                   `national_user_id`,
                   `national_vice_id`
            FROM `national`
            WHERE `national_user_id`!=0
            OR `national_vice_id`!=0
            ORDER BY `national_id` ASC";
    $national_sql = f_igosja_mysqli_query($sql);

    $national_array = $national_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($national_array as $item)
    {
        $national_id = $item['national_id'];

        if (0 != $item['national_user_id'])
        {
            $log = array(
                'history_national_id' => $national_id,
                'history_historytext_id' => HISTORYTEXT_USER_MANAGER_NATIONAL_OUT,
                'history_user_id' => $item['national_user_id'],
            );
            f_igosja_history($log);
        }

        if (0 != $item['national_vice_id'])
        {
            $log = array(
                'history_national_id' => $national_id,
                'history_historytext_id' => HISTORYTEXT_USER_VICE_NATIONAL_OUT,
                'history_user_id' => $item['national_vice_id'],
            );
            f_igosja_history($log);
        }

        $sql = "UPDATE `national`
                SET `national_user_id`=0,
                    `national_vice_id`=0
                WHERE `national_id`=$national_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }
}