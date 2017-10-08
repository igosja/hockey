<?php

/**
 * Переводимо голосування за тренера збірної зі статуса відкрито в статус закрыто
 * @param $electionnationalvice_id integer id голосування
 */
function f_igosja_election_national_vice_to_close($electionnationalvice_id)
{
    $sql = "SELECT `electionnationalvice_country_id`,
                   `electionnationalvice_nationaltype_id`
            FROM `electionnationalvice`
            WHERE `electionnationalvice_id`=$electionnationalvice_id
            LIMIT 1";
    $electionnationalvice_sql = f_igosja_mysqli_query($sql, false);

    $electionnationalvice_array = $electionnationalvice_sql->fetch_all(1);
    $country_id                 = $electionnationalvice_array[0]['electionnationalvice_country_id'];
    $nationaltype_id            = $electionnationalvice_array[0]['electionnationalvice_nationaltype_id'];

    $sql = "SELECT `electionnationalviceapplication_user_id`
            FROM `electionnationalviceapplication`
            LEFT JOIN `user`
            ON `electionnationalviceapplication_user_id`=`user_id`
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
                SELECT COUNT(`electionnationalviceuser_user_id`) AS `count_answer`,
                       `electionnationalviceuser_electionnationalviceapplication_id`
                FROM `electionnationalviceuser`
                WHERE `electionnationalviceuser_electionnationalviceapplication_id`=$electionnationalvice_id
                GROUP BY `electionnationalviceuser_electionnationalviceapplication_id`
            ) AS `t1`
            ON `electionnationalviceapplication_id`=`electionnationalviceuser_electionnationalviceapplication_id`
            WHERE `electionnationalviceapplication_electionnationalvice_id`=$electionnationalvice_id
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
            ORDER BY `count_answer` DESC, `userrating_rating` DESC, `user_date_register` ASC, `electionnationalviceapplication_id` ASC
            LIMIT 1";
    $user_sql = f_igosja_mysqli_query($sql, false);

    if ($user_sql->num_rows)
    {
        $user_array = $user_sql->fetch_all(1);

        $user_id = $user_array[0]['electionnationalviceapplication_user_id'];

        $sql = "SELECT `national_id`
                FROM `national`
                WHERE `national_country_id`=$country_id
                AND `national_nationaltype_id`=$nationaltype_id
                LIMIT 1";
        $national_sql = f_igosja_mysqli_query($sql, false);

        $national_array = $national_sql->fetch_all(1);

        $national_id = $national_array[0]['national_id'];

        $log = array(
            'history_historytext_id' => HISTORYTEXT_USER_VICE_NATIONAL_IN,
            'history_national_id' => $national_id,
            'history_user_id' => $user_id,
        );
        f_igosja_history($log);

        $sql = "UPDATE `national`
                SET `national_vice_id`=$user_id
                WHERE `national_id`=$national_id
                LIMIT 1";
        f_igosja_mysqli_query($sql, false);

        $sql = "UPDATE `electionnationalvice`
                SET `electionnationalvice_electionstatus_id`=" . ELECTIONSTATUS_CLOSE . "
                WHERE `electionnationalvice_id`=$electionnationalvice_id
                LIMIT 1";
        f_igosja_mysqli_query($sql, false);
    }
}