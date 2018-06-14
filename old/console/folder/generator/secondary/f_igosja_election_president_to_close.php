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
    $electionpresident_sql = f_igosja_mysqli_query($sql);

    $electionpresident_array = $electionpresident_sql->fetch_all(MYSQLI_ASSOC);

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
            WHERE `electionpresidentapplication_electionpresident_id`=$electionpresident_id
            AND `user_id` NOT IN
            (
                SELECT `country_president_id`
                FROM `country`
            )
            AND `user_id` NOT IN
            (
                SELECT `country_vice_id`
                FROM `country`
            )
            AND `user_id`!=0
            ORDER BY `electionpresidentapplication_count` DESC, `userrating_rating` DESC, `user_date_register` ASC, `electionpresidentapplication_id` ASC
            LIMIT 2";
    $user_sql = f_igosja_mysqli_query($sql);

    if ($user_sql->num_rows)
    {
        $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

        $user_id = $user_array[0]['electionpresidentapplication_user_id'];

        if (0 != $user_id)
        {
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
            f_igosja_mysqli_query($sql);
        }

        $sql = "UPDATE `electionpresident`
                SET `electionpresident_electionstatus_id`=" . ELECTIONSTATUS_CLOSE . "
                WHERE `electionpresident_id`=$electionpresident_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }
}