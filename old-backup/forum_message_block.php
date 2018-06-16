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

$sql = "SELECT `forumtheme_id`,
               CEIL((`forumtheme_count_message`-1)/20) AS `last_page`
        FROM `forummessage`
        LEFT JOIN `forumtheme`
        ON `forummessage_forumtheme_id`=`forumtheme_id`
        WHERE `forummessage_id`=$num_get
        LIMIT 1";
$forummessage_sql = f_igosja_mysqli_query($sql);

if (0 == $forummessage_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$forummessage_array = $forummessage_sql->fetch_all(MYSQLI_ASSOC);

$forumtheme_id = $forummessage_array[0]['forumtheme_id'];

$sql = "UPDATE `forummessage`
        SET `forummessage_blocked`=1-`forummessage_blocked`
        WHERE `forummessage_id`=$num_get
        LIMIT 1";
f_igosja_mysqli_query($sql);

f_igosja_session_front_flash_set('success', 'Изменения успешно сохранены.');

redirect('/forum_theme.php?num=' . $forumtheme_id . '&page=' . $forummessage_array[0]['last_page']);