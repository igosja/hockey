<?php

include(__DIR__ . '/../include/include.php');

if ($num_get = (int) f_igosja_request_get('num'))
{
    $sql = "SELECT COUNT(`forumtheme_id`) AS `check`
            FROM `forumtheme`
            WHERE `forumtheme_forumgroup_id`=$num_get";
    $forumtheme_sql = f_igosja_mysqli_query($sql);

    $forumtheme_array = $forumtheme_sql->fetch_all(MYSQLI_ASSOC);

    if (0 == $forumtheme_array[0]['check'])
    {
        $sql = "DELETE FROM `forumgroup`
                WHERE `forumgroup_id`=$num_get
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }
    else
    {
        f_igosja_session_back_flash_set('danger', 'В группе есть темы.');
    }
}

redirect('/admin/forumgroup_list.php');