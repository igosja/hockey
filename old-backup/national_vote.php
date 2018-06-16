<?php

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

if (!$type_get = (int) f_igosja_request_get('type'))
{
    redirect('/wrong_page.php');
}

include(__DIR__ . '/include/sql/country_view.php');

$sql = "SELECT `electionnational_id`
        FROM `electionnational`
        WHERE `electionnational_country_id`=$num_get
        AND `electionnational_electionstatus_id`=" . ELECTIONSTATUS_OPEN . "
        AND `electionnational_nationaltype_id`=$type_get
        ORDER BY `electionnational_id` DESC
        LIMIT 1";
$electionnational_sql = f_igosja_mysqli_query($sql);

if (0 == $electionnational_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$electionnational_array = $electionnational_sql->fetch_all(MYSQLI_ASSOC);

$electionnational_id = $electionnational_array[0]['electionnational_id'];

$sql = "SELECT `electionnational_id`,
               `electionnationalapplication_count`,
               `electionnationalapplication_id`,
               `electionnationalapplication_text`,
               `electionstatus_id`,
               `electionstatus_name`,
               `electionnationalapplication_power`,
               `user_date_register`,
               `user_id`,
               `user_login`,
               `userrating_rating`
        FROM `electionnational`
        LEFT JOIN `electionstatus`
        ON `electionnational_electionstatus_id`=`electionstatus_id`
        LEFT JOIN `electionnationalapplication`
        ON `electionnational_id`=`electionnationalapplication_electionnational_id`
        LEFT JOIN `user`
        ON `electionnationalapplication_user_id`=`user_id`
        LEFT JOIN
        (
            SELECT `userrating_rating`,
                   `userrating_user_id`
            FROM `userrating`
            WHERE `userrating_season_id`=0
        ) AS `t3`
        ON `user_id`=`userrating_user_id`
        LEFT JOIN
        (
            SELECT `electionnationalapplicationplayer_electionnationalapplication_id`,
                   SUM(`player_power_nominal_s`) AS `electionnationalapplication_power`
            FROM `electionnationalapplicationplayer`
            LEFT JOIN `player`
            ON `electionnationalapplicationplayer_player_id`=`player_id`
            WHERE `electionnationalapplicationplayer_electionnationalapplication_id` IN
            (
                SELECT `electionnationalapplication_id`
                FROM `electionnational`
                LEFT JOIN `electionnationalapplication`
                ON `electionnational_id`=`electionnationalapplication_electionnational_id`
                WHERE `electionnational_id`=$electionnational_id
            )
            GROUP BY `electionnationalapplicationplayer_electionnationalapplication_id`
        ) AS `t2`
        ON `electionnationalapplication_id`=`electionnationalapplicationplayer_electionnationalapplication_id`
        WHERE `electionstatus_id`=" . ELECTIONSTATUS_OPEN . "
        AND `electionnational_id`=$electionnational_id
        ORDER BY `electionnationalapplication_count` DESC, `userrating_rating` DESC, `electionnationalapplication_power` DESC, `user_date_register` ASC, `electionnationalapplication_id` ASC";
$electionnational_sql = f_igosja_mysqli_query($sql);

if (0 == $electionnational_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$electionnational_array = $electionnational_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT SUM(`electionnationalapplication_count`) AS `count`
        FROM `electionnationalapplication`
        WHERE `electionnationalapplication_electionnational_id`=$electionnational_id";
$total_sql = f_igosja_mysqli_query($sql);

$total_array = $total_sql->fetch_all(MYSQLI_ASSOC);

$electionnational_array[0]['count'] = $total_array[0]['count'];

if ($data = f_igosja_request_post('data'))
{
    if (!isset($auth_user_id))
    {
        f_igosja_session_front_flash_set('error', 'Авторизуйтесь, чтобы проголосовать.');

        refresh();
    }

    $sql = "SELECT COUNT(`electionnationaluser_electionnational_id`) AS `count`
            FROM `electionnationaluser`
            WHERE `electionnationaluser_electionnational_id`=$electionnational_id
            AND `electionnationaluser_user_id`=$auth_user_id";
    $electionnationaluser_sql = f_igosja_mysqli_query($sql);

    $electionnationaluser_array = $electionnationaluser_sql->fetch_all(MYSQLI_ASSOC);

    if (0 != $electionnationaluser_array[0]['count'])
    {
        f_igosja_session_front_flash_set('error', 'Вы уже проголосовали.');

        refresh();
    }

    $answer = (int) $data['answer'];

    $sql = "INSERT INTO `electionnationaluser`
            SET `electionnationaluser_electionnationalapplication_id`=$answer,
                `electionnationaluser_date`=UNIX_TIMESTAMP(),
                `electionnationaluser_user_id`=$auth_user_id,
                `electionnationaluser_electionnational_id`=$electionnational_id";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `electionnationalapplication`
            SET `electionnationalapplication_count`=`electionnationalapplication_count`+1
            WHERE `electionnationalapplication_id`=$answer
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    f_igosja_session_front_flash_set('success', 'Вы успешно проголосовали.');

    refresh();
}

if (isset($auth_user_id) && ELECTIONSTATUS_OPEN == $electionnational_array[0]['electionstatus_id'])
{
    $sql = "SELECT COUNT(`electionnationaluser_electionnationalapplication_id`) AS `count`
            FROM `electionnationaluser`
            WHERE `electionnationaluser_electionnational_id`=$electionnational_id
            AND `electionnationaluser_user_id`=$auth_user_id";
    $electionnationaluser_sql = f_igosja_mysqli_query($sql);

    $electionnationaluser_array = $electionnationaluser_sql->fetch_all(MYSQLI_ASSOC);

    if (0 == $electionnationaluser_array[0]['count'])
    {
        $tpl = 'national_vote_form';
    }
}

$seo_title          = 'Голосование за тернера сборной';
$seo_description    = 'Голосование за тернера сборной на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'голосование за тернера сборной';

include(__DIR__ . '/view/layout/main.php');