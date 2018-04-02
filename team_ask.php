<?php

/**
 * @var $auth_team_id integer
 * @var $auth_user_id integer
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

if ($auth_team_id)
{
    redirect('/team_view.php');
}

if ($num_get = (int) f_igosja_request_get('num'))
{
    $sql = "SELECT COUNT(`team_id`) AS `check`
            FROM `team`
            WHERE `team_id`=$num_get
            AND `team_user_id`=0";
    $team_sql = f_igosja_mysqli_query($sql);

    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

    if (0 == $team_array[0]['check'])
    {
        f_igosja_session_front_flash_set('error', 'Команда выбрана неправильно.');

        redirect('/team_ask.php');
    }

    $sql = "SELECT COUNT(`teamask_id`) AS `check`
            FROM `teamask`
            WHERE `teamask_user_id`=$auth_user_id
            AND `teamask_team_id`=$num_get";
    $teamask_sql = f_igosja_mysqli_query($sql);

    $teamask_array = $teamask_sql->fetch_all(MYSQLI_ASSOC);

    if ($teamask_array[0]['check'])
    {
        f_igosja_session_front_flash_set('error', 'Вы уже подали заявку на эту команду.');

        redirect('/team_ask.php');
    }

    $sql = "INSERT INTO `teamask`
            SET `teamask_date`=UNIX_TIMESTAMP(),
                `teamask_team_id`=$num_get,
                `teamask_user_id`=$auth_user_id";
    f_igosja_mysqli_query($sql);

    f_igosja_session_front_flash_set('success', 'Заявка успешно подана.');

    redirect('/team_ask.php');
}

$sql = "SELECT `base_slot_max`,
               `base_level`,
               `base_slot_max`,
               `basemedical_level`+
               `basephisical_level`+
               `baseschool_level`+
               `basescout_level`+
               `basetraining_level` AS `base_slot_used`,
               `city_name`,
               `conference_team_id`,
               `country_id`,
               `country_name`,
               `division_id`,
               `division_name`,
               `stadium_capacity`,
               `team_id`,
               `team_finance`,
               `team_name`,
               `team_power_vs`,
               `teamask_id`,
               IFNULL(`count`, 0) AS `teamask_count`
        FROM `teamask`
        LEFT JOIN `team`
        ON `teamask_team_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        LEFT JOIN `base`
        ON `team_base_id`=`base_id`
        LEFT JOIN `basemedical`
        ON `team_basemedical_id`=`basemedical_id`
        LEFT JOIN `basephisical`
        ON `team_basephisical_id`=`basephisical_id`
        LEFT JOIN `baseschool`
        ON `team_baseschool_id`=`baseschool_id`
        LEFT JOIN `basescout`
        ON `team_basescout_id`=`basescout_id`
        LEFT JOIN `basetraining`
        ON `team_basetraining_id`=`basetraining_id`
        LEFT JOIN 
        (
            SELECT `championship_team_id`,
                   `division_id`,
                   `division_name`
            FROM `championship`
            LEFT JOIN `division`
            ON `championship_division_id`=`division_id`
            WHERE `championship_season_id`=$igosja_season_id
        ) AS `t1`
        ON `championship_team_id`=`team_id`
        LEFT JOIN 
        (
            SELECT `conference_team_id`
            FROM `conference`
            WHERE `conference_season_id`=$igosja_season_id
        ) AS `t2`
        ON `conference_team_id`=`team_id`
        LEFT JOIN 
        (
            SELECT COUNT(`teamask_id`) AS `count`,
                   `teamask_team_id`
            FROM `teamask`
            GROUP BY `teamask_team_id`
        ) AS `t3`
        ON `team_id`=`t3`.`teamask_team_id`
        WHERE `teamask_user_id`=$auth_user_id";
$teamask_sql = f_igosja_mysqli_query($sql);

$teamask_array = $teamask_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `base_slot_max`,
               `base_level`,
               `base_slot_max`,
               `basemedical_level`+
               `basephisical_level`+
               `baseschool_level`+
               `basescout_level`+
               `basetraining_level` AS `base_slot_used`,
               `city_name`,
               `conference_team_id`,
               `country_id`,
               `country_name`,
               `division_id`,
               `division_name`,
               `stadium_capacity`,
               `team_id`,
               `team_finance`,
               `team_name`,
               `team_power_vs`,
               IFNULL(`count`, 0) AS `teamask_count`
        FROM `team`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        LEFT JOIN `base`
        ON `team_base_id`=`base_id`
        LEFT JOIN `basemedical`
        ON `team_basemedical_id`=`basemedical_id`
        LEFT JOIN `basephisical`
        ON `team_basephisical_id`=`basephisical_id`
        LEFT JOIN `baseschool`
        ON `team_baseschool_id`=`baseschool_id`
        LEFT JOIN `basescout`
        ON `team_basescout_id`=`basescout_id`
        LEFT JOIN `basetraining`
        ON `team_basetraining_id`=`basetraining_id`
        LEFT JOIN 
        (
            SELECT `championship_team_id`,
                   `division_id`,
                   `division_name`
            FROM `championship`
            LEFT JOIN `division`
            ON `championship_division_id`=`division_id`
            WHERE `championship_season_id`=$igosja_season_id
        ) AS `t1`
        ON `championship_team_id`=`team_id`
        LEFT JOIN 
        (
            SELECT `conference_team_id`
            FROM `conference`
            WHERE `conference_season_id`=$igosja_season_id
        ) AS `t2`
        ON `conference_team_id`=`team_id`
        LEFT JOIN 
        (
            SELECT COUNT(`teamask_id`) AS `count`,
                   `teamask_team_id`
            FROM `teamask`
            GROUP BY `teamask_team_id`
        ) AS `t3`
        ON `team_id`=`teamask_team_id`
        WHERE `team_user_id`=0
        AND `team_id`!=0
        ORDER BY `team_power_vs` DESC, `team_id` ASC";
$team_sql = f_igosja_mysqli_query($sql);

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = 'Получение команды';
$seo_description    = 'Получение команды на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'получение команды';

include(__DIR__ . '/view/layout/main.php');