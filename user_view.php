<?php

/**
 * @var $auth_user_id integer
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    if (!isset($auth_user_id))
    {
        redirect('/wrong_page.php');
    }

    $num_get = $auth_user_id;
}

include(__DIR__ . '/include/sql/user_view.php');

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

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_name`,
               `division_id`,
               `division_name`,
               `national_id`,
               `national_power_vs`,
               `nationaltype_name`,
               `worldcup_place`
        FROM `national`
        LEFT JOIN `country`
        ON `national_country_id`=`country_id`
        LEFT JOIN `nationaltype`
        ON `national_nationaltype_id`=`nationaltype_id`
        LEFT JOIN
        (
            SELECT `worldcup_place`,
                   `worldcup_national_id`,
                   `division_id`,
                   `division_name`
            FROM `worldcup`
            LEFT JOIN `division`
            ON `worldcup_division_id`=`division_id`
            WHERE `worldcup_national_id` IN
            (
                SELECT `national_id`
                FROM `national`
                WHERE `national_user_id`=$num_get
            )
            AND `worldcup_season_id`=$igosja_season_id
        ) AS `t1`
        ON `national_id`=`worldcup_national_id`
        WHERE `national_user_id`=$num_get
        ORDER BY `national_id` ASC";
$national_sql = f_igosja_mysqli_query($sql);

$national_array = $national_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_name`,
               `division_id`,
               `division_name`,
               `national_id`,
               `national_power_vs`,
               `nationaltype_name`,
               `worldcup_place`
        FROM `national`
        LEFT JOIN `country`
        ON `national_country_id`=`country_id`
        LEFT JOIN `nationaltype`
        ON `national_nationaltype_id`=`nationaltype_id`
        LEFT JOIN
        (
            SELECT `worldcup_place`,
                   `worldcup_national_id`,
                   `division_id`,
                   `division_name`
            FROM `worldcup`
            LEFT JOIN `division`
            ON `worldcup_division_id`=`division_id`
            WHERE `worldcup_national_id` IN
            (
                SELECT `national_id`
                FROM `national`
                WHERE `national_vice_id`=$num_get
            )
            AND `worldcup_season_id`=$igosja_season_id
        ) AS `t1`
        ON `national_id`=`worldcup_national_id`
        WHERE `national_vice_id`=$num_get
        ORDER BY `national_id` ASC";
$nationalvice_sql = f_igosja_mysqli_query($sql);

$nationalvice_array = $nationalvice_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        WHERE `country_president_id`=$num_get
        AND `country_id`!=0
        ORDER BY `country_id` ASC";
$president_sql = f_igosja_mysqli_query($sql);

$president_array = $president_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        WHERE `country_vice_id`=$num_get
        AND `country_id`!=0
        ORDER BY `country_id` ASC";
$presidentvice_sql = f_igosja_mysqli_query($sql);

$presidentvice_array = $presidentvice_sql->fetch_all(MYSQLI_ASSOC);

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

$userrating_total_array = $userrating_total_sql->fetch_all(MYSQLI_ASSOC);

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

$userrating_array = $userrating_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `history_country`.`country_name`,
               `history_building_id`,
               `history_country_id`,
               `history_date`,
               `history_season_id`,
               `history_value`,
               `historytext_name`,
               `name_name`,
               `national_id`,
               `national_country`.`country_name` AS `national_name`,
               `nationaltype_name`,
               `player_id`,
               `position_short`,
               `special_name`,
               `surname_name`,
               `team_id`,
               `team_name`,
               `user_id`,
               `user_login`
        FROM `history`
        LEFT JOIN `historytext`
        ON `history_historytext_id`=`historytext_id`
        LEFT JOIN `team`
        ON `history_team_id`=`team_id`
        LEFT JOIN `user`
        ON `history_user_id`=`user_id`
        LEFT JOIN `special`
        ON `history_special_id`=`special_id`
        LEFT JOIN `position`
        ON `history_position_id`=`position_id`
        LEFT JOIN `player`
        ON `history_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `national`
        ON `history_national_id`=`national_id`
        LEFT JOIN `nationaltype`
        ON `national_nationaltype_id`=`nationaltype_id`
        LEFT JOIN `country` AS `national_country`
        ON `national_country_id`=`national_country`.`country_id`
        LEFT JOIN `country` AS `history_country`
        ON `history_country_id`=`history_country`.`country_id`
        WHERE `history_user_id`=$num_get
        ORDER BY `history_id` DESC";
$event_sql = f_igosja_mysqli_query($sql);

$count_event = $event_sql->num_rows;
$event_array = $event_sql->fetch_all(MYSQLI_ASSOC);

for ($i=0; $i<$count_event; $i++)
{
    $event_array[$i]['historytext_name'] = f_igosja_event_text($event_array[$i]);
}

$seo_title          = $user_array[0]['user_login'] . '. Профиль менеджера';
$seo_description    = $user_array[0]['user_login'] . '. Профиль менеджера на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $user_array[0]['user_login'] . ' профиль менеджера';

include(__DIR__ . '/view/layout/main.php');