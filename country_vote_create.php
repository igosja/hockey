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

if ($num_get != $auth_country_id)
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
    $text       = htmlspecialchars($data['vote_text']);
    $text       = trim($text);
    $answer     = $data['voteanswer_text'];
    $country    = $data['vote_country'];

    if (!empty($text) && count($answer) > 0)
    {
        if (0 == $country)
        {
            $vote_country_id = 0;
        }
        else
        {
            $vote_country_id = $auth_country_id;
        }

        $sql = "INSERT INTO `vote`
                SET `vote_country_id`=$vote_country_id,
                    `vote_date`=UNIX_TIMESTAMP(),
                    `vote_text`=?,
                    `vote_user_id`=$auth_user_id";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('s', $text);
        $prepare->execute();
        $vote_id = $mysqli->insert_id;
        $prepare->close();

        $sql = "INSERT INTO `voteanswer`
                SET `voteanswer_text`=?,
                    `voteanswer_vote_id`=$vote_id";
        $prepare = $mysqli->prepare($sql);

        foreach ($answer as $item)
        {
            $item = trim($item);

            if (!empty($item))
            {
                $prepare->bind_param('s', $item);
                $prepare->execute();
            }
        }

        $prepare->close();

        f_igosja_session_front_flash_set('success', 'Голосование успешно создано и ожидает проверки модератором.');
    }

    refresh();
}

$seo_title          = $country_array[0]['country_name'] . '. Создание голосования в фередации';
$seo_description    = $country_array[0]['country_name'] . '. Создание голосования в фередации на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $country_array[0]['country_name'] . ' создание голосования в фередации';

include(__DIR__ . '/view/layout/main.php');