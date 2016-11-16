<?php

include (__DIR__ . '/../include/include.php');

$num_get = (int) f_igosja_get('num');

if (0 != $num_get)
{
    $sql = "UPDATE `vote`
            SET `vote_date`=UNIX_TIMESTAMP(),
                `vote_votestatus_id`='2'
            WHERE `vote_id`='$num_get'
            AND `vote_votestatus_id`='" . VOTESTATUS_NEW . "'
            LIMIT 1";
    igosja_db_query($sql);
}

redirect('/admin/vote_list.php');