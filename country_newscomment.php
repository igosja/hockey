<?php

/**
 * @var $country_array array
 */

include(__DIR__ . '/include/include.php');

if (!$news_id = (int) f_igosja_request_get('news_id'))
{
    redirect('/wrong_page.php');
}

if (!$num_get = (int) f_igosja_request_get('num'))
{
    if (isset($auth_country_id))
    {
        if (!$num_get = $auth_country_id)
        {
            redirect('/wrong_page.php');
        }
    }
}

include(__DIR__ . '/include/sql/country_view.php');

$sql = "SELECT `news_date`,
               `news_text`,
               `news_title`,
               `user_id`,
               `user_login`
        FROM `news`
        LEFT JOIN `user`
        ON `news_user_id`=`user_id`
        LEFT JOIN `country`
        ON `news_country_id`=`country_id`
        WHERE `news_id`=$news_id
        AND `news_country_id`=$num_get
        LIMIT 1";
$news_sql = f_igosja_mysqli_query($sql, false);

if (0 == $news_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$news_array = $news_sql->fetch_all(1);

if ($data = f_igosja_request_post('data'))
{
    if (isset($auth_user_id) && isset($data['text']))
    {
        $text = htmlspecialchars($data['text']);
        $text = trim($text);

        if (!empty($text))
        {
            $sql = "INSERT INTO `newscomment`
                    SET `newscomment_date`=UNIX_TIMESTAMP(),
                        `newscomment_news_id`=$news_id,
                        `newscomment_text`=?,
                        `newscomment_user_id`=$auth_user_id";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $text);
            $prepare->execute();
            $prepare->close();

            $_SESSION['message']['class'] = 'success';
            $_SESSION['message']['text'] = 'Комментарий успешно сохранен.';
        }
    }

    refresh();
}

if (!$page = (int) f_igosja_request_get('page'))
{
    $page = 1;
}

$limit  = 20;
$offset = ($page - 1) * $limit;

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `newscomment_date`,
               `newscomment_text`,
               `user_id`,
               `user_login`
        FROM `newscomment`
        LEFT JOIN `user`
        ON `newscomment_user_id`=`user_id`
        WHERE `newscomment_news_id`=$news_id
        ORDER BY `newscomment_id` ASC
        LIMIT $offset, $limit";
$newscomment_sql = f_igosja_mysqli_query($sql, false);

$newscomment_array = $newscomment_sql->fetch_all(1);

$sql = "SELECT FOUND_ROWS() AS `count`";
$total = f_igosja_mysqli_query($sql, false);
$total = $total->fetch_all(1);
$total = $total[0]['count'];

$count_page = ceil($total / $limit);

$seo_title          = $country_array[0]['country_name'] . '. Новости фередации. Комментарии';
$seo_description    = $country_array[0]['country_name'] . '. Новости фередации и комментарии на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $country_array[0]['country_name'] . ' новости фередации комментарии';

include(__DIR__ . '/view/layout/main.php');