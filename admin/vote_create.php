<?php

/**
 * @var $auth_admin_user_id integer
 */

include(__DIR__ . '/../include/include.php');

if ($data = f_igosja_request_post('data'))
{
    $set_sql = f_igosja_sql_data($data, array(
        'vote_text'
    ));
    $answer  = f_igosja_request_post('answer', 'voteanswer_text');

    $sql = "INSERT INTO `vote`
            SET $set_sql,
                `vote_date`=UNIX_TIMESTAMP(),
                `vote_user_id`=$auth_admin_user_id";
    f_igosja_mysqli_query($sql);

    $vote_id    = $mysqli->insert_id;
    $answer_sql = array();

    foreach ($answer as $item)
    {
        $item = trim($item);

        if (!empty($item))
        {
            $answer_sql[] = '(\'' . htmlspecialchars($mysqli->real_escape_string($item)) . '\', ' . $vote_id . ')';
        }
    }

    $answer_sql = implode(',', $answer_sql);

    $sql = "INSERT INTO `voteanswer` (`voteanswer_text`, `voteanswer_vote_id`)
            VALUES $answer_sql;";
    f_igosja_mysqli_query($sql);

    redirect('/admin/vote_view.php?num=' . $vote_id);
}

$breadcrumb_array[] = array('url' => 'vote_list.php', 'text' => 'Опросы');
$breadcrumb_array[] = 'Создание';

$tpl = 'vote_update';

include(__DIR__ . '/view/layout/main.php');