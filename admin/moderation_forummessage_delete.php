<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
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

redirect('/admin/moderation_forummessage.php');