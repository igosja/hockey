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
    redirect('/wrong_page.php');
}

if (!$num_get = (int) f_igosja_request_get('num'))
{
    $sql = "SELECT `shedule_date`,
                   `shedule_id`
            FROM `shedule`
            WHERE `shedule_date`>UNIX_TIMESTAMP()
            AND `shedule_tournamenttype_id`=" . TOURNAMENTTYPE_FRIENDLY . "
            ORDER BY `shedule_date` ASC
            LIMIT 1";
    $shedule_sql = f_igosja_mysqli_query($sql);

    if (0 == $shedule_sql->num_rows)
    {
        $num_get = 0;
    }
    else
    {
        $shedule_array = $shedule_sql->fetch_all(1);

        $num_get        = $shedule_array[0]['shedule_id'];
        $selected_date  = $shedule_array[0]['shedule_date'];
    }
}
else
{
    $sql = "SELECT `shedule_date`
            FROM `shedule`
            WHERE `shedule_id`=$num_get
            LIMIT 1";
    $shedule_sql = f_igosja_mysqli_query($sql);

    $shedule_array = $shedule_sql->fetch_all(1);

    $selected_date = $shedule_array[0]['shedule_date'];
}

if ($team_get = (int) f_igosja_request_get('team_id'))
{
    $sql = "SELECT COUNT(`team_id`) AS `count`
            FROM `team`
            LEFT JOIN `user`
            ON `team_user_id`=`user_id`
            WHERE `team_id`=$team_get
            AND `user_friendlystatus_id` IN (" . FRIENDLY_STATUS_ALL . ", " . FRIENDLY_STATUS_CHOOSE . ")";
    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(1);

    if (0 == $check_array[0]['count'])
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Команда выбрана неправильно.';

        redirect('/friendly.php?num=' . $num_get);
    }

    $sql = "SELECT COUNT(`game_id`) AS `count`
            FROM `game`
            WHERE `game_shedule_id`=$num_get
            AND (`game_home_team_id`=$team_get
            OR `game_guest_team_id`=$team_get)";
    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(1);

    if ($check_array[0]['count'])
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Эта команда уже организовала товарищеский матч.';

        redirect('/friendly.php?num=' . $num_get);
    }

    $sql = "SELECT COUNT(`game_id`) AS `count`
            FROM `game`
            WHERE `game_shedule_id`=$num_get
            AND (`game_home_team_id`=$auth_team_id
            OR `game_guest_team_id`=$auth_team_id)";
    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(1);

    if ($check_array[0]['count'])
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Вы уже играете матч в этот игровой день.';

        redirect('/friendly.php?num=' . $num_get);
    }

    $sql = "SELECT COUNT(`game_id`) AS `count`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            WHERE ((`game_home_team_id`=$auth_team_id
            AND `game_guest_team_id`=$team_get)
            OR (`game_home_team_id`=$team_get
            AND `game_guest_team_id`=$auth_team_id))
            AND `shedule_season_id`=$igosja_season_id
            AND `shedule_tournamenttype_id`=" . TOURNAMENTTYPE_FRIENDLY;
    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(1);

    if ($check_array[0]['count'])
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Вы уже играли товарищеский матч с этой командой в этом сезоне.';

        redirect('/friendly.php?num=' . $num_get);
    }

    $sql = "SELECT `stadium_id`,
                   `user_friendlystatus_id`,
                   `user_id`
            FROM `team`
            LEFT JOIN `user`
            ON `team_user_id`=`user_id`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            WHERE `team_id`=$team_get
            LIMIT 1";
    $team_sql = f_igosja_mysqli_query($sql);

    $team_array = $team_sql->fetch_all(1);

    if (FRIENDLY_STATUS_ALL == $team_array[0]['user_friendlystatus_id'])
    {
        $stadium_id             = $team_array[0]['stadium_id'];
        $user_friendlystatus_id = $team_array[0]['user_friendlystatus_id'];
        $user_id                = $team_array[0]['user_id'];

        $sql = "INSERT INTO `friendlyinvite`
                SET `friendlyinvite_date`=UNIX_TIMESTAMP(),
                    `friendlyinvite_friendlystatus_id`=$user_friendlystatus_id,
                    `friendlyinvite_guest_team_id`=$team_get,
                    `friendlyinvite_guest_user_id`=$user_id,
                    `friendlyinvite_home_team_id`=$auth_team_id,
                    `friendlyinvite_home_user_id`=$auth_user_id,
                    `friendlyinvite_shedule_id`=$num_get,
                    `friendlyinvite_friendlyinvitestatus_id`=" . FRIENDLY_INVITE_STATUS_APPROVE;
        f_igosja_mysqli_query($sql);

        $sql = "INSERT INTO `game`
                SET `game_guest_team_id`=$team_get,
                    `game_home_team_id`=$auth_team_id,
                    `game_shedule_id`=$num_get,
                    `game_stadium_id`=$stadium_id";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `friendlyinvite`
                SET `friendlyinvite_friendlyinvitestatus_id`=" . FRIENDLY_INVITE_STATUS_REJECT . "
                WHERE `friendlyinvite_friendlyinvitestatus_id`!=" . FRIENDLY_INVITE_STATUS_APPROVE . "
                AND `friendlyinvite_shedule_id`=$num_get
                AND (`friendlyinvite_home_team_id`=$auth_team_id
                OR `friendlyinvite_guest_team_id`=$auth_team_id)";
        f_igosja_mysqli_query($sql);

        $_SESSION['message']['class']   = 'success';
        $_SESSION['message']['text']    = 'Игра успешно организована.';

        redirect('/friendly.php?num=' . $num_get);
    }
    else
    {
        $sql = "SELECT COUNT(`friendlyinvite_id`) AS `count`
                FROM `friendlyinvite`
                WHERE `friendlyinvite_home_team_id`=$auth_team_id
                AND `friendlyinvite_shedule_id`=$num_get
                AND `friendlyinvite_friendlyinvitestatus_id`=" . FRIENDLY_INVITE_STATUS_NEW;
        $check_sql = f_igosja_mysqli_query($sql);

        $check_array = $check_sql->fetch_all(1);

        if ($check_array[0]['count'] >= 5)
        {
            $_SESSION['message']['class']   = 'error';
            $_SESSION['message']['text']    = 'На один игровой день можно отправить не более 5 предложений.';

            redirect('/friendly.php?num=' . $num_get);
        }

        $user_friendlystatus_id = $team_array[0]['user_friendlystatus_id'];
        $user_id                = $team_array[0]['user_id'];

        $sql = "INSERT INTO `friendlyinvite`
                SET `friendlyinvite_date`=UNIX_TIMESTAMP(),
                    `friendlyinvite_friendlystatus_id`=$user_friendlystatus_id,
                    `friendlyinvite_guest_team_id`=$team_get,
                    `friendlyinvite_guest_user_id`=$user_id,
                    `friendlyinvite_home_team_id`=$auth_team_id,
                    `friendlyinvite_home_user_id`=$auth_user_id,
                    `friendlyinvite_shedule_id`=$num_get";
        f_igosja_mysqli_query($sql);

        $_SESSION['message']['class']   = 'success';
        $_SESSION['message']['text']    = 'Приглашение успешно отправлено.';

        redirect('/friendly.php?num=' . $num_get);
    }
}

if (($friendlyinvite_id = (int) f_igosja_request_get('friendlyinvite_id')) && ($friendlyinivitestatus_id = (int) f_igosja_request_get('friendlyinivitestatus_id')))
{
    $sql = "SELECT COUNT(`friendlyinvite_id`) AS `count`
            FROM `friendlyinvite`
            WHERE `friendlyinvite_id`=$friendlyinvite_id
            AND `friendlyinvite_guest_team_id`=$auth_team_id
            AND `friendlyinvite_friendlyinvitestatus_id`=" . FRIENDLY_INVITE_STATUS_NEW;
    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(1);

    if (0 == $check_array[0]['count'])
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Приглашение выбрано неправильно.';

        redirect('/friendly.php?num=' . $num_get);
    }

    if (!in_array($friendlyinivitestatus_id, array(FRIENDLY_INVITE_STATUS_APPROVE, FRIENDLY_INVITE_STATUS_REJECT)))
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Действие выбрано неправильно.';

        redirect('/friendly.php?num=' . $num_get);
    }

    if (FRIENDLY_INVITE_STATUS_REJECT == $friendlyinivitestatus_id)
    {
        $sql = "UPDATE `friendlyinvite`
                SET `friendlyinvite_friendlyinvitestatus_id`=$friendlyinivitestatus_id,
                    `friendlyinvite_guest_user_id`=$auth_user_id
                WHERE `friendlyinvite_id`=$friendlyinvite_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $_SESSION['message']['class']   = 'success';
        $_SESSION['message']['text']    = 'Приглашение успешно отклонено.';

        redirect('/friendly.php?num=' . $num_get);
    }
    else
    {
        $sql = "SELECT `friendlyinvite_home_team_id`
                FROM `friendlyinvite`
                WHERE `friendlyinvite_id`=$friendlyinvite_id
                LIMIT 1";
        $check_sql = f_igosja_mysqli_query($sql);

        $check_array = $check_sql->fetch_all(1);

        $team_get = $check_array[0]['friendlyinvite_home_team_id'];

        $sql = "SELECT COUNT(`game_id`) AS `count`
                FROM `game`
                WHERE `game_shedule_id`=$num_get
                AND (`game_home_team_id`=$team_get
                OR `game_guest_team_id`=$team_get)";
        $check_sql = f_igosja_mysqli_query($sql);

        $check_array = $check_sql->fetch_all(1);

        if ($check_array[0]['count'])
        {
            $_SESSION['message']['class']   = 'error';
            $_SESSION['message']['text']    = 'Эта команда уже организовала товарищеский матч.';

            redirect('/friendly.php?num=' . $num_get);
        }

        $sql = "SELECT COUNT(`game_id`) AS `count`
                FROM `game`
                WHERE `game_shedule_id`=$num_get
                AND (`game_home_team_id`=$auth_team_id
                OR `game_guest_team_id`=$auth_team_id)";
        $check_sql = f_igosja_mysqli_query($sql);

        $check_array = $check_sql->fetch_all(1);

        if ($check_array[0]['count'])
        {
            $_SESSION['message']['class']   = 'error';
            $_SESSION['message']['text']    = 'Вы уже играете матч в этот игровой день.';

            redirect('/friendly.php?num=' . $num_get);
        }

        $sql = "SELECT COUNT(`game_id`) AS `count`
                FROM `game`
                LEFT JOIN `shedule`
                ON `game_shedule_id`=`shedule_id`
                WHERE ((`game_home_team_id`=$auth_team_id
                AND `game_guest_team_id`=$team_get)
                OR (`game_home_team_id`=$team_get
                AND `game_guest_team_id`=$auth_team_id))
                AND `shedule_season_id`=$igosja_season_id
                AND `shedule_tournamenttype_id`=" . TOURNAMENTTYPE_FRIENDLY;
        $check_sql = f_igosja_mysqli_query($sql);

        $check_array = $check_sql->fetch_all(1);

        if ($check_array[0]['count'])
        {
            $_SESSION['message']['class']   = 'error';
            $_SESSION['message']['text']    = 'Вы уже играли товарищеский матч с этой командой в этом сезоне.';

            redirect('/friendly.php?num=' . $num_get);
        }

        $sql = "SELECT `stadium_id`,
                       `user_friendlystatus_id`,
                       `user_id`
                FROM `team`
                LEFT JOIN `user`
                ON `team_user_id`=`user_id`
                LEFT JOIN `stadium`
                ON `team_stadium_id`=`stadium_id`
                WHERE `team_id`=$team_get
                LIMIT 1";
        $team_sql = f_igosja_mysqli_query($sql);

        $team_array = $team_sql->fetch_all(1);

        $stadium_id             = $team_array[0]['stadium_id'];
        $user_friendlystatus_id = $team_array[0]['user_friendlystatus_id'];
        $user_id                = $team_array[0]['user_id'];

        $sql = "UPDATE `friendlyinvite`
                SET `friendlyinvite_friendlyinvitestatus_id`=$friendlyinivitestatus_id,
                    `friendlyinvite_guest_user_id`=$auth_user_id
                WHERE `friendlyinvite_id`=$friendlyinvite_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "INSERT INTO `game`
                SET `game_guest_team_id`=$auth_team_id,
                    `game_home_team_id`=$team_get,
                    `game_shedule_id`=$num_get,
                    `game_stadium_id`=$stadium_id";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `friendlyinvite`
                SET `friendlyinvite_friendlyinvitestatus_id`=" . FRIENDLY_INVITE_STATUS_REJECT . "
                WHERE `friendlyinvite_friendlyinvitestatus_id`!=" . FRIENDLY_INVITE_STATUS_APPROVE . "
                AND `friendlyinvite_shedule_id`=$num_get
                AND (`friendlyinvite_home_team_id`=$auth_team_id
                OR `friendlyinvite_guest_team_id`=$auth_team_id)";
        f_igosja_mysqli_query($sql);

        $_SESSION['message']['class']   = 'success';
        $_SESSION['message']['text']    = 'Игра успешно организована.';

        redirect('/friendly.php?num=' . $num_get);
    }
}

$sql = "SELECT `city_name`,
               `country_name`,
               `friendlystatus_name`,
               `team_name`,
               `team_power_vs`
        FROM `team`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        LEFT JOIN `user`
        ON `team_user_id`=`user_id`
        LEFT JOIN `friendlystatus`
        ON `user_friendlystatus_id`=`friendlystatus_id`
        WHERE `team_id`=$auth_team_id
        LIMIT 1";
$myteam_sql = f_igosja_mysqli_query($sql);

$myteam_array = $myteam_sql->fetch_all(1);

$sql = "SELECT `shedule_date`,
               `shedule_id`
        FROM `shedule`
        WHERE `shedule_date`>UNIX_TIMESTAMP()
        AND `shedule_date`<UNIX_TIMESTAMP()+1209600
        AND `shedule_tournamenttype_id`=" . TOURNAMENTTYPE_FRIENDLY . "
        ORDER BY `shedule_date` ASC";
$shedule_sql = f_igosja_mysqli_query($sql);

$shedule_array = $shedule_sql->fetch_all(1);

$sql = "SELECT `city_id`,
               `city_name`,
               `country_id`,
               `country_name`,
               `friendlyinvite_friendlyinvitestatus_id`,
               `friendlyinvite_id`,
               `stadium_capacity`,
               `team_id`,
               `team_name`,
               `team_power_vs`,
               `team_visitor`,
               `user_friendlystatus_id`,
               `user_id`,
               `user_login`
        FROM `friendlyinvite`
        LEFT JOIN `team`
        ON `friendlyinvite_home_team_id`=`team_id`
        LEFT JOIN `user`
        ON `team_user_id`=`user_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `friendlyinvite_shedule_id`=$num_get
        AND `friendlyinvite_guest_team_id`=$auth_team_id
        ORDER BY `friendlyinvite_id` ASC";
$invite_recieve_sql = f_igosja_mysqli_query($sql);

$invite_recieve_array = $invite_recieve_sql->fetch_all(1);

$sql = "SELECT `city_id`,
               `city_name`,
               `country_id`,
               `country_name`,
               `friendlyinvitestatus_name`,
               `team_id`,
               `team_name`
        FROM `friendlyinvite`
        LEFT JOIN `team`
        ON `friendlyinvite_guest_team_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        LEFT JOIN `friendlyinvitestatus`
        ON `friendlyinvite_friendlyinvitestatus_id`=`friendlyinvitestatus_id`
        WHERE `friendlyinvite_shedule_id`=$num_get
        AND `friendlyinvite_home_team_id`=$auth_team_id
        ORDER BY `friendlyinvite_id` ASC";
$invite_send_sql = f_igosja_mysqli_query($sql);

$invite_send_array = $invite_send_sql->fetch_all(1);

$sql = "SELECT `city_id`,
               `city_name`,
               `country_id`,
               `country_name`,
               `stadium_capacity`,
               `team_id`,
               `team_name`,
               `team_power_vs`,
               `team_visitor`,
               `user_friendlystatus_id`,
               `user_id`,
               `user_login`
        FROM `team`
        LEFT JOIN `user`
        ON `team_user_id`=`user_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `user_friendlystatus_id`!=" . FRIENDLY_STATUS_NONE . "
        AND `user_id`!=0
        AND `team_id`!=$auth_team_id
        AND `team_id` NOT IN
        (
            SELECT `friendlyinvite_guest_team_id`
            FROM `friendlyinvite`
            WHERE `friendlyinvite_home_team_id`=$auth_team_id
            AND `friendlyinvite_shedule_id`=$num_get
            AND `friendlyinvite_friendlyinvitestatus_id`=" . FRIENDLY_INVITE_STATUS_NEW . "
        )
        AND `team_id` NOT IN
        (
            SELECT IF(`game_home_team_id`=$auth_team_id, `game_guest_team_id`, `game_home_team_id`)
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            WHERE (`game_home_team_id`=$auth_team_id
            OR `game_guest_team_id`=$auth_team_id)
            AND `shedule_season_id`=$igosja_season_id
            AND `shedule_tournamenttype_id`=" . TOURNAMENTTYPE_FRIENDLY . "
        )
        ORDER BY `team_power_vs` DESC";
$team_sql = f_igosja_mysqli_query($sql);

$team_array = $team_sql->fetch_all(1);

include(__DIR__ . '/view/layout/main.php');