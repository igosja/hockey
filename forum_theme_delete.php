<?php

/**
 * @var $auth_date_forum integer
 * @var $auth_user_id integer
 * @var $auth_userrole_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

if (USERROLE_USER == $auth_userrole_id)
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `forumtheme_count_message`,
               `forumtheme_forumgroup_id`
        FROM `forumtheme`
        WHERE `forumtheme_id`=$num_get
        LIMIT 1";
$forumtheme_sql = f_igosja_mysqli_query($sql);

if (0 == $forumtheme_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$forumtheme_array = $forumtheme_sql->fetch_all(MYSQLI_ASSOC);

$count_message = $forumtheme_array[0]['forumtheme_count_message'];
$forumgroup_id = $forumtheme_array[0]['forumtheme_forumgroup_id'];


$sql = "UPDATE `forumgroup`
        SET `forumgroup_count_theme`=`forumgroup_count_theme`-1,
            `forumgroup_count_message`=`forumgroup_count_message`-$count_message
        WHERE `forumgroup_id`=$forumgroup_id
        LIMIT 1";
f_igosja_mysqli_query($sql);

$sql = "DELETE FROM `forumtheme`
        WHERE `forumtheme_id`=$num_get
        LIMIT 1";
f_igosja_mysqli_query($sql);

$sql = "DELETE FROM `forummessage`
        WHERE `forummessage_forumtheme_id`=$num_get";
f_igosja_mysqli_query($sql);

redirect('/forum_group.php?num=' . $forumtheme_array[0]['forumtheme_forumgroup_id']);