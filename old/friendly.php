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

$selected_game = false;

if (!$num_get = (int) f_igosja_request_get('num'))
{
    $sql = "SELECT `schedule_date`,
                   `schedule_id`
            FROM `schedule`
            WHERE `schedule_date`>UNIX_TIMESTAMP()
            AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_FRIENDLY . "
            ORDER BY `schedule_date` ASC
            LIMIT 1";
    $schedule_sql = f_igosja_mysqli_query($sql);

    if (0 == $schedule_sql->num_rows)
    {
        $num_get = 0;
    }
    else
    {
        $schedule_array = $schedule_sql->fetch_all(MYSQLI_ASSOC);

        $num_get        = $schedule_array[0]['schedule_id'];
        $selected_date  = $schedule_array[0]['schedule_date'];
    }
}
else
{
    $sql = "SELECT `schedule_date`
            FROM `schedule`
            WHERE `schedule_id`=$num_get
            AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_FRIENDLY . "
            AND `schedule_date`>UNIX_TIMESTAMP()
            LIMIT 1";
    $schedule_sql = f_igosja_mysqli_query($sql);

    if (0 == $schedule_sql->num_rows)
    {
        redirect('/wrong_page.php');
    }

    $schedule_array = $schedule_sql->fetch_all(MYSQLI_ASSOC);

    $selected_date = $schedule_array[0]['schedule_date'];
}

if ($team_get = (int) f_igosja_request_get('team_id'))
{
    $sql = "SELECT COUNT(`team_id`) AS `count`
            FROM `team`
            LEFT JOIN `user`
            ON `team_user_id`=`user_id`
            WHERE `team_id`=$team_get
            AND `user_friendlystatus_id` IN (" . FRIENDLY_STATUS_ALL . ", " . FRIENDLY_STATUS_CHOOSE . ")
            AND `team_id`!=$auth_team_id
            AND `team_user_id`!=$auth_user_id
            AND `team_user_id`!=0";
    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

    if (0 == $check_array[0]['count'])
    {
        f_igosja_session_front_flash_set('error', 'Команда выбрана неправильно.');

        redirect('/friendly.php?num=' . $num_get);
    }

    $sql = "SELECT COUNT(`game_id`) AS `count`
            FROM `game`
            WHERE `game_schedule_id`=$num_get
            AND (`game_home_team_id`=$team_get
            OR `game_guest_team_id`=$team_get)";
    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

    if ($check_array[0]['count'])
    {
        f_igosja_session_front_flash_set('error', 'Эта команда уже организовала товарищеский матч.');

        redirect('/friendly.php?num=' . $num_get);
    }

    $sql = "SELECT COUNT(`game_id`) AS `count`
            FROM `game`
            WHERE `game_schedule_id`=$num_get
            AND (`game_home_team_id`=$auth_team_id
            OR `game_guest_team_id`=$auth_team_id)";
    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

    if ($check_array[0]['count'])
    {
        f_igosja_session_front_flash_set('error', 'Вы уже играете матч в этот игровой день.');

        redirect('/friendly.php?num=' . $num_get);
    }

    $sql = "SELECT COUNT(`game_id`) AS `count`
            FROM `game`
            LEFT JOIN `schedule`
            ON `game_schedule_id`=`schedule_id`
            WHERE ((`game_home_team_id`=$auth_team_id
            AND `game_guest_team_id`=$team_get)
            OR (`game_home_team_id`=$team_get
            AND `game_guest_team_id`=$auth_team_id))
            AND `schedule_season_id`=$igosja_season_id
            AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_FRIENDLY;
    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

    if ($check_array[0]['count'])
    {
        f_igosja_session_front_flash_set('error', 'Вы уже играли товарищеский матч с этой командой в этом сезоне.');

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

    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

    if (FRIENDLY_STATUS_ALL == $team_array[0]['user_friendlystatus_id'])
    {
        $sql = "SELECT `team_stadium_id`
                FROM `team`
                WHERE `team_id`=$auth_team_id
                LIMIT 1";
        $stadium_sql = f_igosja_mysqli_query($sql);

        $stadium_array = $stadium_sql->fetch_all(MYSQLI_ASSOC);

        $stadium_id             = $stadium_array[0]['team_stadium_id'];
        $user_friendlystatus_id = $team_array[0]['user_friendlystatus_id'];
        $user_id                = $team_array[0]['user_id'];

        $sql = "INSERT INTO `friendlyinvite`
                SET `friendlyinvite_date`=UNIX_TIMESTAMP(),
                    `friendlyinvite_friendlystatus_id`=$user_friendlystatus_id,
                    `friendlyinvite_guest_team_id`=$team_get,
                    `friendlyinvite_guest_user_id`=$user_id,
                    `friendlyinvite_home_team_id`=$auth_team_id,
                    `friendlyinvite_home_user_id`=$auth_user_id,
                    `friendlyinvite_schedule_id`=$num_get,
                    `friendlyinvite_friendlyinvitestatus_id`=" . FRIENDLY_INVITE_STATUS_APPROVE;
        f_igosja_mysqli_query($sql);

        $sql = "INSERT INTO `game`
                SET `game_bonus_home`=0,
                    `game_guest_team_id`=$team_get,
                    `game_home_team_id`=$auth_team_id,
                    `game_schedule_id`=$num_get,
                    `game_stadium_id`=$stadium_id";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `friendlyinvite`
                SET `friendlyinvite_friendlyinvitestatus_id`=" . FRIENDLY_INVITE_STATUS_REJECT . "
                WHERE `friendlyinvite_friendlyinvitestatus_id`!=" . FRIENDLY_INVITE_STATUS_APPROVE . "
                AND `friendlyinvite_schedule_id`=$num_get
                AND (`friendlyinvite_home_team_id`=$auth_team_id
                OR `friendlyinvite_guest_team_id`=$auth_team_id)";
        f_igosja_mysqli_query($sql);

        f_igosja_session_front_flash_set('success', 'Игра успешно организована.');

        redirect('/friendly.php?num=' . $num_get);
    }
    else
    {
        $sql = "SELECT COUNT(`friendlyinvite_id`) AS `count`
                FROM `friendlyinvite`
                WHERE `friendlyinvite_home_team_id`=$auth_team_id
                AND `friendlyinvite_schedule_id`=$num_get
                AND `friendlyinvite_friendlyinvitestatus_id`=" . FRIENDLY_INVITE_STATUS_NEW;
        $check_sql = f_igosja_mysqli_query($sql);

        $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

        if ($check_array[0]['count'] >= 5)
        {
            f_igosja_session_front_flash_set('error', 'На один игровой день можно отправить не более 5 предложений.');

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
                    `friendlyinvite_schedule_id`=$num_get";
        f_igosja_mysqli_query($sql);

        f_igosja_session_front_flash_set('success', 'Приглашение успешно отправлено.');

        redirect('/friendly.php?num=' . $num_get);
    }
}

if (($friendlyinvite_id = (int) f_igosja_request_get('friendlyinvite_id')) && ($friendlyinivitestatus_id = (int) f_igosja_request_get('friendlyinivitestatus_id')))
{
    $sql = "SELECT COUNT(`friendlyinvite_id`) AS `count`
            FROM `friendlyinvite`
            WHERE `friendlyinvite_id`=$friendlyinvite_id
            AND (`friendlyinvite_guest_team_id`=$auth_team_id
            OR `friendlyinvite_home_team_id`=$auth_team_id)
            AND `friendlyinvite_friendlyinvitestatus_id`=" . FRIENDLY_INVITE_STATUS_NEW;
    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

    if (0 == $check_array[0]['count'])
    {
        f_igosja_session_front_flash_set('error', 'Приглашение выбрано неправильно.');

        redirect('/friendly.php?num=' . $num_get);
    }

    if (!in_array($friendlyinivitestatus_id, array(FRIENDLY_INVITE_STATUS_APPROVE, FRIENDLY_INVITE_STATUS_REJECT, FRIENDLY_INVITE_STATUS_DELETE)))
    {
        f_igosja_session_front_flash_set('error', 'Действие выбрано неправильно.');

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

        f_igosja_session_front_flash_set('success', 'Приглашение успешно отклонено.');

        redirect('/friendly.php?num=' . $num_get);
    }
    elseif (FRIENDLY_INVITE_STATUS_DELETE == $friendlyinivitestatus_id)
    {
        $sql = "DELETE FROM `friendlyinvite`
                WHERE `friendlyinvite_home_user_id`=$auth_user_id
                AND `friendlyinvite_id`=$friendlyinvite_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        f_igosja_session_front_flash_set('success', 'Приглашение успешно удалено.');

        redirect('/friendly.php?num=' . $num_get);
    }
    else
    {
        $sql = "SELECT `friendlyinvite_home_team_id`
                FROM `friendlyinvite`
                WHERE `friendlyinvite_id`=$friendlyinvite_id
                LIMIT 1";
        $check_sql = f_igosja_mysqli_query($sql);

        $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

        $team_get = $check_array[0]['friendlyinvite_home_team_id'];

        $sql = "SELECT COUNT(`game_id`) AS `count`
                FROM `game`
                WHERE `game_schedule_id`=$num_get
                AND (`game_home_team_id`=$team_get
                OR `game_guest_team_id`=$team_get)";
        $check_sql = f_igosja_mysqli_query($sql);

        $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

        if ($check_array[0]['count'])
        {
            f_igosja_session_front_flash_set('error', 'Эта команда уже организовала товарищеский матч.');

            redirect('/friendly.php?num=' . $num_get);
        }

        $sql = "SELECT COUNT(`game_id`) AS `count`
                FROM `game`
                WHERE `game_schedule_id`=$num_get
                AND (`game_home_team_id`=$auth_team_id
                OR `game_guest_team_id`=$auth_team_id)";
        $check_sql = f_igosja_mysqli_query($sql);

        $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

        if ($check_array[0]['count'])
        {
            f_igosja_session_front_flash_set('error', 'Вы уже играете матч в этот игровой день.');

            redirect('/friendly.php?num=' . $num_get);
        }

        $sql = "SELECT COUNT(`game_id`) AS `count`
                FROM `game`
                LEFT JOIN `schedule`
                ON `game_schedule_id`=`schedule_id`
                WHERE ((`game_home_team_id`=$auth_team_id
                AND `game_guest_team_id`=$team_get)
                OR (`game_home_team_id`=$team_get
                AND `game_guest_team_id`=$auth_team_id))
                AND `schedule_season_id`=$igosja_season_id
                AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_FRIENDLY;
        $check_sql = f_igosja_mysqli_query($sql);

        $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

        if ($check_array[0]['count'])
        {
            f_igosja_session_front_flash_set('error', 'Вы уже играли товарищеский матч с этой командой в этом сезоне.');

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

        $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

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
                SET `game_bonus_home`=0,
                    `game_guest_team_id`=$auth_team_id,
                    `game_home_team_id`=$team_get,
                    `game_schedule_id`=$num_get,
                    `game_stadium_id`=$stadium_id";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `friendlyinvite`
                SET `friendlyinvite_friendlyinvitestatus_id`=" . FRIENDLY_INVITE_STATUS_REJECT . "
                WHERE `friendlyinvite_friendlyinvitestatus_id`!=" . FRIENDLY_INVITE_STATUS_APPROVE . "
                AND `friendlyinvite_schedule_id`=$num_get
                AND (`friendlyinvite_home_team_id`=$auth_team_id
                OR `friendlyinvite_guest_team_id`=$auth_team_id)";
        f_igosja_mysqli_query($sql);

        f_igosja_session_front_flash_set('success', 'Игра успешно организована.');

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

$myteam_array = $myteam_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `schedule_date`,
               `schedule_id`
        FROM `schedule`
        WHERE `schedule_date`>UNIX_TIMESTAMP()
        AND `schedule_date`<UNIX_TIMESTAMP()+1209600
        AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_FRIENDLY . "
        ORDER BY `schedule_date` ASC";
$schedule_sql = f_igosja_mysqli_query($sql);

$count_schedule = $schedule_sql->num_rows;
$schedule_array = $schedule_sql->fetch_all(MYSQLI_ASSOC);

for ($i=0; $i<$count_schedule; $i++)
{
    $schedule_id = $schedule_array[$i]['schedule_id'];

    $sql = "SELECT `city_id`,
                   `city_name`,
                   `country_id`,
                   `country_name`,
                   `team_id`,
                   `team_name`
            FROM `game`
            LEFT JOIN `team`
            ON IF(`game_home_team_id`=$auth_team_id, `game_guest_team_id`, `game_home_team_id`)=`team_id`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`city_id`
            LEFT JOIN `country`
            ON `city_country_id`=`country_id`
            WHERE `game_schedule_id`=$schedule_id
            AND (`game_home_team_id`=$auth_team_id
            OR `game_guest_team_id`=$auth_team_id)";
    $check_game_sql = f_igosja_mysqli_query($sql);

    if ($check_game_sql->num_rows)
    {
        $check_game_array = $check_game_sql->fetch_all(MYSQLI_ASSOC);

        $schedule_array[$i]['text'] =
            'Играем с
             <img
                 alt="'. $check_game_array[0]['country_name'] . '"
                 src="/img/country/12/'. $check_game_array[0]['country_id'] . '.png"
                 title="'. $check_game_array[0]['country_name'] . '"
             />
             <a href="/team_view.php?num='. $check_game_array[0]['team_id'] . '">
                 '. $check_game_array[0]['team_name'] . ' ('. $check_game_array[0]['city_name'] . ')
             </a>';

        if ($num_get == $schedule_id)
        {
            $selected_game = true;
        }
    }
    else
    {
        $sql = "SELECT COUNT(`friendlyinvite_id`) AS `count`
                FROM `friendlyinvite`
                WHERE `friendlyinvite_schedule_id`=$schedule_id
                AND `friendlyinvite_guest_team_id`=$auth_team_id
                AND `friendlyinvite_friendlyinvitestatus_id`=" . FRIENDLY_INVITE_STATUS_NEW;
        $check_recieve_sql = f_igosja_mysqli_query($sql);

        $check_recieve_array = $check_recieve_sql->fetch_all(MYSQLI_ASSOC);

        if ($check_recieve_array[0]['count'])
        {
            $schedule_array[$i]['text'] = 'У вас ' . $check_recieve_array[0]['count'] . ' неотвеченных ' . f_igosja_count_case($check_recieve_array[0]['count'], 'приглашение', 'приглашения', 'приглашений');
        }
    }

    if (!isset($schedule_array[$i]['text']))
    {
        $schedule_array[$i]['text'] = 'Нет приглашений';
    }
}

$sql = "SELECT COUNT(`friendlyinvite_id`) AS `count`
        FROM `friendlyinvite`
        WHERE `friendlyinvite_schedule_id`=$num_get
        AND `friendlyinvite_guest_team_id`=$auth_team_id
        AND `friendlyinvite_friendlyinvitestatus_id`=" . FRIENDLY_INVITE_STATUS_APPROVE;
$check_recieve_sql = f_igosja_mysqli_query($sql);

$check_recieve_array = $check_recieve_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `city_id`,
               `city_name`,
               `country_id`,
               `country_name`,
               `friendlyinvite_id`,
               `friendlyinvitestatus_id`,
               `friendlyinvitestatus_name`,
               `stadium_capacity`,
               `team_id`,
               `team_name`,
               `team_power_vs`,
               `team_visitor`,
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
        LEFT JOIN `friendlyinvitestatus`
        ON `friendlyinvite_friendlyinvitestatus_id`=`friendlyinvitestatus_id`
        WHERE `friendlyinvite_schedule_id`=$num_get
        AND `friendlyinvite_guest_team_id`=$auth_team_id
        ORDER BY `friendlyinvite_id` ASC";
$invite_recieve_sql = f_igosja_mysqli_query($sql);

$invite_recieve_array = $invite_recieve_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `city_id`,
               `city_name`,
               `country_id`,
               `country_name`,
               `friendlyinvite_id`,
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
        WHERE `friendlyinvite_schedule_id`=$num_get
        AND `friendlyinvite_home_team_id`=$auth_team_id
        ORDER BY `friendlyinvite_id` ASC";
$invite_send_sql = f_igosja_mysqli_query($sql);

$invite_send_array = $invite_send_sql->fetch_all(MYSQLI_ASSOC);

if (!$selected_game)
{
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
            AND `user_id`!=$auth_user_id
            AND `team_id`!=$auth_team_id
            AND `team_id` NOT IN
            (
                SELECT `friendlyinvite_guest_team_id`
                FROM `friendlyinvite`
                WHERE `friendlyinvite_home_team_id`=$auth_team_id
                AND `friendlyinvite_schedule_id`=$num_get
                AND `friendlyinvite_friendlyinvitestatus_id`=" . FRIENDLY_INVITE_STATUS_NEW . "
            )
            AND `team_id` NOT IN
            (
                SELECT IF(`game_home_team_id`=$auth_team_id, `game_guest_team_id`, `game_home_team_id`)
                FROM `game`
                LEFT JOIN `schedule`
                ON `game_schedule_id`=`schedule_id`
                WHERE (`game_home_team_id`=$auth_team_id
                OR `game_guest_team_id`=$auth_team_id)
                AND `schedule_season_id`=$igosja_season_id
                AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_FRIENDLY . "
            )
            AND `team_id` NOT IN
            (
                SELECT `game_home_team_id`
                FROM `game`
                LEFT JOIN `schedule`
                ON `game_schedule_id`=`schedule_id`
                WHERE `schedule_id`=$num_get
            )
            AND `team_id` NOT IN
            (
                SELECT `game_guest_team_id`
                FROM `game`
                LEFT JOIN `schedule`
                ON `game_schedule_id`=`schedule_id`
                WHERE `schedule_id`=$num_get
            )
            ORDER BY `team_power_vs` DESC";
    $team_sql = f_igosja_mysqli_query($sql);

    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);
}
else
{
    $team_array = array();
}

$seo_title          = 'Организация товарищеских матчей';
$seo_description    = 'Организация товарищеских матчей на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'организация товарищеских матчей';

include(__DIR__ . '/view/layout/main.php');