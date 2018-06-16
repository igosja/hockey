<?php

/**
 * Звільнення тренерів збірних за низький рейтинг
 */
function f_igosja_generator_national_fire()
{
    $sql = "SELECT `national_country_id`,
                   `national_id`,
                   `national_nationaltype_id`,
                   `national_user_id`,
                   `national_vice_id`
            FROM `national`
            WHERE `national_user_id`!=0
            AND `national_vice_id`!=0
            ORDER BY `national_id` ASC";
    $national_sql = f_igosja_mysqli_query($sql);

    $national_array = $national_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($national_array as $item)
    {
        $country_id     = $item['national_country_id'];
        $national_id    = $item['national_id'];

        $sql = "SELECT COUNT(`team_id`) AS `total`
                FROM `team`
                LEFT JOIN `stadium`
                ON `team_stadium_id`=`stadium_id`
                LEFT JOIN `city`
                ON `stadium_city_id`=`city_id`
                WHERE `city_country_id`=$country_id
                AND `team_user_id`!=0
                AND `team_vote_national`=" . VOTERATING_NEGATIVE;
        $rating_negative_sql = f_igosja_mysqli_query($sql);

        $rating_negative_array = $rating_negative_sql->fetch_all(MYSQLI_ASSOC);

        $sql = "SELECT IF(COUNT(`team_id`)=0, 1, COUNT(`team_id`)) AS `total`
                FROM `team`
                LEFT JOIN `stadium`
                ON `team_stadium_id`=`stadium_id`
                LEFT JOIN `city`
                ON `stadium_city_id`=`city_id`
                WHERE `city_country_id`=$country_id
                AND `team_user_id`!=0";
        $rating_total_sql = f_igosja_mysqli_query($sql);

        $rating_total_array = $rating_total_sql->fetch_all(MYSQLI_ASSOC);

        $rating_negative = round($rating_negative_array[0]['total'] / $rating_total_array[0]['total'] * 100);

        if ($rating_negative > 25)
        {
            $log = array(
                'history_historytext_id' => HISTORYTEXT_USER_MANAGER_NATIONAL_OUT,
                'history_national_id' => $national_id,
                'history_user_id' => $item['national_user_id'],
            );
            f_igosja_history($log);

            $log = array(
                'history_historytext_id' => HISTORYTEXT_USER_VICE_NATIONAL_OUT,
                'history_national_id' => $national_id,
                'history_user_id' => $item['national_vice_id'],
            );
            f_igosja_history($log);

            $log = array(
                'history_historytext_id' => HISTORYTEXT_USER_MANAGER_NATIONAL_IN,
                'history_national_id' => $national_id,
                'history_user_id' => $item['national_vice_id'],
            );
            f_igosja_history($log);

            $sql = "UPDATE `national`
                    SET `national_user_id`=`national_vice_id`,
                        `national_vice_id`=0
                    WHERE `national_id`=$national_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `team`
                    LEFT JOIN `stadium`
                    ON `team_stadium_id`=`stadium_id`
                    LEFT JOIN `city`
                    ON `stadium_city_id`=`city_id`
                    SET `team_vote_national`=" . VOTERATING_NEUTRAL . "
                    WHERE `city_country_id`=$country_id";
            f_igosja_mysqli_query($sql);
        }
    }
}