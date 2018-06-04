<?php

/**
 * @var $auth_user_id integer
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$division_id = (int) f_igosja_request_get('division_id'))
{
    $division_id = 1;
}

if (!$season_id = (int) f_igosja_request_get('season_id'))
{
    $season_id = $igosja_season_id;
}

$sql = "SELECT `season_id`
        FROM `worldcup`
        LEFT JOIN `season`
        ON `worldcup_season_id`=`season_id`
        WHERE `worldcup_division_id`=$division_id
        GROUP BY `worldcup_season_id`
        ORDER BY `worldcup_season_id` DESC";
$season_sql = f_igosja_mysqli_query($sql);

$season_array = $season_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `division_id`,
               `division_name`
        FROM `worldcup`
        LEFT JOIN `division`
        ON `worldcup_division_id`=`division_id`
        WHERE `worldcup_season_id`=$season_id
        GROUP BY `worldcup_division_id`
        ORDER BY `division_id` ASC";
$division_sql = f_igosja_mysqli_query($sql);

$division_array = $division_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `schedule_date`,
               `stage_id`,
               `stage_name`
        FROM `schedule`
        LEFt JOIN `stage`
        ON `schedule_stage_id`=`stage_id`
        WHERE `schedule_season_id`=$season_id
        AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_NATIONAL . "
        ORDER BY `stage_id` ASC";
$stage_sql = f_igosja_mysqli_query($sql);

$stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

$schedule_id = 0;

if (!$stage_id = (int) f_igosja_request_get('stage_id'))
{
    $sql = "SELECT `schedule_id`,
                   `schedule_stage_id`
            FROM `schedule`
            WHERE `schedule_date`<=UNIX_TIMESTAMP()
            AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_NATIONAL . "
            AND `schedule_season_id`=$season_id
            ORDER BY `schedule_id` DESC
            LIMIT 1";
    $schedule_sql = f_igosja_mysqli_query($sql);

    if (0 == $schedule_sql->num_rows)
    {
        $sql = "SELECT `schedule_id`,
                       `schedule_stage_id`
                FROM `schedule`
                WHERE `schedule_date`>UNIX_TIMESTAMP()
                AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_NATIONAL . "
                AND `schedule_season_id`=$season_id
                ORDER BY `schedule_id` ASC
                LIMIT 1";
        $schedule_sql = f_igosja_mysqli_query($sql);
    }

    $schedule_array = $schedule_sql->fetch_all(MYSQLI_ASSOC);

    $schedule_id    = $schedule_array[0]['schedule_id'];
    $stage_id       = $schedule_array[0]['schedule_stage_id'];
}
else
{
    $sql = "SELECT `schedule_id`
            FROM `schedule`
            WHERE `schedule_stage_id`=$stage_id
            AND `schedule_season_id`=$season_id
            AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_NATIONAL . "
            ORDER BY `schedule_id` ASC
            LIMIT 1";
    $schedule_sql = f_igosja_mysqli_query($sql);

    if (0 == $schedule_sql->num_rows)
    {
        redirect('/wrong_page.php');
    }

    $schedule_array = $schedule_sql->fetch_all(MYSQLI_ASSOC);

    $schedule_id = $schedule_array[0]['schedule_id'];
}

$sql = "SELECT `game_id`,
               `game_guest_auto`,
               `game_guest_score`,
               `game_home_auto`,
               `game_home_score`,
               `game_played`,
               `guest_national`.`national_id` AS `guest_national_id`,
               `guest_country`.`country_name` AS `guest_country_name`,
               `home_national`.`national_id` AS `home_national_id`,
               `home_country`.`country_name` AS `home_country_name`
        FROM `game`
        LEFT JOIN `national` AS `guest_national`
        ON `game_guest_national_id`=`guest_national`.`national_id`
        LEFT JOIN `country` AS `guest_country`
        ON `guest_national`.`national_country_id`=`guest_country`.`country_id`
        LEFT JOIN `national` AS `home_national`
        ON `game_home_national_id`=`home_national`.`national_id`
        LEFT JOIN `country` AS `home_country`
        ON `home_national`.`national_country_id`=`home_country`.`country_id`
        LEFT JOIN `worldcup`
        ON `game_guest_national_id`=`worldcup_national_id`
        WHERE `game_schedule_id`=$schedule_id
        AND `worldcup_season_id`=$season_id
        AND `worldcup_division_id`=$division_id
        ORDER BY `game_id` ASC";
$game_sql = f_igosja_mysqli_query($sql);

if (0 == $game_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_id`,
               `country_name`,
               `national_id`,
               `national_power_vs`,
               `worldcup_game`,
               `worldcup_loose`,
               `worldcup_loose_bullet`,
               `worldcup_loose_over`,
               `worldcup_pass`,
               `worldcup_place`,
               `worldcup_point`,
               `worldcup_score`,
               `worldcup_win`,
               `worldcup_win_bullet`,
               `worldcup_win_over`
        FROM `worldcup`
        LEFT JOIN `national`
        ON `worldcup_national_id`=`national_id`
        LEFT JOIN `country`
        ON `national_country_id`=`country_id`
        WHERE `worldcup_season_id`=$season_id
        AND `worldcup_division_id`=$division_id
        ORDER BY `worldcup_place` ASC";
$national_sql = f_igosja_mysqli_query($sql);

$national_array = $national_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = 'Чемпионат мира';
$seo_description    = 'Чемпионат мира, календарь игр и турнирная таблица на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'чемпионат мира';

include(__DIR__ . '/view/layout/main.php');