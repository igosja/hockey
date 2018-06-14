<?php

/**
 * Звільнення президентів за низький рейтинг
 */
function f_igosja_generator_president_fire()
{
    $sql = "SELECT `country_id`,
                   `country_president_id`,
                   `country_vice_id`
            FROM `country`
            WHERE `country_president_id`!=0
            AND `country_vice_id`!=0
            ORDER BY `country_id` ASC";
    $country_sql = f_igosja_mysqli_query($sql);

    $country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($country_array as $item)
    {
        $country_id = $item['country_id'];

        $sql = "SELECT COUNT(`team_id`) AS `total`
                FROM `team`
                LEFT JOIN `stadium`
                ON `team_stadium_id`=`stadium_id`
                LEFT JOIN `city`
                ON `stadium_city_id`=`city_id`
                WHERE `city_country_id`=$country_id
                AND `team_user_id`!=0
                AND `team_vote_president`=" . VOTERATING_NEGATIVE;
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
                'history_country_id' => $country_id,
                'history_historytext_id' => HISTORYTEXT_USER_PRESIDENT_OUT,
                'history_user_id' => $item['country_president_id'],
            );
            f_igosja_history($log);

            $log = array(
                'history_country_id' => $country_id,
                'history_historytext_id' => HISTORYTEXT_USER_VICE_PRESIDENT_OUT,
                'history_user_id' => $item['country_vice_id'],
            );
            f_igosja_history($log);

            $log = array(
                'history_country_id' => $country_id,
                'history_historytext_id' => HISTORYTEXT_USER_PRESIDENT_IN,
                'history_user_id' => $item['country_vice_id'],
            );
            f_igosja_history($log);

            $sql = "UPDATE `country`
                    SET `country_president_id`=`country_vice_id`,
                        `country_vice_id`=0
                    WHERE `country_id`=$country_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `team`
                    LEFT JOIN `stadium`
                    ON `team_stadium_id`=`stadium_id`
                    LEFT JOIN `city`
                    ON `stadium_city_id`=`city_id`
                    SET `team_vote_president`=" . VOTERATING_NEUTRAL . "
                    WHERE `city_country_id`=$country_id";
            f_igosja_mysqli_query($sql);

            $news_text  = 'Действующий президент федерации отправлен в отставку по причине высокого уровня недоверия менеджеров федерации. Заместитель президента занял вакантную должность.';
            $news_title = 'Увольнение президента';

            $sql = "INSERT INTO `news`
                    SET `news_country_id`=$country_id,
                        `news_date`=UNIX_TIMESTAMP(),
                        `news_text`='$news_text',
                        `news_title`='$news_title',
                        `news_user_id`=1";
            f_igosja_mysqli_query($sql);
        }
    }
}