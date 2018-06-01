<?php

/**
 * @var $auth_country_id integer
 * @var $auth_user_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$page = (int) f_igosja_request_get('page'))
{
    $page = 1;
}

$limit  = 10;
$offset = ($page - 1) * $limit;

if (isset($auth_country_id))
{
    $country = '(0, ' . $auth_country_id . ')';
    $user_id = '(0, ' . $auth_user_id . ')';
}
else
{
    $country = '(0)';
    $user_id = '(0)';
}

$sql = "UPDATE `vote`
        SET `vote_votestatus_id`=" . VOTESTATUS_CLOSE . "
        WHERE `vote_votestatus_id`=" . VOTESTATUS_OPEN . "
        AND `vote_date`<UNIX_TIMESTAMP()-604800";
f_igosja_mysqli_query($sql);

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `user_id`,
               `user_login`,
               `vote_country_id`,
               `vote_id`,
               `vote_text`,
               `votestatus_name`
        FROM `vote`
        LEFT JOIN `votestatus`
        ON `vote_votestatus_id`=`votestatus_id`
        LEFT JOIN `user`
        ON `vote_user_id`=`user_id`
        WHERE `vote_country_id` IN $country
        AND `votestatus_id`>" . VOTESTATUS_NEW . "
        ORDER BY `votestatus_id` ASC, `vote_id` DESC
        LIMIT $offset, $limit";
$vote_sql = f_igosja_mysqli_query($sql);

$vote_array = $vote_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT FOUND_ROWS() AS `count`";
$total = f_igosja_mysqli_query($sql);
$total = $total->fetch_all(MYSQLI_ASSOC);
$total = $total[0]['count'];

$count_page = ceil($total / $limit);

for ($i=0, $count_vote=count($vote_array); $i<$count_vote; $i++)
{
    $vote_id = $vote_array[$i]['vote_id'];

    $sql = "SELECT `voteanswer_count`,
                   `voteanswer_text`
            FROM `voteanswer`
            WHERE `voteanswer_vote_id`=$vote_id
            ORDER BY `voteanswer_count` DESC, `voteanswer_id` ASC";
    $answer_sql = f_igosja_mysqli_query($sql);

    $vote_array[$i]['answer'] = $answer_sql->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT SUM(`voteanswer_count`) AS `count`
            FROM `voteanswer`
            WHERE `voteanswer_vote_id`=$vote_id";
    $total_sql = f_igosja_mysqli_query($sql);

    $total_array = $total_sql->fetch_all(MYSQLI_ASSOC);

    $vote_array[$i]['count'] = $total_array[0]['count'];
}

$sql = "SELECT `user_id`,
               `user_login`,
               `vote_id`,
               `vote_text`
        FROM `vote`
        LEFT JOIN `user`
        ON `vote_user_id`=`user_id`
        WHERE `vote_country_id` IN $country
        AND `vote_votestatus_id`=" . VOTESTATUS_NEW . "
        AND `vote_user_id` IN $user_id
        ORDER BY `vote_id` DESC";
$newvote_sql = f_igosja_mysqli_query($sql);

$newvote_array = $newvote_sql->fetch_all(MYSQLI_ASSOC);

for ($i=0, $count_vote=count($newvote_array); $i<$count_vote; $i++)
{
    $vote_id = $newvote_array[$i]['vote_id'];

    $sql = "SELECT `voteanswer_count`,
                   `voteanswer_text`
            FROM `voteanswer`
            WHERE `voteanswer_vote_id`=$vote_id
            ORDER BY `voteanswer_count` DESC, `voteanswer_id` ASC";
    $answer_sql = f_igosja_mysqli_query($sql);

    $newvote_array[$i]['answer'] = $answer_sql->fetch_all(MYSQLI_ASSOC);
}

$seo_title          = 'Список опросов';
$seo_description    = 'Список опросов на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'Список опросов';

include(__DIR__ . '/view/layout/main.php');