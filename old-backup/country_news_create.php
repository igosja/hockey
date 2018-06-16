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

include(__DIR__ . '/include/sql/country_view.php');

if (!in_array($auth_user_id, array($country_array[0]['president_id'], $country_array[0]['vice_id'])))
{
    redirect('/wrong_page.php');
}

if ($data = f_igosja_request_post('data'))
{
    $title  = htmlspecialchars($data['title']);
    $title  = trim($title);
    $text   = htmlspecialchars($data['text']);
    $text   = trim($text);

    if (!empty($text) && !empty($title))
    {
        $sql = "INSERT INTO `news`
                SET `news_title`=?,
                    `news_text`=?,
                    `news_country_id`=$num_get,
                    `news_date`=UNIX_TIMESTAMP(),
                    `news_user_id`=$auth_user_id";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('ss', $title, $text);
        $prepare->execute();
        $prepare->close();

        f_igosja_session_front_flash_set('success', 'Новость успешно сохранена.');
    }

    refresh();
}

$seo_title          = $country_array[0]['country_name'] . '. Создание новости фередации';
$seo_description    = $country_array[0]['country_name'] . '. Создание новости фередации на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $country_array[0]['country_name'] . ' создание новости фередации';

include(__DIR__ . '/view/layout/main.php');