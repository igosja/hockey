<?php

/**
 * @var $auth_user_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `user_id`,
               `user_login`,
               `vote_id`,
               `vote_text`,
               `voteanswer_id`,
               `voteanswer_count`,
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
        WHERE `vote_country_id`=0
        AND `votestatus_id`>" . VOTESTATUS_NEW . "
        AND `vote_id`=$num_get
        ORDER BY `voteanswer_count` DESC, `voteanswer_id` ASC";
$vote_sql = f_igosja_mysqli_query($sql);

if (0 == $vote_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$vote_array = $vote_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT SUM(`voteanswer_count`) AS `count`
        FROM `voteanswer`
        WHERE `voteanswer_vote_id`=$num_get";
$total_sql = f_igosja_mysqli_query($sql);

$total_array = $total_sql->fetch_all(MYSQLI_ASSOC);

$vote_array[0]['count'] = $total_array[0]['count'];

if ($data = f_igosja_request_post('data'))
{
    if (!isset($auth_user_id))
    {
        f_igosja_session_front_flash_set('error', 'Авторизуйтесь, чтобы проголосовать.');

        refresh();
    }

    $sql = "SELECT COUNT(`voteuser_vote_id`) AS `count`
            FROM `voteuser`
            WHERE `voteuser_user_id`=$auth_user_id
            AND `voteuser_vote_id`=$num_get";
    $voteuser_sql = f_igosja_mysqli_query($sql);

    $voteuser_array = $voteuser_sql->fetch_all(MYSQLI_ASSOC);

    if (0 != $voteuser_array[0]['count'])
    {
        f_igosja_session_front_flash_set('error', 'Вы уже проголосовали.');

        refresh();
    }

    $answer = (int) $data['answer'];

    $sql = "INSERT INTO `voteuser`
            SET `voteuser_answer_id`=$answer,
                `voteuser_date`=UNIX_TIMESTAMP(),
                `voteuser_user_id`=$auth_user_id,
                `voteuser_vote_id`=$num_get";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `voteanswer`
            SET `voteanswer_count`=`voteanswer_count`+1
            WHERE `voteanswer_id`=$answer
            AND `voteanswer_vote_id`=$num_get";
    f_igosja_mysqli_query($sql);

    f_igosja_session_front_flash_set('success', 'Вы успешно проголосовали.');

    refresh();
}

if (isset($auth_user_id) && VOTESTATUS_OPEN == $vote_array[0]['votestatus_id'])
{
    $sql = "SELECT COUNT(`voteuser_vote_id`) AS `count`
            FROM `voteuser`
            WHERE `voteuser_user_id`=$auth_user_id
            AND `voteuser_vote_id`=$num_get";
    $voteuser_sql = f_igosja_mysqli_query($sql);

    $voteuser_array = $voteuser_sql->fetch_all(MYSQLI_ASSOC);

    if (0 == $voteuser_array[0]['count'])
    {
        $tpl = 'vote_form';
    }
}

$seo_title          = 'Опрос';
$seo_description    = 'Опрос на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'опрос';

include(__DIR__ . '/view/layout/main.php');