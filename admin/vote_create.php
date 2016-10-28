<?php

include (__DIR__ . '/../include/include.php');

if ($data = f_igosja_post('data'))
{
    $set_sql = f_igosja_sql_data($data);
    $answer  = f_igosja_post('answer', 'voteanswer_text');

    $sql = "INSERT INTO `vote`
            SET $set_sql,
                `vote_date`=UNIX_TIMESTAMP(),
                `vote_user_id`=$auth_user_id";
    igosja_db_query($sql);

    $vote_id    = $mysqli->insert_id;
    $answer_sql = array();

    foreach ($answer as $item)
    {
        if (!empty(trim($item)))
        {
            $answer_sql[] = '(\'' . $item . '\', \'' . $vote_id . '\')';
        }
    }

    $answer_sql = implode(',', $answer_sql);

    $sql = "INSERT INTO `voteanswer` (`voteanswer_text`, `voteanswer_vote_id`)
            VALUES $answer_sql;";
    igosja_db_query($sql);

    redirect('/admin/vote_view.php?num=' . $vote_id);
}

$breadcrumb_array[] = array('url' => 'vote_list.php', 'text' => 'Опросы');
$breadcrumb_array[] = 'Создание';

$tpl = 'vote_update';

include (__DIR__ . '/view/layout/main.php');