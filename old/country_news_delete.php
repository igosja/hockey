<?php

/**
 * @var $auth_country_id integer
 * @var $auth_user_id integer
 * @var $country_array array
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

if (!$news_id = (int) f_igosja_request_get('news_id'))
{
    redirect('/wrong_page.php');
}

include(__DIR__ . '/include/sql/country_view.php');

if (!in_array($auth_user_id, array($country_array[0]['president_id'], $country_array[0]['vice_id'])))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT COUNT(`news_id`) AS `check`
        FROM `news`
        WHERE `news_id`=$news_id
        AND `news_country_id`=$num_get
        AND `news_user_id`=$auth_user_id
        LIMIT 1";
$news_sql = f_igosja_mysqli_query($sql);

$news_array = $news_sql->fetch_all(MYSQLI_ASSOC);

if (0 == $news_array[0]['check'])
{
    redirect('/wrong_page.php');
}

$sql = "DELETE FROM `news`
        WHERE `news_id`=$news_id
        LIMIT 1";
f_igosja_mysqli_query($sql);

f_igosja_session_front_flash_set('success', 'Новость успешно удалена.');

redirect('/country_news.php?num=' . $num_get);