<?php

/**
 * @var $auth_date_block_comment integer
 * @var $auth_date_block_forum integer
 * @var $auth_user_id integer
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

if ($auth_date_block_forum >= time() || $auth_date_block_comment >= time())
{
    redirect('/wrong_page.php');
}

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `forumchapter_id`,
               `forumchapter_name`,
               `forumgroup_id`,
               `forumgroup_name`
        FROM `forumgroup`
        LEFT JOIN `forumchapter`
        ON `forumgroup_forumchapter_id`=`forumchapter_id`
        WHERE `forumgroup_id`=$num_get
        LIMIT 1";
$forumgroup_sql = f_igosja_mysqli_query($sql);

if (0 == $forumgroup_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$forumgroup_array = $forumgroup_sql->fetch_all(MYSQLI_ASSOC);

if ($data = f_igosja_request_post('data'))
{
    if (isset($data['name']) && isset($data['text']))
    {
        $name = trim($data['name']);
        $text = trim($data['text']);

        if (!empty($name) && !empty($text))
        {
            $name = htmlspecialchars($name);
            $text = htmlspecialchars($text);

            $sql = "INSERT INTO `forumtheme`
                    SET `forumtheme_count_message`=1,
                        `forumtheme_date`=UNIX_TIMESTAMP(),
                        `forumtheme_forumgroup_id`=$num_get,
                        `forumtheme_last_date`=UNIX_TIMESTAMP(),
                        `forumtheme_last_user_id`=$auth_user_id,
                        `forumtheme_name`=?,
                        `forumtheme_user_id`=$auth_user_id";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $name);
            $prepare->execute();
            $prepare->close();

            $forumtheme_id = $mysqli->insert_id;

            $sql = "INSERT INTO `forummessage`
                    SET `forummessage_date`=UNIX_TIMESTAMP(),
                        `forummessage_forumtheme_id`=$forumtheme_id,
                        `forummessage_text`=?,
                        `forummessage_user_id`=$auth_user_id";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $text);
            $prepare->execute();
            $prepare->close();

            $forummessage_id = $mysqli->insert_id;

            $sql = "UPDATE `forumtheme`
                    SET `forumtheme_last_forummessage_id`=$forummessage_id
                    WHERE `forumtheme_id`=$forumtheme_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `forumgroup`
                    SET `forumgroup_count_theme`=`forumgroup_count_theme`+1,
                        `forumgroup_count_message`=`forumgroup_count_message`+1,
                        `forumgroup_last_date`=UNIX_TIMESTAMP(),
                        `forumgroup_last_forummessage_id`=$forummessage_id,
                        `forumgroup_last_forumtheme_id`=$forumtheme_id,
                        `forumgroup_last_user_id`=$auth_user_id
                    WHERE `forumgroup_id`=$num_get
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            f_igosja_session_front_flash_set('success', 'Тема успешно создана.');

            redirect('/forum_theme.php?num=' . $forumtheme_id);
        }
    }

    refresh();
}

$seo_title          = 'Создание темы - ' . $forumgroup_array[0]['forumgroup_name'] . ' - Форум';
$seo_description    = 'Создание темы - ' . $forumgroup_array[0]['forumgroup_name'] . ' - Форум сайта Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'cоздание темы ' . $forumgroup_array[0]['forumgroup_name'] . ' форум';

include(__DIR__ . '/view/layout/main.php');