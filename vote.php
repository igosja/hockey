<?php

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `count_answer`,
               `user_id`,
               `user_login`,
               `vote_id`,
               `vote_text`,
               `voteanswer_id`,
               `voteanswer_text`,
               `votestatus_id`,
               `votestatus_name`
        FROM `vote`
        LEFT JOIN `votestatus`
        ON `vote_votestatus_id`=`votestatus_id`
        LEFT JOIN `user`
        ON `vote_user_id`=`user_id`
        LEFT JOIN `voteanswer`
        ON `vote_id`=`voteanswer_vote_id`
        LEFT JOIN
        (
            SELECT COUNT(`voteuser_user_id`) AS `count_answer`,
                   `voteuser_answer_id`
            FROM `voteuser`
            WHERE `voteuser_vote_id`=$num_get
            GROUP BY `voteuser_answer_id`
        ) AS `t1`
        ON `voteuser_answer_id`=`voteanswer_id`
        WHERE `vote_country_id`=0
        AND `votestatus_id`>" . VOTESTATUS_NEW . "
        AND `vote_id`=$num_get
        ORDER BY `count_answer` DESC, `voteanswer_id` ASC";
$vote_sql = f_igosja_mysqli_query($sql);

if (0 == $vote_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$vote_array = $vote_sql->fetch_all(1);

if ($data = f_igosja_request_post('data'))
{
    if (!isset($auth_user_id))
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Авторизуйтесь, чтобы проголосовать.';

        refresh();
    }

    $sql = "SELECT COUNT(`voteuser_vote_id`) AS `count`
            FROM `voteuser`
            WHERE `voteuser_vote_id`=$num_get
            AND `voteuser_user_id`=$auth_user_id";
    $voteuser_sql = f_igosja_mysqli_query($sql);

    $voteuser_array = $voteuser_sql->fetch_all(1);

    if (0 != $voteuser_array[0]['count'])
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Вы уже проголосовали.';

        refresh();
    }

    $answer = (int) $data['answer'];

    $sql = "INSERT INTO `voteuser`
            SET `voteuser_answer_id`=$answer,
                `voteuser_date`=UNIX_TIMESTAMP(),
                `voteuser_user_id`=$auth_user_id,
                `voteuser_vote_id`=$num_get";
    f_igosja_mysqli_query($sql);

    $_SESSION['message']['class']   = 'success';
    $_SESSION['message']['text']    = 'Вы успешно проголосовали.';

    refresh();
}

if (isset($auth_user_id) && VOTESTATUS_OPEN == $vote_array[0]['votestatus_id'])
{
    $sql = "SELECT COUNT(`voteuser_vote_id`) AS `count`
            FROM `voteuser`
            WHERE `voteuser_vote_id`=$num_get
            AND `voteuser_user_id`=$auth_user_id";
    $voteuser_sql = f_igosja_mysqli_query($sql);

    $voteuser_array = $voteuser_sql->fetch_all(1);

    if (0 == $voteuser_array[0]['count'])
    {
        $tpl = 'vote_form';
    }
}

include(__DIR__ . '/view/layout/main.php');