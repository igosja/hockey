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

if ($auth_date_block_forum >= time() || $auth_date_block_comment >= time())
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

$sql = "SELECT `forumtheme_id`,
               `forumgroup_id`
        FROM `forummessage`
        LEFT JOIN `forumtheme`
        ON `forummessage_forumtheme_id`=`forumtheme_id`
        LEFT JOIN `forumgroup`
        ON `forumtheme_forumgroup_id`=`forumgroup_id`
        WHERE `forummessage_id`=$num_get
        $where
        LIMIT 1";
$forummessage_sql = f_igosja_mysqli_query($sql);

if (0 == $forummessage_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$forummessage_array = $forummessage_sql->fetch_all(MYSQLI_ASSOC);

$forumtheme_id = $forummessage_array[0]['forumtheme_id'];
$forumgroup_id = $forummessage_array[0]['forumgroup_id'];

$sql = "DELETE FROM `forummessage`
        WHERE `forummessage_id`=$num_get
        LIMIT 1";
f_igosja_mysqli_query($sql);

$sql = "DELETE FROM `complain`
        WHERE `complain_url`='/forum_message_update.php?num=$num_get'";
f_igosja_mysqli_query($sql);

$sql = "UPDATE `forumtheme`
        SET `forumtheme_count_message`=`forumtheme_count_message`-1
        WHERE `forumtheme_id`=$forumtheme_id
        LIMIT 1";
f_igosja_mysqli_query($sql);

$sql = "UPDATE `forumgroup`
        SET `forumgroup_count_message`=`forumgroup_count_message`-1
        WHERE `forumgroup_id`=$forumgroup_id
        LIMIT 1";
f_igosja_mysqli_query($sql);

$sql = "SELECT CEIL((`forumtheme_count_message`-1)/20) AS `last_page`
        FROM `forumtheme`
        WHERE `forumtheme_id`=$forumtheme_id
        LIMIT 1";
$last_page_sql = f_igosja_mysqli_query($sql);

$last_page_array = $last_page_sql->fetch_all(MYSQLI_ASSOC);

f_igosja_session_front_flash_set('success', 'Сообшение успешно удалено.');

redirect('/forum_theme.php?num=' . $forumtheme_id . '&page=' . $last_page_array[0]['last_page']);