<?php

/**
 * Переводимо голосування за президента федерації зі статуса відкрито в статус закрыто
 * @param $electionpresident_id integer id голосування
 */
function f_igosja_election_president_to_close($electionpresident_id)
{
    $sql = "SELECT `electionpresident_country_id`
            FROM `electionpresident`
            WHERE `electionpresident_id`=$electionpresident_id
            LIMIT 1";
    $electionpresident_sql = f_igosja_mysqli_query($sql, false);

    $electionpresident_array = $electionpresident_sql->fetch_all(1);

    $country_id = $electionpresident_array[0]['electionpresident_country_id'];

    $sql = "SELECT `electionpresidentapplication_user_id`
            FROM `electionpresidentapplication`
            LEFT JOIN `user`
            ON `electionpresidentapplication_user_id`=`user_id`
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
                SELECT COUNT(`electionpresidentuser_user_id`) AS `count_answer`,
                       `electionpresidentuser_electionpresidentapplication_id`
                FROM `electionpresidentuser`
                WHERE `electionpresidentuser_electionpresidentapplication_id`=$electionpresident_id
                GROUP BY `electionpresidentuser_electionpresidentapplication_id`
            ) AS `t1`
            ON `electionpresidentapplication_id`=`electionpresidentuser_electionpresidentapplication_id`
            WHERE `electionpresidentapplication_electionpresident_id`=$electionpresident_id
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
            ORDER BY `count_answer` DESC, `userrating_rating` DESC, `user_date_register` ASC, `electionpresidentapplication_id` ASC
            LIMIT 2";
    $user_sql = f_igosja_mysqli_query($sql, false);

    if ($user_sql->num_rows)
    {
        $user_array = $user_sql->fetch_all(1);

        $user_id = $user_array[0]['electionpresidentapplication_user_id'];

        $log = array(
            'history_historytext_id' => HISTORYTEXT_USER_PRESIDENT_IN,
            'history_country_id' => $country_id,
            'history_user_id' => $user_id,
        );
        f_igosja_history($log);

        if (isset($user_array[1]['electionpresidentapplication_user_id']))
        {
            $vice_id = $user_array[1]['electionpresidentapplication_user_id'];

            $log = array(
                'history_historytext_id' => HISTORYTEXT_USER_VICE_PRESIDENT_IN,
                'history_country_id' => $country_id,
                'history_user_id' => $vice_id,
            );
            f_igosja_history($log);
        }
        else
        {
            $vice_id = 0;
        }

        $sql = "UPDATE `country`
                SET `country_president_id`=$user_id,
                    `country_vice_id`=$vice_id
                WHERE `country_id`=$country_id
                LIMIT 1";
        f_igosja_mysqli_query($sql, false);

        $sql = "UPDATE `electionpresident`
                SET `electionpresident_electionstatus_id`=" . ELECTIONSTATUS_CLOSE . "
                WHERE `electionpresident_id`=$electionpresident_id
                LIMIT 1";
        f_igosja_mysqli_query($sql, false);
    }
}