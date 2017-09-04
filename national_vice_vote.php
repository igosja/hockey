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

$sql = "SELECT `electionnationalvice_id`
        FROM `electionnationalvice`
        WHERE `electionnationalvice_country_id`=$num_get
        AND `electionnationalvice_electionstatus_id`>" . ELECTIONSTATUS_CANDIDATES . "
        AND `electionnationalvice_nationaltype_id`=$type_get
        ORDER BY `electionnationalvice_id` DESC
        LIMIT 1";
$electionnationalvice_sql = f_igosja_mysqli_query($sql);

if (0 == $electionnationalvice_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$electionnationalvice_array = $electionnationalvice_sql->fetch_all(1);

$electionnationalvice_id = $electionnationalvice_array[0]['electionnationalvice_id'];

$sql = "SELECT `count_answer`,
               `electionnationalvice_id`,
               `electionnationalviceapplication_id`,
               `electionnationalviceapplication_text`,
               `electionstatus_id`,
               `electionstatus_name`,
               `user_date_register`,
               `user_id`,
               `user_login`,
               `userrating_rating`
        FROM `electionnationalvice`
        LEFT JOIN `electionstatus`
        ON `electionnationalvice_electionstatus_id`=`electionstatus_id`
        LEFT JOIN `electionnationalviceapplication`
        ON `electionnationalvice_id`=`electionnationalviceapplication_electionnationalvice_id`
        LEFT JOIN `user`
        ON `electionnationalviceapplication_user_id`=`user_id`
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
            SELECT COUNT(`electionnationalviceuser_user_id`) AS `count_answer`,
                   `electionnationalviceuser_electionnationalviceapplication_id`
            FROM `electionnationalviceuser`
            WHERE `electionnationalviceuser_electionnationalviceapplication_id`=$electionnationalvice_id
            GROUP BY `electionnationalviceuser_electionnationalviceapplication_id`
        ) AS `t1`
        ON `electionnationalviceapplication_id`=`electionnationalviceuser_electionnationalviceapplication_id`
        WHERE `electionstatus_id`>" . ELECTIONSTATUS_CANDIDATES . "
        AND `electionnationalvice_id`=$electionnationalvice_id
        ORDER BY `count_answer` DESC, `userrating_rating` DESC, `user_date_register` ASC, `electionnationalviceapplication_id` ASC";
$electionnationalvice_sql = f_igosja_mysqli_query($sql);

if (0 == $electionnationalvice_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$electionnationalvice_array = $electionnationalvice_sql->fetch_all(1);

if ($data = f_igosja_request_post('data'))
{
    if (!isset($auth_user_id))
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Авторизуйтесь, чтобы проголосовать.';

        refresh();
    }

    $sql = "SELECT COUNT(`electionnationalviceuser_electionnationalvice_id`) AS `count`
            FROM `electionnationalviceuser`
            WHERE `electionnationalviceuser_electionnationalvice_id`=$electionnationalvice_id
            AND `electionnationalviceuser_user_id`=$auth_user_id";
    $electionnationalviceuser_sql = f_igosja_mysqli_query($sql);

    $electionnationalviceuser_array = $electionnationalviceuser_sql->fetch_all(1);

    if (0 != $electionnationalviceuser_array[0]['count'])
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Вы уже проголосовали.';

        refresh();
    }

    $answer = (int) $data['answer'];

    $sql = "INSERT INTO `electionnationalviceuser`
            SET `electionnationalviceuser_electionnationalviceapplication_id`=$answer,
                `electionnationalviceuser_date`=UNIX_TIMESTAMP(),
                `electionnationalviceuser_user_id`=$auth_user_id,
                `electionnationalviceuser_electionnationalvice_id`=$electionnationalvice_id";
    f_igosja_mysqli_query($sql);

    $_SESSION['message']['class']   = 'success';
    $_SESSION['message']['text']    = 'Вы успешно проголосовали.';

    refresh();
}

if (isset($auth_user_id) && ELECTIONSTATUS_OPEN == $electionnationalvice_array[0]['electionstatus_id'])
{
    $sql = "SELECT COUNT(`electionnationalviceuser_electionnationalviceapplication_id`) AS `count`
            FROM `electionnationalviceuser`
            WHERE `electionnationalviceuser_electionnationalviceapplication_id`=$electionnationalvice_id
            AND `electionnationalviceuser_user_id`=$auth_user_id";
    $electionnationalviceuser_sql = f_igosja_mysqli_query($sql);

    $electionnationalviceuser_array = $electionnationalviceuser_sql->fetch_all(1);

    if (0 == $electionnationalviceuser_array[0]['count'])
    {
        $tpl = 'national_vice_vote_form';
    }
}

$seo_title          = 'Голосование за заместителя тернера сборной';
$seo_description    = 'Голосование за заместителя тернера сборной на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'голосование за заместителя тернера сборной';

include(__DIR__ . '/view/layout/main.php');