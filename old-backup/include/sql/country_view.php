<?php

/**
 * @var $auth_country_id integer
 * @var $auth_team_id integer
 * @var $num_get integer
 */

$sql = "SELECT `country_finance`,
               `country_name`,
               `president`.`user_date_login` AS `president_date_login`,
               `president`.`user_id` AS `president_id`,
               `president`.`user_login` AS `president_login`,
               `vice`.`user_date_login` AS `vice_date_login`,
               `vice`.`user_id` AS `vice_id`,
               `vice`.`user_login` AS `vice_login`
        FROM `country`
        LEFT JOIN `user` AS `president`
        ON `country_president_id`=`president`.`user_id`
        LEFT JOIN `user` AS `vice`
        ON `country_vice_id`=`vice`.`user_id`
        WHERE `country_id`=$num_get
        LIMIT 1";
$country_sql = f_igosja_mysqli_query($sql);

if (0 == $country_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT COUNT(`team_id`) AS `total`
        FROM `team`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        WHERE `city_country_id`=$num_get
        AND `team_user_id`!=0
        AND `team_vote_president`=" . VOTERATING_POSITIVE;
$rating_positive_sql = f_igosja_mysqli_query($sql);

$rating_positive_array = $rating_positive_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT COUNT(`team_id`) AS `total`
        FROM `team`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        WHERE `city_country_id`=$num_get
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
        WHERE `city_country_id`=$num_get
        AND `team_user_id`!=0";
$rating_total_sql = f_igosja_mysqli_query($sql);

$rating_total_array = $rating_total_sql->fetch_all(MYSQLI_ASSOC);

$rating_positive    = round($rating_positive_array[0]['total'] / $rating_total_array[0]['total'] * 100);
$rating_negative    = round($rating_negative_array[0]['total'] / $rating_total_array[0]['total'] * 100);
$rating_neutral     = 100 - $rating_positive - $rating_negative;

if (isset($auth_country_id) && $auth_country_id == $num_get)
{
    if ($data = f_igosja_request_post('data'))
    {
        if (isset($data['vote_president']))
        {
            $vote = (int) $data['vote_president'];

            $sql = "SELECT COUNT(`relation_id`) AS `check`
                    FROM `relation`
                    WHERE `relation_id`=$vote";
            $check_sql = f_igosja_mysqli_query($sql);

            $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

            if (0 == $check_array[0]['check'])
            {
                f_igosja_session_front_flash_set('error', 'Отношение к президенту выбрано неправильно.');

                refresh();
            }

            $sql = "UPDATE `team`
                    SET `team_vote_president`=$vote
                    WHERE `team_id`=$auth_team_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            f_igosja_session_front_flash_set('success', 'Отношение к президенту успешно сохранено.');

            refresh();
        }
    }

    $sql = "SELECT `relation_id`,
                   `relation_name`
            FROM `team`
            LEFT JOIN `relation`
            ON `team_vote_president`=`relation_id`
            WHERE `team_id`=$auth_team_id
            LIMIT 1";
    $relation_sql = f_igosja_mysqli_query($sql);

    $relation_array = $relation_sql->fetch_all(MYSQLI_ASSOC);

    $auth_relation_id   = $relation_array[0]['relation_id'];
    $auth_relation_name = $relation_array[0]['relation_name'];

    $sql = "SELECT `relation_id`,
                   `relation_name`
            FROM `relation`
            ORDER BY `relation_order` ASC";
    $relation_sql = f_igosja_mysqli_query($sql);

    $relation_array = $relation_sql->fetch_all(MYSQLI_ASSOC);
}