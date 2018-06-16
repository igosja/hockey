<?php

/**
 * Переводимо голосування за заступника президента федерації зі статуса відкрито в статус закрыто
 * @param $electionpresidentvice_id integer id голосування
 */
function f_igosja_election_president_vice_to_close($electionpresidentvice_id)
{
    $sql = "SELECT `electionpresidentvice_country_id`
            FROM `electionpresidentvice`
            WHERE `electionpresidentvice_id`=$electionpresidentvice_id
            LIMIT 1";
    $electionpresidentvice_sql = f_igosja_mysqli_query($sql);

    $electionpresidentvice_array = $electionpresidentvice_sql->fetch_all(MYSQLI_ASSOC);

    $country_id = $electionpresidentvice_array[0]['electionpresidentvice_country_id'];

    $sql = "SELECT `electionpresidentviceapplication_user_id`
            FROM `electionpresidentviceapplication`
            LEFT JOIN `user`
            ON `electionpresidentviceapplication_user_id`=`user_id`
            LEFT JOIN
            (
                SELECT `userrating_rating`,
                       `userrating_user_id`
                FROM `userrating`
                WHERE `userrating_season_id`=0
            ) AS `t3`
            ON `user_id`=`userrating_user_id`
            WHERE `electionpresidentviceapplication_electionpresidentvice_id`=$electionpresidentvice_id
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
            ORDER BY `electionpresidentviceapplication_count` DESC, `userrating_rating` DESC, `user_date_register` ASC, `electionpresidentviceapplication_id` ASC
            LIMIT 1";
    $user_sql = f_igosja_mysqli_query($sql);

    if ($user_sql->num_rows)
    {
        $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

        $user_id = $user_array[0]['electionpresidentviceapplication_user_id'];

        if (0!= $user_id)
        {
            $log = array(
                'history_historytext_id' => HISTORYTEXT_USER_VICE_PRESIDENT_IN,
                'history_country_id' => $country_id,
                'history_user_id' => $user_id,
            );
            f_igosja_history($log);

            $sql = "UPDATE `country`
                    SET `country_vice_id`=$user_id
                    WHERE `country_id`=$country_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }

        $sql = "UPDATE `electionpresidentvice`
                SET `electionpresidentvice_electionstatus_id`=" . ELECTIONSTATUS_CLOSE . "
                WHERE `electionpresidentvice_id`=$electionpresidentvice_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }
}