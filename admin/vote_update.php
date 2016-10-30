<?php

include (__DIR__ . '/../include/include.php');

$num_get = (int) f_igosja_get('num');

if ($data = f_igosja_post('data'))
{
    $set_sql = f_igosja_sql_data($data);
    $answer  = f_igosja_post('answer', 'voteanswer_text');

    $sql = "UPDATE `vote`
            SET $set_sql
            WHERE `vote_id`='$num_get'
            LIMIT 1";
    igosja_db_query($sql);

    foreach ($answer as $key => $item)
    {
        $item = trim($item);

        if (!empty($item))
        {
            $sql = "SELECT COUNT(`voteanswer_id`) AS `count`
                    FROM `voteanswer`
                    WHERE `voteanswer_vote_id`='$num_get'
                    AND `voteanswer_id`='$key'";
            $check_sql = igosja_db_query($sql);

            $check_array = $check_sql->fetch_all(1);

            if ($check_array[0]['count'])
            {
                $sql = "UPDATE `voteanswer`
                        SET `voteanswer_text`='$item'
                        WHERE `voteanswer_id`='$key'
                        LIMIT 1";
                igosja_db_query($sql);
            }
            else
            {
                $sql = "INSERT INTO `voteanswer`
                        SET `voteanswer_text`='$item',
                            `voteanswer_vote_id`='$num_get'
                        WHERE `voteanswer_id`='$key'";
                igosja_db_query($sql);
            }
        }
    }

    redirect('/admin/vote_view.php?num=' . $num_get);
}

$sql = "SELECT `vote_id`,
               `vote_text`,
               `voteanswer_id`,
               `voteanswer_text`
        FROM `vote`
        LEFT JOIN `voteanswer`
        ON `vote_id`=`voteanswer_vote_id`
        WHERE `vote_id`='$num_get'
        ORDER BY `voteanswer_id` ASC";
$vote_sql = igosja_db_query($sql);

if (0 == $vote_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$vote_array = $vote_sql->fetch_all(1);

$breadcrumb_array[] = array('url' => 'vote_list.php', 'text' => 'Опросы');
$breadcrumb_array[] = array(
    'url' => 'vote_view.php?num=' . $vote_array[0]['vote_id'],
    'text' => $vote_array[0]['vote_text']
);
$breadcrumb_array[] = 'Редактирование';

include (__DIR__ . '/view/layout/main.php');