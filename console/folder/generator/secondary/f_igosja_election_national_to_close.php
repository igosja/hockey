<?php

/**
 * Переводимо голосування за тренера збірної зі статуса відкрито в статус закрыто
 * @param $electionnational_id integer id голосування
 */
function f_igosja_election_national_to_close($electionnational_id)
{
    $sql = "SELECT `electionnational_country_id`,
                   `electionnational_nationaltype_id`
            FROM `electionnational`
            WHERE `electionnational_id`=$electionnational_id
            LIMIT 1";
    $electionnational_sql = f_igosja_mysqli_query($sql);

    $electionnational_array = $electionnational_sql->fetch_all(MYSQLI_ASSOC);

    $country_id         = $electionnational_array[0]['electionnational_country_id'];
    $nationaltype_id    = $electionnational_array[0]['electionnational_nationaltype_id'];

    $sql = "SELECT `electionnationalapplication_id`,
                   `electionnationalapplication_user_id`
            FROM `electionnationalapplication`
            LEFT JOIN `user`
            ON `electionnationalapplication_user_id`=`user_id`
            LEFT JOIN
            (
                SELECT `userrating_rating`,
                       `userrating_user_id`
                FROM `userrating`
                WHERE `userrating_season_id`=0
            ) AS `t1`
            ON `user_id`=`userrating_user_id`
            LEFT JOIN
            (
                SELECT `electionnationalapplicationplayer_electionnationalapplication_id`,
                       SUM(`player_power_nominal_s`) AS `electionnationalapplication_power`
                FROM `electionnationalapplicationplayer`
                LEFT JOIN `player`
                ON `electionnationalapplicationplayer_player_id`=`player_id`
                WHERE `electionnationalapplicationplayer_electionnationalapplication_id` IN
                (
                    SELECT `electionnationalapplication_id`
                    FROM `electionnational`
                    LEFT JOIN `electionnationalapplication`
                    ON `electionnational_id`=`electionnationalapplication_electionnational_id`
                    WHERE `electionnational_id`=$electionnational_id
                )
                GROUP BY `electionnationalapplicationplayer_electionnationalapplication_id`
            ) AS `t2`
            ON `electionnationalapplication_id`=`electionnationalapplicationplayer_electionnationalapplication_id`
            WHERE `electionnationalapplication_electionnational_id`=$electionnational_id
            AND `user_id` NOT IN
            (
                SELECT `national_user_id`
                FROM `national`
            )
            AND `user_id` NOT IN
            (
                SELECT `national_vice_id`
                FROM `national`
            )
            AND `user_id`!=0
            ORDER BY `electionnationalapplication_count` DESC, `electionnationalapplication_power` DESC, `userrating_rating` DESC, `user_date_register` ASC, `electionnationalapplication_id` ASC
            LIMIT 2";
    $user_sql = f_igosja_mysqli_query($sql);

    if ($user_sql->num_rows)
    {
        $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

        $user_id = $user_array[0]['electionnationalapplication_user_id'];

        if (0 != $user_id)
        {
            $sql = "SELECT `national_id`
                    FROM `national`
                    WHERE `national_country_id`=$country_id
                    AND `national_nationaltype_id`=$nationaltype_id
                    LIMIT 1";
            $national_sql = f_igosja_mysqli_query($sql);

            $national_array = $national_sql->fetch_all(MYSQLI_ASSOC);

            $national_id = $national_array[0]['national_id'];

            $log = array(
                'history_historytext_id' => HISTORYTEXT_USER_MANAGER_NATIONAL_IN,
                'history_national_id' => $national_id,
                'history_user_id' => $user_id,
            );
            f_igosja_history($log);

            if (isset($user_array[1]['electionnationalapplication_user_id']))
            {
                $vice_id = $user_array[1]['electionnationalapplication_user_id'];

                $log = array(
                    'history_historytext_id' => HISTORYTEXT_USER_VICE_NATIONAL_IN,
                    'history_national_id' => $national_id,
                    'history_user_id' => $vice_id,
                );
                f_igosja_history($log);
            }
            else
            {
                $vice_id = 0;
            }

            $sql = "UPDATE `national`
                    SET `national_user_id`=$user_id,
                        `national_vice_id`=$vice_id
                    WHERE `national_id`=$national_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $application_id = $user_array[0]['electionnationalapplication_id'];

            $sql = "UPDATE `electionnationalapplicationplayer`
                    LEFT JOIN `player`
                    ON `electionnationalapplicationplayer_player_id`=`player_id`
                    SET `player_national_id`=$national_id
                    WHERE `electionnationalapplicationplayer_electionnationalapplication_id`=$application_id";
            f_igosja_mysqli_query($sql);
        }

        $sql = "UPDATE `electionnational`
                SET `electionnational_electionstatus_id`=" . ELECTIONSTATUS_CLOSE . "
                WHERE `electionnational_id`=$electionnational_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }
}