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

if (0 == $auth_team_id)
{
    redirect('/team_ask.php');
}

$num_get = $auth_user_id;

include(__DIR__ . '/include/sql/user_view.php');

if ($data = f_igosja_request_get('ok'))
{
    $sql = "SELECT `base_level`
            FROM `team`
            LEFT JOIN `base`
            ON `team_base_id`=`base_id`
            WHERE `team_id`=$auth_team_id";
    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

    if ($check_array[0]['base_level'] >= 5)
    {
        f_igosja_session_front_flash_set('error', 'Перерегистрировать нельзя: база команды достигла 5-го уровня.');

        redirect('/user_re_registration.php');
    }

    $sql = "SELECT COUNT(`player_id`) AS `check`
            FROM `player`
            WHERE `player_rent_team_id`=$auth_team_id";
    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

    if (0 != $check_array[0]['check'])
    {
        f_igosja_session_front_flash_set('error', 'Перерегистрировать нельзя: в команде находятся арендованные игроки.');

        redirect('/user_re_registration.php');
    }

    $sql = "SELECT COUNT(`player_id`) AS `check`
            FROM `player`
            WHERE `player_team_id`=$auth_team_id
            AND `player_rent_team_id`!=0";
    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

    if (0 != $check_array[0]['check'])
    {
        f_igosja_session_front_flash_set('error', 'Перерегистрировать нельзя: игроки команды находятся в аренде.');

        redirect('/user_re_registration.php');
    }

    $sql = "SELECT COUNT(`player_id`) AS `check`
            FROM `player`
            WHERE `player_team_id`=$auth_team_id
            AND `player_national_id`!=0";
    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

    if (0 != $check_array[0]['check'])
    {
        f_igosja_session_front_flash_set('error', 'Перерегистрировать нельзя: в команде есть игроки сборной.');

        redirect('/user_re_registration.php');
    }

    $sql = "SELECT COUNT(`buildingbase_id`) AS `check`
            FROM `buildingbase`
            WHERE `buildingbase_team_id`=$auth_team_id
            AND `buildingbase_ready`=0";
    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

    if (0 != $check_array[0]['check'])
    {
        f_igosja_session_front_flash_set('error', 'Перерегистрировать нельзя: на базе идет строительство.');

        redirect('/user_re_registration.php');
    }

    $sql = "SELECT COUNT(`buildingstadium_id`) AS `check`
            FROM `buildingstadium`
            WHERE `buildingstadium_team_id`=$auth_team_id
            AND `buildingstadium_ready`=0";
    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

    if (0 != $check_array[0]['check'])
    {
        f_igosja_session_front_flash_set('error', 'Перерегистрировать нельзя: на стадионе идет строительство.');

        redirect('/user_re_registration.php');
    }

    $sql = "SELECT COUNT(`rent_id`) AS `check`
            FROM `rent`
            WHERE `rent_team_seller_id`=$auth_team_id
            AND `rent_ready`=0";
    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

    if (0 != $check_array[0]['check'])
    {
        f_igosja_session_front_flash_set('error', 'Перерегистрировать нельзя: игроки команды выставлены на аренду.');

        redirect('/user_re_registration.php');
    }

    $sql = "SELECT COUNT(`transfer_id`) AS `check`
            FROM `transfer`
            WHERE `transfer_team_seller_id`=$auth_team_id
            AND `transfer_ready`=0";
    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

    if (0 != $check_array[0]['check'])
    {
        f_igosja_session_front_flash_set('error', 'Перерегистрировать нельзя: игроки команды выставлены на продажу.');

        redirect('/user_re_registration.php');
    }

    $sql = "SELECT `player_id`
            FROM `player`
            WHERE `player_team_id`=$auth_team_id
            ORDER BY `player_id` ASC";
    $player_sql = f_igosja_mysqli_query($sql);

    $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($player_array as $item)
    {
        $player_id = $item['player_id'];

        $log = array(
            'history_historytext_id' => HISTORYTEXT_PLAYER_PENSION_SAY,
            'history_player_id' => $player_id,
            'history_team_id' => $auth_team_id,
        );
        f_igosja_history($log);

        $log = array(
            'history_historytext_id' => HISTORYTEXT_PLAYER_PENSION_GO,
            'history_player_id' => $player_id,
            'history_team_id' => $auth_team_id,
        );
        f_igosja_history($log);
    }

    $sql = "DELETE FROM `training`
            WHERE `training_team_id`=$auth_team_id
            AND `training_season_id`=$igosja_season_id";
    f_igosja_mysqli_query($sql);

    $sql = "DELETE FROM `scout`
            WHERE `scout_team_id`=$auth_team_id
            AND `scout_season_id`=$igosja_season_id";
    f_igosja_mysqli_query($sql);

    $sql = "DELETE FROM `school`
            WHERE `school_team_id`=$auth_team_id
            AND `school_season_id`=$igosja_season_id";
    f_igosja_mysqli_query($sql);

    $sql = "SELECT `player_id`
            FROM `player`
            WHERE `player_team_id`=$auth_team_id
            ORDER BY `player_id` ASC";
    $player_sql = f_igosja_mysqli_query($sql);

    $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($player_array as $item)
    {
        $player_id = $item['player_id'];

        $sql = "UPDATE `player`
                SET `player_line_id`=0,
                    `player_national_line_id`=0,
                    `player_rent_day`=0,
                    `player_rent_team_id`=0,
                    `player_team_id`=0,
                    `player_order`=0
                WHERE `player_id`=$player_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $log = array(
            'history_historytext_id' => HISTORYTEXT_PLAYER_FREE,
            'history_player_id' => $player_id,
            'history_team_id' => $auth_team_id,
        );
        f_igosja_history($log);
    }

    $sql = "DELETE FROM `phisicalchange`
            WHERE `phisicalchange_team_id`=$auth_team_id";
    f_igosja_mysqli_query($sql);

    $sql = "SELECT `team_finance`
            FROM `team`
            WHERE `team_id`=$auth_team_id
            LIMIT 1";
    $team_sql = f_igosja_mysqli_query($sql);

    $team_array = $team_sql->fetch_array(MYSQLI_ASSOC);

    $finance = array(
        'finance_financetext_id' => FINANCETEXT_TEAM_REREGISTER,
        'finance_team_id' => $auth_team_id,
        'finance_value' => BALANCE_TEAM_BASE - $team_array[0]['team_finance'],
        'finance_value_after' => BALANCE_TEAM_BASE,
        'finance_value_before' => $item['team_finance'],
    );
    f_igosja_finance($finance);

    $sql = "UPDATE `team`
            SET `team_base_id`=1,
                `team_basemedical_id`=1,
                `team_basephisical_id`=1,
                `team_baseschool_id`=1,
                `team_basescout_id`=1,
                `team_basetraining_id`=1,
                `team_finance`=" . BALANCE_TEAM_BASE . ",
                `team_free_base`=5,
                `team_mood_rest`=3,
                `team_mood_super`=3,
                `team_visitor`=100
            WHERE `team_id`=$auth_team_id
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `stadium`
            LEFT JOIN `team`
            ON `stadium_id`=`team_stadium_id`
            SET `stadium_capacity`=100,
                `stadium_maintenance`=ROUND(POW(100, 1.3))
            WHERE `team_id`=$auth_team_id";
    f_igosja_mysqli_query($sql);

    $log = array(
        'history_historytext_id' => HISTORYTEXT_TEAM_RE_REGISTER,
        'history_team_id' => $auth_team_id,
    );
    f_igosja_history($log);

    f_igosja_create_team_players($auth_team_id);

    $sql = "SELECT SUM(`player_power_nominal`) AS `power`
            FROM
            (
                SELECT `player_power_nominal`
                FROM `player`
                WHERE `player_team_id`=$auth_team_id
                AND `player_position_id`!=" . POSITION_GK . "
                ORDER BY `player_power_nominal` DESC, `player_id` ASC
                LIMIT 15
            ) AS `t1`";
    $power_sql = f_igosja_mysqli_query($sql);

    $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

    $power = $power_array[0]['power'];

    $sql = "SELECT SUM(`player_power_nominal`) AS `power`
            FROM
            (
                SELECT `player_power_nominal`
                FROM `player`
                WHERE `player_team_id`=$auth_team_id
                AND `player_position_id`=" . POSITION_GK . "
                ORDER BY `player_power_nominal` DESC, `player_id` ASC
                LIMIT 1
            ) AS `t1`";
    $power_sql = f_igosja_mysqli_query($sql);

    $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

    $power_c_16 = $power + $power_array[0]['power'];

    $sql = "SELECT SUM(`player_power_nominal`) AS `power`
            FROM
            (
                SELECT `player_power_nominal`
                FROM `player`
                WHERE `player_team_id`=$auth_team_id
                AND `player_position_id`!=" . POSITION_GK . "
                ORDER BY `player_power_nominal` DESC, `player_id` ASC
                LIMIT 20
            ) AS `t1`";
    $power_sql = f_igosja_mysqli_query($sql);

    $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

    $power = $power_array[0]['power'];

    $sql = "SELECT SUM(`player_power_nominal`) AS `power`
            FROM
            (
                SELECT `player_power_nominal`
                FROM `player`
                WHERE `player_team_id`=$auth_team_id
                AND `player_position_id`=" . POSITION_GK . "
                ORDER BY `player_power_nominal` DESC, `player_id` ASC
                LIMIT 1
            ) AS `t1`";
    $power_sql = f_igosja_mysqli_query($sql);

    $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

    $power_c_21 = $power + $power_array[0]['power'];

    $sql = "SELECT SUM(`player_power_nominal`) AS `power`
            FROM
            (
                SELECT `player_power_nominal`
                FROM `player`
                WHERE `player_team_id`=$auth_team_id
                AND `player_position_id`!=" . POSITION_GK . "
                ORDER BY `player_power_nominal` DESC, `player_id` ASC
                LIMIT 25
            ) AS `t1`";
    $power_sql = f_igosja_mysqli_query($sql);

    $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

    $power = $power_array[0]['power'];

    $sql = "SELECT SUM(`player_power_nominal`) AS `power`
            FROM
            (
                SELECT `player_power_nominal`
                FROM `player`
                WHERE `player_team_id`=$auth_team_id
                AND `player_position_id`=" . POSITION_GK . "
                ORDER BY `player_power_nominal` DESC, `player_id` ASC
                LIMIT 2
            ) AS `t1`";
    $power_sql = f_igosja_mysqli_query($sql);

    $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

    $power_c_27 = $power + $power_array[0]['power'];

    $sql = "SELECT SUM(`player_power_nominal_s`) AS `power`
            FROM
            (
                SELECT `player_power_nominal_s`
                FROM `player`
                WHERE `player_team_id`=$auth_team_id
                AND `player_position_id`!=" . POSITION_GK . "
                ORDER BY `player_power_nominal` DESC, `player_id` ASC
                LIMIT 15
            ) AS `t1`";
    $power_sql = f_igosja_mysqli_query($sql);

    $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

    $power = $power_array[0]['power'];

    $sql = "SELECT SUM(`player_power_nominal_s`) AS `power`
            FROM
            (
                SELECT `player_power_nominal_s`
                FROM `player`
                WHERE `player_team_id`=$auth_team_id
                AND `player_position_id`=" . POSITION_GK . "
                ORDER BY `player_power_nominal` DESC, `player_id` ASC
                LIMIT 1
            ) AS `t1`";
    $power_sql = f_igosja_mysqli_query($sql);

    $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

    $power_s_16 = $power + $power_array[0]['power'];

    $sql = "SELECT SUM(`player_power_nominal_s`) AS `power`
            FROM
            (
                SELECT `player_power_nominal_s`
                FROM `player`
                WHERE `player_team_id`=$auth_team_id
                AND `player_position_id`!=" . POSITION_GK . "
                ORDER BY `player_power_nominal` DESC, `player_id` ASC
                LIMIT 20
            ) AS `t1`";
    $power_sql = f_igosja_mysqli_query($sql);

    $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

    $power = $power_array[0]['power'];

    $sql = "SELECT SUM(`player_power_nominal_s`) AS `power`
            FROM
            (
                SELECT `player_power_nominal_s`
                FROM `player`
                WHERE `player_team_id`=$auth_team_id
                AND `player_position_id`=" . POSITION_GK . "
                ORDER BY `player_power_nominal` DESC, `player_id` ASC
                LIMIT 1
            ) AS `t1`";
    $power_sql = f_igosja_mysqli_query($sql);

    $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

    $power_s_21 = $power + $power_array[0]['power'];

    $sql = "SELECT SUM(`player_power_nominal_s`) AS `power`
            FROM
            (
                SELECT `player_power_nominal_s`
                FROM `player`
                WHERE `player_team_id`=$auth_team_id
                AND `player_position_id`!=" . POSITION_GK . "
                ORDER BY `player_power_nominal` DESC, `player_id` ASC
                LIMIT 25
            ) AS `t1`";
    $power_sql = f_igosja_mysqli_query($sql);

    $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

    $power = $power_array[0]['power'];

    $sql = "SELECT SUM(`player_power_nominal_s`) AS `power`
            FROM
            (
                SELECT `player_power_nominal_s`
                FROM `player`
                WHERE `player_team_id`=$auth_team_id
                AND `player_position_id`=" . POSITION_GK . "
                ORDER BY `player_power_nominal` DESC, `player_id` ASC
                LIMIT 2
            ) AS `t1`";
    $power_sql = f_igosja_mysqli_query($sql);

    $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

    $power_s_27 = $power + $power_array[0]['power'];

    $power_v    = round(($power_c_16 + $power_c_21 + $power_c_27) / 64 * 16);
    $power_vs   = round(($power_s_16 + $power_s_21 + $power_s_27) / 64 * 16);

    $sql = "UPDATE `team`
            SET `team_power_c_16`=$power_c_16,
                `team_power_c_21`=$power_c_21,
                `team_power_c_27`=$power_c_27,
                `team_power_s_16`=$power_s_16,
                `team_power_s_21`=$power_s_21,
                `team_power_s_27`=$power_s_27,
                `team_power_v`=$power_v,
                `team_power_vs`=$power_vs
            WHERE `team_id`=$auth_team_id
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    f_igosja_session_front_flash_set('success', 'Изменения успшено сохранены.');

    redirect('/team_view.php');
}

$seo_title          = $user_array[0]['user_login'] . '. Преререгистрация команды';
$seo_description    = $user_array[0]['user_login'] . '. Преререгистрация команды на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $user_array[0]['user_login'] . ' преререгистрация команды';

include(__DIR__ . '/view/layout/main.php');