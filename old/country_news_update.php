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

$sql = "SELECT `news_text`,
               `news_title`
        FROM `news`
        WHERE `news_id`=$news_id
        AND `news_country_id`=$num_get
        AND `news_user_id`=$auth_user_id
        LIMIT 1";
$news_sql = f_igosja_mysqli_query($sql);

if (0 == $news_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$news_array = $news_sql->fetch_all(MYSQLI_ASSOC);

if ($data = f_igosja_request_post('data'))
{
    $title  = htmlspecialchars($data['title']);
    $title  = trim($title);
    $text   = htmlspecialchars($data['text']);
    $text   = trim($text);

    if (!empty($text) && !empty($title))
    {
        $sql = "UPDATE `news`
                SET `news_text`=?,
                    `news_title`=?
                WHERE `news_id`=$news_id";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('ss', $text, $title);
        $prepare->execute();
        $prepare->close();

        f_igosja_session_front_flash_set('success', 'Новость успешно сохранена.');
    }

    refresh();
}

$seo_title          = $country_array[0]['country_name'] . '. Редактирование новости фередации';
$seo_description    = $country_array[0]['country_name'] . '. Редактирование новости фередации на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $country_array[0]['country_name'] . ' редактирование новости фередации';

include(__DIR__ . '/view/layout/main.php');