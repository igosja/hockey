<?php

/**
 * @var $auth_user_id integer
 * @var $country_array array
 */

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

include(__DIR__ . '/include/sql/country_view.php');

if (!$vote_id = (int) f_igosja_request_get('vote_id'))
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
        WHERE `votestatus_id`>" . VOTESTATUS_NEW . "
        AND `vote_country_id`=$num_get
        AND `vote_id`=$vote_id
        ORDER BY `voteanswer_count` DESC, `voteanswer_id` ASC";
$vote_sql = f_igosja_mysqli_query($sql);

if (0 == $vote_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$vote_array = $vote_sql->fetch_all(MYSQLI_ASSOC);

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
            AND `voteuser_vote_id`=$vote_id";
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
                `voteuser_vote_id`=$vote_id";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `voteanswer`
            SET `voteanswer_count`=`voteanswer_count`+1
            WHERE `voteanswer_id`=$answer
            AND `voteanswer_vote_id`=$vote_id";
    f_igosja_mysqli_query($sql);

    f_igosja_session_front_flash_set('success', 'Вы успешно проголосовали.');

    refresh();
}

if (isset($auth_user_id) && VOTESTATUS_OPEN == $vote_array[0]['votestatus_id'])
{
    $sql = "SELECT COUNT(`voteuser_vote_id`) AS `count`
            FROM `voteuser`
            WHERE `voteuser_user_id`=$auth_user_id
            AND `voteuser_vote_id`=$vote_id";
    $voteuser_sql = f_igosja_mysqli_query($sql);

    $voteuser_array = $voteuser_sql->fetch_all(MYSQLI_ASSOC);

    if (0 == $voteuser_array[0]['count'])
    {
        $tpl = 'country_vote_form';
    }
}

$seo_title          = $country_array[0]['country_name'] . '. Опрос фередации';
$seo_description    = $country_array[0]['country_name'] . '. Опрос фередации на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $country_array[0]['country_name'] . ' опрос фередации';

include(__DIR__ . '/view/layout/main.php');