<?php

/**
 * Звільнення замів президентів за невідвідуваність сайту на протязі 15 днів
 */
function f_igosja_generator_president_vice_fire()
{
    $sql = "SELECT `country_id`,
                   `country_vice_id`
            FROM `country`
            LEFT JOIN `user`
            ON `country_vice_id`=`user_id`
            WHERE `user_id`!=0
            AND `user_date_login`<UNIX_TIMESTAMP()-1296000
            ORDER BY `country_id` ASC";
    $country_sql = f_igosja_mysqli_query($sql);

    $country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($country_array as $item)
    {
        $country_id = $item['country_id'];

        $log = array(
            'history_country_id' => $country_id,
            'history_historytext_id' => HISTORYTEXT_USER_VICE_PRESIDENT_OUT,
            'history_user_id' => $item['country_vice_id'],
        );
        f_igosja_history($log);

        $sql = "UPDATE `country`
                SET `country_vice_id`=0
                WHERE `country_id`=$country_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }
}