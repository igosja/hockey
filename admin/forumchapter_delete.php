<?php

include(__DIR__ . '/../include/include.php');

if ($num_get = (int) f_igosja_request_get('num'))
{
    $sql = "SELECT COUNT(`forumgroup_id`) AS `check`
            FROM `forumgroup`
            WHERE `forumgroup_forumchapter_id`=$num_get";
    $forumgroup_sql = f_igosja_mysqli_query($sql);

    $forumgroup_array = $forumgroup_sql->fetch_all(MYSQLI_ASSOC);

    if (0 == $forumgroup_array[0]['check'])
    {
        $sql = "DELETE FROM `forumchapter`
                WHERE `forumchapter_id`=$num_get
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }
    else
    {
        f_igosja_session_back_flash_set('danger', 'В разделе есть группы.');
    }
}

redirect('/admin/forumchapter_list.php');