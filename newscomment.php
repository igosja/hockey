<?php

include (__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `news_date`,
               `news_text`,
               `news_title`,
               `user_id`,
               `user_login`
        FROM `news`
        LEFT JOIN `user`
        ON `news_user_id`=`user_id`
        WHERE `news_id`='$num_get'
        LIMIT 1";
$news_sql = igosja_db_query($sql);

if (0 == $news_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$news_array = $news_sql->fetch_all(1);

if ($data = f_igosja_post('data'))
{
    if (isset($auth_user_id))
    {
        if (isset($data['text']) && !empty(trim($data['text'])))
        {
            $text = trim($data['text']);

            $sql = "INSERT INTO `newscomment`
                    SET `newscomment_date`=UNIX_TIMESTAMP(),
                        `newscomment_news_id`='$num_get',
                        `newscomment_text`=?,
                        `newscomment_user_id`='$auth_user_id'";
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

$sql = "SELECT `newscomment_date`,
               `newscomment_text`,
               `user_id`,
               `user_login`
        FROM `newscomment`
        LEFT JOIN `user`
        ON `newscomment_user_id`=`user_id`
        WHERE `newscomment_news_id`='$num_get'
        ORDER BY `newscomment_id` ASC";
$newscomment_sql = igosja_db_query($sql);

$newscomment_array = $newscomment_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');