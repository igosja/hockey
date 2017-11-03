<?php

include(__DIR__ . '/../include/include.php');

if ($num_get = (int) f_igosja_request_get('num'))
{
    $sql = "UPDATE `vote`
            SET `vote_date`=UNIX_TIMESTAMP(),
                `vote_votestatus_id`=" . VOTESTATUS_OPEN . "
            WHERE `vote_id`=$num_get
            AND `vote_votestatus_id`=" . VOTESTATUS_NEW . "
            LIMIT 1";
    f_igosja_mysqli_query($sql);
}

redirect('/admin/vote_list.php');