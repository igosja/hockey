<?php

include (__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    if (!isset($auth_user_id))
    {
        redirect('/wrong_page.php');
    }

    $num_get = $auth_user_id;
}

$sql = "SELECT `country_name`,
               `sex_name`,
               `user_birth_day`,
               `user_birth_month`,
               `user_birth_year`,
               `user_city`,
               `user_date_login`,
               `user_date_register`,
               `user_finance`,
               `user_login`,
               `user_money`
        FROM `user`
        LEFT JOIN `sex`
        ON `user_sex_id`=`sex_id`
        LEFT JOIN `country`
        ON `user_country_id`=`country_id`
        WHERE `user_id`=$num_get";
$user_sql = f_igosja_mysqli_query($sql);

if (0 == $user_sql->num_rows)
{
    redirect('/wrong_page');
}

$user_array = $user_sql->fetch_all(1);

$sql = "SELECT `championship_place`,
               `city_name`,
               `conference_place`,
               `country_id`,
               `country_name`,
               `division_id`,
               `division_name`,
               `team_id`,
               `team_name`,
               `team_power_vs`,
               `team_price_total`
        FROM `team`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        LEFT JOIN
        (
            SELECT `championship_place`,
                   `championship_team_id`,
                   `division_id`,
                   `division_name`
            FROM `championship`
            LEFT JOIN `division`
            ON `championship_division_id`=`division_id`
            WHERE `championship_team_id` IN
            (
                SELECT `team_id`
                FROM `team`
                WHERE `team_user_id`=$num_get
            )
            AND `championship_season_id`=$igosja_season_id
        ) AS `t1`
        ON `team_id`=`championship_team_id`
        LEFT JOIN
        (
            SELECT `conference_place`,
                   `conference_team_id`
            FROM `conference`
            WHERE `conference_team_id` IN
            (
                SELECT `team_id`
                FROM `team`
                WHERE `team_user_id`=$num_get
            )
            AND `conference_season_id`=$igosja_season_id
        ) AS `t2`
        ON `team_id`=`conference_team_id`
        WHERE `team_user_id`=$num_get
        ORDER BY `team_id` ASC";
$team_sql = f_igosja_mysqli_query($sql);

$team_array = $team_sql->fetch_all(1);

$sql = "SELECT `userrating_auto`,
               `userrating_collision_loose`,
               `userrating_collision_win`,
               `userrating_game`,
               `userrating_loose`,
               `userrating_loose_equal`,
               `userrating_loose_strong`,
               `userrating_loose_super`,
               `userrating_loose_weak`,
               `userrating_looseover`,
               `userrating_looseover_equal`,
               `userrating_looseover_strong`,
               `userrating_looseover_weak`,
               `userrating_rating`,
               `userrating_vs_super`,
               `userrating_vs_rest`,
               `userrating_win`,
               `userrating_win_equal`,
               `userrating_win_strong`,
               `userrating_win_super`,
               `userrating_win_weak`,
               `userrating_winover`,
               `userrating_winover_equal`,
               `userrating_winover_strong`,
               `userrating_winover_weak`
        FROM `userrating`
        WHERE `userrating_user_id`=$num_get
        AND `userrating_season_id`=0
        LIMIT 1";
$userrating_total_sql = f_igosja_mysqli_query($sql);

if (0 == $userrating_total_sql->num_rows)
{
    $sql = "INSERT INTO `userrating`
            SET `userrating_user_id`=$num_get";
    f_igosja_mysqli_query($sql);

    $sql = "SELECT `userrating_auto`,
                   `userrating_collision_loose`,
                   `userrating_collision_win`,
                   `userrating_game`,
                   `userrating_loose`,
                   `userrating_loose_equal`,
                   `userrating_loose_strong`,
                   `userrating_loose_super`,
                   `userrating_loose_weak`,
                   `userrating_looseover`,
                   `userrating_looseover_equal`,
                   `userrating_looseover_strong`,
                   `userrating_looseover_weak`,
                   `userrating_rating`,
                   `userrating_vs_super`,
                   `userrating_vs_rest`,
                   `userrating_win`,
                   `userrating_win_equal`,
                   `userrating_win_strong`,
                   `userrating_win_super`,
                   `userrating_win_weak`,
                   `userrating_winover`,
                   `userrating_winover_equal`,
                   `userrating_winover_strong`,
                   `userrating_winover_weak`
            FROM `userrating`
            WHERE `userrating_user_id`=$num_get
            AND `userrating_season_id`=0
            LIMIT 1";
    $userrating_total_sql = f_igosja_mysqli_query($sql);
}

$userrating_total_array = $userrating_total_sql->fetch_all(1);

$sql = "SELECT `userrating_auto`,
               `userrating_collision_loose`,
               `userrating_collision_win`,
               `userrating_game`,
               `userrating_loose`,
               `userrating_loose_equal`,
               `userrating_loose_strong`,
               `userrating_loose_super`,
               `userrating_loose_weak`,
               `userrating_looseover`,
               `userrating_looseover_equal`,
               `userrating_looseover_strong`,
               `userrating_looseover_weak`,
               `userrating_rating`,
               `userrating_season_id`,
               `userrating_vs_super`,
               `userrating_vs_rest`,
               `userrating_win`,
               `userrating_win_equal`,
               `userrating_win_strong`,
               `userrating_win_super`,
               `userrating_win_weak`,
               `userrating_winover`,
               `userrating_winover_equal`,
               `userrating_winover_strong`,
               `userrating_winover_weak`
        FROM `userrating`
        WHERE `userrating_user_id`=$num_get
        AND `userrating_season_id`!=0
        ORDER BY `userrating_season_id` DESC";
$userrating_sql = f_igosja_mysqli_query($sql);

$userrating_array = $userrating_sql->fetch_all(1);

$sql = "SELECT `log_date`,
               `log_season_id`,
               `logtext_name`
        FROM `log`
        LEFT JOIN `logtext`
        ON `log_logtext_id`=`logtext_id`
        WHERE `log_user_id`=$num_get
        ORDER BY `log_id` DESC";
$event_sql = f_igosja_mysqli_query($sql);

$event_array = $event_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');