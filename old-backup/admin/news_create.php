<?php

/**
 * @var $auth_admin_user_id integer
 */

include(__DIR__ . '/../include/include.php');

if ($data = f_igosja_request_post('data'))
{
    $set_sql = f_igosja_sql_data($data, array(
        'news_text',
        'news_title'
    ), true);

    $sql = "INSERT INTO `news`
            SET $set_sql,
                `news_date`=UNIX_TIMESTAMP(),
                `news_user_id`=$auth_admin_user_id";
    f_igosja_mysqli_query($sql);

    redirect('/admin/news_view.php?num=' . $mysqli->insert_id);
}

$breadcrumb_array[] = array('url' => 'news_list.php', 'text' => 'Новости');
$breadcrumb_array[] = 'Создание';

$tpl = 'news_update';

include(__DIR__ . '/view/layout/main.php');