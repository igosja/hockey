<?php

include (__DIR__ . '/../include/include.php');

$num_get = (int) f_igosja_get('num');

if (0 != $num_get)
{
    $sql = "DELETE FROM `vote`
            WHERE `vote_id`='$num_get'
            LIMIT 1";
    igosja_db_query($sql);
}

redirect('/admin/vote_list.php');