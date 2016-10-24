<?php

include (__DIR__ . '/../include/include.php');

if ($data = f_igosja_post('data'))
{
    $set_sql = f_igosja_sql_data($data);

    $sql = "INSERT INTO `news`
            SET $set_sql,
                `news_date`=UNIX_TIMESTAMP(),
                `news_user_id`='$auth_user_id'";
    igosja_db_query($sql);

    redirect('/admin/news_view.php?num=' . $mysqli->insert_id);
}

$breadcrumb_array[] = array('url' => 'news_list.php', 'text' => 'Новости');
$breadcrumb_array[] = 'Создание';

$tpl = 'news_update';

include (__DIR__ . '/view/layout/main.php');