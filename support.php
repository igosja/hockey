<?php

include (__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `support_answer`
        FROM `support`
        WHERE `support_ask_user_id`='$auth_user_id'
        ORDER BY `support_id` DESC";
$news_sql = igosja_db_query($sql);

$news_array = $news_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');