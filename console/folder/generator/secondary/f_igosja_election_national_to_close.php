<?php

/**
 * Переводимо голосування за тренера збірної зі статуса відкрито в статус закрыто
 * @param $nationaltype_id integer id типу збірної
 * @param $country_id integer id країни
 */
function f_igosja_election_national_to_close($nationaltype_id, $country_id = 0)
{
    if ($country_id)
    {
        $sql = "SELECT `electionnational_country_id`,
                       `electionnational_id`
                FROM `electionnational`
                WHERE `electionnational_electionstatus_id`=" . ELECTIONSTATUS_OPEN . "
                AND `electionnational_nationaltype_id`=$nationaltype_id
                AND `electionnational_country_id`=$country_id
                ORDER BY `electionnational_id` ASC";
    }
    else
    {
        $sql = "SELECT `electionnational_country_id`,
                       `electionnational_id`
                FROM `electionnational`
                WHERE `electionnational_electionstatus_id`=" . ELECTIONSTATUS_OPEN . "
                AND `electionnational_nationaltype_id`=$nationaltype_id
                ORDER BY `electionnational_id` ASC";
    }

    $electionnational_sql = f_igosja_mysqli_query($sql);

    $electionnational_array = $electionnational_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($electionnational_array as $item)
    {
        $country_id             = $item['electionnational_country_id'];
        $electionnational_id    = $item['electionnational_id'];

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
                ) AS `t3`
                ON `user_id`=`userrating_user_id`
                LEFT JOIN
                (
                    SELECT COUNT(`electionnationaluser_user_id`) AS `count_answer`,
                           `electionnationaluser_electionnationalapplication_id`
                    FROM `electionnationaluser`
                    WHERE `electionnationaluser_electionnationalapplication_id`=$electionnational_id
                    GROUP BY `electionnationaluser_electionnationalapplication_id`
                ) AS `t1`
                ON `electionnationalapplication_id`=`electionnationaluser_electionnationalapplication_id`
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
                ORDER BY `count_answer` DESC, `userrating_rating` DESC, `electionnationalapplication_power` DESC, `user_date_register` ASC, `electionnationalapplication_id` ASC
                LIMIT 2";
        $user_sql = f_igosja_mysqli_query($sql);

        if ($user_sql->num_rows)
        {
            $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

            $user_id = $user_array[0]['electionnationalapplication_user_id'];

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

                if (in_array($nationaltype_id, array(NATIONALTYPE_19, NATIONALTYPE_21)))
                {
                    if (NATIONALTYPE_21 == $nationaltype_id)
                    {
                        $sql = "SELECT COUNT(`national_id`) AS `count`
                                FROM `national`
                                WHERE `national_nationaltype_id`=" . NATIONALTYPE_MAIN . "
                                AND `national_vice_id`=$vice_id";
                    }
                    else
                    {
                        $sql = "SELECT COUNT(`national_id`) AS `count`
                                FROM `national`
                                WHERE `national_nationaltype_id` IN (" . NATIONALTYPE_MAIN . ", " . NATIONALTYPE_21 . "
                                AND `national_vice_id`=$vice_id";
                    }

                    $check_sql = f_igosja_mysqli_query($sql);

                    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

                    if ($check_array[0]['count'])
                    {
                        $vice_id = 0;
                    }
                    else
                    {
                        $log = array(
                            'history_historytext_id' => HISTORYTEXT_USER_VICE_NATIONAL_IN,
                            'history_national_id' => $national_id,
                            'history_user_id' => $vice_id,
                        );
                        f_igosja_history($log);
                    }
                }
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

            $application_id = $user_array[0]['electionnationalapplication_user_id'];

            $sql = "UPDATE `electionnationalapplicationplayer`
                    LEFT JOIN `player`
                    ON `electionnationalapplicationplayer_player_id`=`player_id`
                    SET `player_national_id`=$national_id
                    WHERE `electionnationalapplicationplayer_id`=$application_id";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `electionnational`
                    SET `electionnational_electionstatus_id`=" . ELECTIONSTATUS_CLOSE . "
                    WHERE `electionnational_id`=$electionnational_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }
    }
}