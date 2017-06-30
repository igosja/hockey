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

$sql = "SELECT `electionnational_id`
        FROM `electionnational`
        WHERE `electionnational_country_id`=$num_get
        AND `electionnational_electionstatus_id`>" . ELECTIONSTATUS_CANDIDATES . "
        AND `electionnational_nationaltype_id`=$type_get
        ORDER BY `electionnational_id` DESC
        LIMIT 1";
$electionnational_sql = f_igosja_mysqli_query($sql);

if (0 == $electionnational_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$electionnational_array = $electionnational_sql->fetch_all(1);

$electionnational_id = $electionnational_array[0]['electionnational_id'];

$sql = "SELECT `count_answer`,
               `electionnational_id`,
               `electionnationalapplication_id`,
               `electionnationalapplication_text`,
               `electionstatus_id`,
               `electionstatus_name`
        FROM `electionnational`
        LEFT JOIN `electionstatus`
        ON `electionnational_electionstatus_id`=`electionstatus_id`
        LEFT JOIN `electionnationalapplication`
        ON `electionnational_id`=`electionnationalapplication_electionnational_id`
        LEFT JOIN
        (
            SELECT COUNT(`electionnationaluser_user_id`) AS `count_answer`,
                   `electionnationaluser_electionnationalapplication_id`
            FROM `electionnationaluser`
            WHERE `electionnationaluser_electionnationalapplication_id`=$electionnational_id
            GROUP BY `electionnationaluser_electionnationalapplication_id`
        ) AS `t1`
        ON `electionnationaluser_electionnationalapplication_id`=`electionnationalapplication_id`
        WHERE `electionstatus_id`>" . ELECTIONSTATUS_CANDIDATES . "
        AND `electionnational_id`=$electionnational_id
        ORDER BY `count_answer` DESC, `electionnationalapplication_id` ASC";
$electionnational_sql = f_igosja_mysqli_query($sql);

if (0 == $electionnational_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$electionnational_array = $electionnational_sql->fetch_all(1);

if ($data = f_igosja_request_post('data'))
{
    if (!isset($auth_user_id))
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Авторизуйтесь, чтобы проголосовать.';

        refresh();
    }

    $sql = "SELECT COUNT(`electionnationaluser_electionnational_id`) AS `count`
            FROM `electionnationaluser`
            WHERE `electionnationaluser_electionnational_id`=$electionnational_id
            AND `electionnationaluser_user_id`=$auth_user_id";
    $electionnationaluser_sql = f_igosja_mysqli_query($sql);

    $electionnationaluser_array = $electionnationaluser_sql->fetch_all(1);

    if (0 != $electionnationaluser_array[0]['count'])
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Вы уже проголосовали.';

        refresh();
    }

    $answer = (int) $data['answer'];

    $sql = "INSERT INTO `electionnationaluser`
            SET `electionnationaluser_electionnationalapplication_id`=$answer,
                `electionnationaluser_date`=UNIX_TIMESTAMP(),
                `electionnationaluser_user_id`=$auth_user_id,
                `electionnationaluser_electionnational_id`=$electionnational_id";
    f_igosja_mysqli_query($sql);

    $_SESSION['message']['class']   = 'success';
    $_SESSION['message']['text']    = 'Вы успешно проголосовали.';

    refresh();
}

if (isset($auth_user_id) && ELECTIONSTATUS_OPEN == $electionnational_array[0]['electionstatus_id'])
{
    $sql = "SELECT COUNT(`electionnationaluser_electionnationalapplication_id`) AS `count`
            FROM `electionnationaluser`
            WHERE `electionnationaluser_electionnationalapplication_id`=$electionnational_id
            AND `electionnationaluser_user_id`=$auth_user_id";
    $electionnationaluser_sql = f_igosja_mysqli_query($sql);

    $electionnationaluser_array = $electionnationaluser_sql->fetch_all(1);

    if (0 == $electionnationaluser_array[0]['count'])
    {
        $tpl = 'national_vote_form';
    }
}

$seo_title          = 'Голосование за тернера сборной';
$seo_description    = 'Голосование за тернера сборной на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'голосование за тернера сборной';

include(__DIR__ . '/view/layout/main.php');