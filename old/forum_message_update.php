<?php

/**
 * @var $auth_date_block_comment integer
 * @var $auth_date_block_forum integer
 * @var $auth_user_id integer
 * @var $auth_userrole_id integer
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

if (USERROLE_USER == $auth_userrole_id)
{
    $where = "AND `forummessage_user_id`=$auth_user_id";
}
else
{
    $where = "";
}

$sql = "SELECT `forumchapter_id`,
               `forumchapter_name`,
               `forumgroup_id`,
               `forumgroup_name`,
               `forummessage_blocked`,
               `forummessage_text`,
               `forumtheme_id`,
               `forumtheme_name`,
               CEIL((`forumtheme_count_message`-1)/20) AS `last_page`
        FROM `forummessage`
        LEFT JOIN `forumtheme`
        ON `forummessage_forumtheme_id`=`forumtheme_id`
        LEFT JOIN `forumgroup`
        ON `forumtheme_forumgroup_id`=`forumgroup_id`
        LEFT JOIN `forumchapter`
        ON `forumgroup_forumchapter_id`=`forumchapter_id`
        WHERE `forummessage_id`=$num_get
        $where
        LIMIT 1";
$forummessage_sql = f_igosja_mysqli_query($sql);

if (0 == $forummessage_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$forummessage_array = $forummessage_sql->fetch_all(MYSQLI_ASSOC);

if (1 == $forummessage_array[0]['forummessage_blocked'])
{
    f_igosja_session_front_flash_set('warning', 'Сообщение заблокировано и не может быть отредактировано.');
}

$forumtheme_id = $forummessage_array[0]['forumtheme_id'];

$sql = "SELECT `forummessage_id`
        FROM `forummessage`
        WHERE `forummessage_forumtheme_id`=$forumtheme_id
        ORDER BY `forummessage_id` ASC
        LIMIT 1";
$forumheader_sql = f_igosja_mysqli_query($sql);

$forumheader_array = $forumheader_sql->fetch_all(MYSQLI_ASSOC);

$forumheader_id = $forumheader_array[0]['forummessage_id'];

if (($data = f_igosja_request_post('data')) && (0 == $forummessage_array[0]['forummessage_blocked']))
{
    if (isset($data['text']) && $auth_date_block_forum < time() && $auth_date_block_comment < time())
    {
        $text = trim($data['text']);

        if (!empty($text))
        {
            $text = htmlspecialchars($text);

            $sql = "UPDATE `forummessage`
                    SET `forummessage_check`=0,
                        `forummessage_date_update`=UNIX_TIMESTAMP(),
                        `forummessage_text`=?
                    WHERE `forummessage_id`=$num_get";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $text);
            $prepare->execute();
            $prepare->close();

            f_igosja_session_front_flash_set('success', 'Сообщение успешно отредактировано.');
        }
    }

    if ($forumheader_id == $num_get && isset($data['name']))
    {
        $name = trim($data['name']);

        if (!empty($name))
        {
            $name = htmlspecialchars($name);

            $sql = "UPDATE `forumtheme`
                    SET `forumtheme_name`=?
                    WHERE `forumtheme_id`=$forumtheme_id";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $name);
            $prepare->execute();
            $prepare->close();
        }
    }

    $sql = "SELECT CEIL((`forumtheme_count_message`-1)/20) AS `last_page`
            FROM `forumtheme`
            WHERE `forumtheme_id`=$forumtheme_id
            LIMIT 1";
    $last_page_sql = f_igosja_mysqli_query($sql);

    $last_page_array = $last_page_sql->fetch_all(MYSQLI_ASSOC);

    redirect('/forum_theme.php?num=' . $forummessage_array[0]['forumtheme_id'] . '&page=' . $last_page_array[0]['last_page']);
}

$seo_title          = 'Редактирование сообщения - ' . $forummessage_array[0]['forumtheme_name'] . ' - Форум';
$seo_description    = 'Редактирование сообщения - ' . $forummessage_array[0]['forumtheme_name'] . ' - Форум сайта Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'редактирование сообщения ' . $forummessage_array[0]['forumtheme_name'] . ' форум';

include(__DIR__ . '/view/layout/main.php');