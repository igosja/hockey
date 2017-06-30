<?php

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `electionpresident_id`
        FROM `electionpresident`
        WHERE `electionpresident_country_id`=$num_get
        AND `electionpresident_electionstatus_id`>" . ELECTIONSTATUS_CANDIDATES . "
        ORDER BY `electionpresident_id` DESC
        LIMIT 1";
$electionpresident_sql = f_igosja_mysqli_query($sql);

if (0 == $electionpresident_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$electionpresident_array = $electionpresident_sql->fetch_all(1);

$electionpresident_id = $electionpresident_array[0]['electionpresident_id'];

$sql = "SELECT `count_answer`,
               `electionpresident_id`,
               `electionpresidentapplication_id`,
               `electionpresidentapplication_text`,
               `electionstatus_id`,
               `electionstatus_name`
        FROM `electionpresident`
        LEFT JOIN `electionstatus`
        ON `electionpresident_electionstatus_id`=`electionstatus_id`
        LEFT JOIN `electionpresidentapplication`
        ON `electionpresident_id`=`electionpresidentapplication_electionpresident_id`
        LEFT JOIN
        (
            SELECT COUNT(`electionpresidentuser_user_id`) AS `count_answer`,
                   `electionpresidentuser_electionpresidentapplication_id`
            FROM `electionpresidentuser`
            WHERE `electionpresidentuser_electionpresidentapplication_id`=$electionpresident_id
            GROUP BY `electionpresidentuser_electionpresidentapplication_id`
        ) AS `t1`
        ON `electionpresidentuser_electionpresidentapplication_id`=`electionpresidentapplication_id`
        WHERE `electionstatus_id`>" . ELECTIONSTATUS_CANDIDATES . "
        AND `electionpresident_id`=$electionpresident_id
        ORDER BY `count_answer` DESC, `electionpresidentapplication_id` ASC";
$electionpresident_sql = f_igosja_mysqli_query($sql);

if (0 == $electionpresident_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$electionpresident_array = $electionpresident_sql->fetch_all(1);

if ($data = f_igosja_request_post('data'))
{
    if (!isset($auth_user_id))
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Авторизуйтесь, чтобы проголосовать.';

        refresh();
    }

    $sql = "SELECT COUNT(`electionpresidentuser_electionpresident_id`) AS `count`
            FROM `electionpresidentuser`
            WHERE `electionpresidentuser_electionpresident_id`=$electionpresident_id
            AND `electionpresidentuser_user_id`=$auth_user_id";
    $electionpresidentuser_sql = f_igosja_mysqli_query($sql);

    $electionpresidentuser_array = $electionpresidentuser_sql->fetch_all(1);

    if (0 != $electionpresidentuser_array[0]['count'])
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Вы уже проголосовали.';

        refresh();
    }

    $answer = (int) $data['answer'];

    $sql = "INSERT INTO `electionpresidentuser`
            SET `electionpresidentuser_electionpresidentapplication_id`=$answer,
                `electionpresidentuser_date`=UNIX_TIMESTAMP(),
                `electionpresidentuser_user_id`=$auth_user_id,
                `electionpresidentuser_electionpresident_id`=$electionpresident_id";
    f_igosja_mysqli_query($sql);

    $_SESSION['message']['class']   = 'success';
    $_SESSION['message']['text']    = 'Вы успешно проголосовали.';

    refresh();
}

if (isset($auth_user_id) && ELECTIONSTATUS_OPEN == $electionpresident_array[0]['electionstatus_id'])
{
    $sql = "SELECT COUNT(`electionpresidentuser_electionpresidentapplication_id`) AS `count`
            FROM `electionpresidentuser`
            WHERE `electionpresidentuser_electionpresidentapplication_id`=$electionpresident_id
            AND `electionpresidentuser_user_id`=$auth_user_id";
    $electionpresidentuser_sql = f_igosja_mysqli_query($sql);

    $electionpresidentuser_array = $electionpresidentuser_sql->fetch_all(1);

    if (0 == $electionpresidentuser_array[0]['count'])
    {
        $tpl = 'president_vote_form';
    }
}

$seo_title          = 'Голосование за президента федерации';
$seo_description    = 'Голосование за президента федерации на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'голосование за президента федерации';

include(__DIR__ . '/view/layout/main.php');