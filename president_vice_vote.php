<?php

/**
 * @var $auth_country_id integer
 * @var $auth_user_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

if (!$auth_country_id)
{
    redirect('/team_ask.php');
}

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

if ($num_get != $auth_country_id)
{
    redirect('/wrong_page.php');
}

include(__DIR__ . '/include/sql/country_view.php');


$sql = "SELECT `electionpresidentvice_id`
        FROM `electionpresidentvice`
        WHERE `electionpresidentvice_country_id`=$num_get
        AND `electionpresidentvice_electionstatus_id`=" . ELECTIONSTATUS_OPEN . "
        ORDER BY `electionpresidentvice_id` DESC
        LIMIT 1";
$electionpresidentvice_sql = f_igosja_mysqli_query($sql);

if (0 == $electionpresidentvice_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$electionpresidentvice_array = $electionpresidentvice_sql->fetch_all(MYSQLI_ASSOC);

$electionpresidentvice_id = $electionpresidentvice_array[0]['electionpresidentvice_id'];

$sql = "SELECT `electionpresidentvice_id`,
               `electionpresidentviceapplication_id`,
               `electionpresidentviceapplication_count`,
               `electionpresidentviceapplication_text`,
               `electionstatus_id`,
               `electionstatus_name`,
               `user_date_register`,
               `user_id`,
               `user_login`
        FROM `electionpresidentvice`
        LEFT JOIN `electionstatus`
        ON `electionpresidentvice_electionstatus_id`=`electionstatus_id`
        LEFT JOIN `electionpresidentviceapplication`
        ON `electionpresidentvice_id`=`electionpresidentviceapplication_electionpresidentvice_id`
        LEFT JOIN `user`
        ON `electionpresidentviceapplication_user_id`=`user_id`
        WHERE `electionstatus_id`=" . ELECTIONSTATUS_OPEN . "
        AND `electionpresidentvice_id`=$electionpresidentvice_id
        ORDER BY `electionpresidentviceapplication_count` DESC, `user_date_register` ASC, `electionpresidentviceapplication_id` ASC";
$electionpresidentvice_sql = f_igosja_mysqli_query($sql);

if (0 == $electionpresidentvice_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$electionpresidentvice_array = $electionpresidentvice_sql->fetch_all(MYSQLI_ASSOC);

if ($data = f_igosja_request_post('data'))
{
    if (!isset($auth_user_id))
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Авторизуйтесь, чтобы проголосовать.';

        refresh();
    }

    $sql = "SELECT COUNT(`electionpresidentviceuser_electionpresidentvice_id`) AS `count`
            FROM `electionpresidentviceuser`
            WHERE `electionpresidentviceuser_electionpresidentvice_id`=$electionpresidentvice_id
            AND `electionpresidentviceuser_user_id`=$auth_user_id";
    $electionpresidentviceuser_sql = f_igosja_mysqli_query($sql);

    $electionpresidentviceuser_array = $electionpresidentviceuser_sql->fetch_all(MYSQLI_ASSOC);

    if (0 != $electionpresidentviceuser_array[0]['count'])
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Вы уже проголосовали.';

        refresh();
    }

    $answer = (int) $data['answer'];

    $sql = "INSERT INTO `electionpresidentviceuser`
            SET `electionpresidentviceuser_electionpresidentviceapplication_id`=$answer,
                `electionpresidentviceuser_date`=UNIX_TIMESTAMP(),
                `electionpresidentviceuser_user_id`=$auth_user_id,
                `electionpresidentviceuser_electionpresidentvice_id`=$electionpresidentvice_id";
    f_igosja_mysqli_query($sql);

    $electionpresidentviceapplication_id = $electionpresidentvice_array[0]['electionpresidentviceapplication_id'];

    $sql = "UPDATE `electionpresidentviceapplication`
            SET `electionpresidentviceapplication_count`=`electionpresidentviceapplication_count`+1
            WHERE `electionpresidentviceapplication_id`=$electionpresidentviceapplication_id
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    $_SESSION['message']['class']   = 'success';
    $_SESSION['message']['text']    = 'Вы успешно проголосовали.';

    refresh();
}

if (ELECTIONSTATUS_OPEN == $electionpresidentvice_array[0]['electionstatus_id'])
{
    $sql = "SELECT COUNT(`electionpresidentviceuser_electionpresidentviceapplication_id`) AS `count`
            FROM `electionpresidentviceuser`
            WHERE `electionpresidentviceuser_electionpresidentvice_id`=$electionpresidentvice_id
            AND `electionpresidentviceuser_user_id`=$auth_user_id";
    $electionpresidentviceuser_sql = f_igosja_mysqli_query($sql);

    $electionpresidentviceuser_array = $electionpresidentviceuser_sql->fetch_all(MYSQLI_ASSOC);

    if (0 == $electionpresidentviceuser_array[0]['count'])
    {
        $tpl = 'president_vice_vote_form';
    }
}

$seo_title          = 'Голосование за заместителя тернера сборной';
$seo_description    = 'Голосование за заместителя тернера сборной на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'голосование за заместителя тернера сборной';

include(__DIR__ . '/view/layout/main.php');