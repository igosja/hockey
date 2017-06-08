<?php

/**
 * @var $auth_user_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `applicationpresident_id`,
               `applicationpresident_text`,
               `applicationpresident_user_id`,
               `count_answer`
        FROM `applicationpresident`
        LEFT JOIN
        (
            SELECT COUNT(`applicationpresidentuser_user_id`) AS `count_answer`,
                   `applicationpresidentuser_applicationpresident_id`
            FROM `applicationpresidentuser`
            GROUP BY `applicationpresidentuser_applicationpresident_id`
        ) AS `t1`
        ON `applicationpresidentuser_applicationpresident_id`=`applicationpresident_id`
        WHERE `applicationpresident_ready`=0
        AND `applicationpresident_country_id`=$num_get
        ORDER BY `count_answer` DESC, `applicationpresident_id` ASC";
$applicationpresident_sql = f_igosja_mysqli_query($sql);

if (0 == $applicationpresident_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$applicationpresident_array = $applicationpresident_sql->fetch_all(1);

$president_id       = $applicationpresident_array[0]['applicationpresident_user_id'];
$vicepresident_id   = $applicationpresident_array[1]['applicationpresident_user_id'];

$sql = "UPDATE `applicationpresident`
        SET `applicationpresident_ready`=1
        WHERE `applicationpresident_country_id`=$num_get";
f_igosja_mysqli_query($sql);

$sql = "UPDATE `country`
        SET `country_president_id`=$president_id,
            `country_vicepresident_id`=$vicepresident_id
        WHERE `country_id`=$num_get
        LIMIT 1";
f_igosja_mysqli_query($sql);

$log = array(
    'history_country_id' => $num_get,
    'history_historytext_id' => HISTORYTEXT_USER_PRESIDENT_IN,
    'history_user_id' => $president_id,
);
f_igosja_history($log);

$log = array(
    'history_country_id' => $num_get,
    'history_historytext_id' => HISTORYTEXT_USER_VICE_PRESIDENT_IN,
    'history_user_id' => $vicepresident_id,
);
f_igosja_history($log);

if ($data = f_igosja_request_post('data'))
{
    if (!isset($auth_user_id))
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Авторизуйтесь, чтобы проголосовать.';

        refresh();
    }

    $sql = "SELECT COUNT(`applicationpresidentuser_applicationpresident_id`) AS `count`
            FROM `applicationpresidentuser`
            WHERE `applicationpresidentuser_applicationpresident_id`=$num_get
            AND `applicationpresidentuser_user_id`=$auth_user_id";
    $applicationpresidentuser_sql = f_igosja_mysqli_query($sql);

    $applicationpresidentuser_array = $applicationpresidentuser_sql->fetch_all(1);

    if (0 != $applicationpresidentuser_array[0]['count'])
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Вы уже проголосовали.';

        refresh();
    }

    $vote = (int) $data['vote'];

    $sql = "INSERT INTO `applicationpresidentuser`
            SET `applicationpresidentuser_applicationpresident_id`=$vote,
                `applicationpresidentuser_date`=UNIX_TIMESTAMP(),
                `applicationpresidentuser_user_id`=$auth_user_id";
    f_igosja_mysqli_query($sql);

    $_SESSION['message']['class']   = 'success';
    $_SESSION['message']['text']    = 'Вы успешно проголосовали.';

    refresh();
}

if (isset($auth_user_id))
{
    $sql = "SELECT COUNT(`applicationpresidentuser_applicationpresident_id`) AS `count`
            FROM `applicationpresidentuser`
            LEFT JOIN `applicationpresident`
            ON `applicationpresidentuser_applicationpresident_id`=`applicationpresident_id`
            WHERE `applicationpresident_country_id`=$num_get
            AND `applicationpresidentuser_user_id`=$auth_user_id";
    $applicationpresidentuser_sql = f_igosja_mysqli_query($sql);

    $applicationpresidentuser_array = $applicationpresidentuser_sql->fetch_all(1);

    if (0 == $applicationpresidentuser_array[0]['count'])
    {
        $tpl = 'president_vote_form';
    }
}

include(__DIR__ . '/view/layout/main.php');