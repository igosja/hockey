<?php

/**
 * @var $auth_user_id integer
 * @var $auth_userrole_id integer
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

if (USERROLE_USER == $auth_userrole_id)
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
               `forumgroup_name`,
               `forummessage_text`,
               `forummessage_user_id`,
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
        LIMIT 1";
$forummessage_sql = f_igosja_mysqli_query($sql);

if (0 == $forummessage_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$forummessage_array = $forummessage_sql->fetch_all(MYSQLI_ASSOC);

$forumtheme_id = $forummessage_array[0]['forumtheme_id'];

if ($data = f_igosja_request_post('data'))
{
    if (!$newforumtheme_id = (int) $data['forumtheme_id'])
    {
        if (isset($data['name']) && !empty($data['name']) && $forumgroup_id = (int) $data['forumgroup_id'])
        {
            $user_id = $forummessage_array[0]['forummessage_user_id'];
            $name = trim($data['name']);
            $name = htmlspecialchars($name);

            $sql = "INSERT INTO `forumtheme`
                    SET `forumtheme_count_message`=0,
                        `forumtheme_date`=UNIX_TIMESTAMP(),
                        `forumtheme_forumgroup_id`=$forumgroup_id,
                        `forumtheme_last_date`=UNIX_TIMESTAMP(),
                        `forumtheme_last_user_id`=$user_id,
                        `forumtheme_name`=?,
                        `forumtheme_user_id`=$user_id";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $name);
            $prepare->execute();
            $prepare->close();

            $newforumtheme_id = $mysqli->insert_id;
        }
    }

    $sql = "UPDATE `forumtheme`
            SET `forumtheme_count_message`=`forumtheme_count_message`+1
            WHERE `forumtheme_id`=$newforumtheme_id
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `forumtheme`
            SET `forumtheme_count_message`=`forumtheme_count_message`-1
            WHERE `forumtheme_id`=$forumtheme_id
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `forummessage`
            SET `forummessage_forumtheme_id`=$newforumtheme_id
            WHERE `forummessage_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    f_igosja_session_front_flash_set('success', 'Сообщение успешно перемещено.');

    $sql = "SELECT CEIL((`forumtheme_count_message`-1)/20) AS `last_page`
            FROM `forumtheme`
            WHERE `forumtheme_id`=$newforumtheme_id
            LIMIT 1";
    $last_page_sql = f_igosja_mysqli_query($sql);

    $last_page_array = $last_page_sql->fetch_all(MYSQLI_ASSOC);

    redirect('/forum_theme.php?num=' . $newforumtheme_id . '&page=' . $last_page_array[0]['last_page']);
}

$sql = "SELECT `forumchapter_name`,
               `forumgroup_name`,
               `forumtheme_id`,
               `forumtheme_name`
        FROM `forumtheme`
        LEFT JOIN `forumgroup`
        ON `forumtheme_forumgroup_id`=`forumgroup_id`
        LEFT JOIN `forumchapter`
        ON `forumgroup_forumchapter_id`=`forumchapter_id`
        WHERE `forumgroup_country_id`=0
        ORDER BY `forumchapter_id`, `forumgroup_name`, `forumtheme_name`";
$forumtheme_sql = f_igosja_mysqli_query($sql);

$forumtheme_array = $forumtheme_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `forumchapter_name`,
               `forumgroup_id`,
               `forumgroup_name`
        FROM `forumgroup`
        LEFT JOIN `forumchapter`
        ON `forumgroup_forumchapter_id`=`forumchapter_id`
        WHERE `forumgroup_country_id`=0
        ORDER BY `forumchapter_id`, `forumgroup_name`";
$forumgroup_sql = f_igosja_mysqli_query($sql);

$forumgroup_array = $forumgroup_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = 'Перемещение сообщения - ' . $forummessage_array[0]['forumtheme_name'] . ' - Форум';
$seo_description    = 'Перемещение сообщения - ' . $forummessage_array[0]['forumtheme_name'] . ' - Форум сайта Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'перемещение сообщения ' . $forummessage_array[0]['forumtheme_name'] . ' форум';

include(__DIR__ . '/view/layout/main.php');