<?php

include (__DIR__ . '/../include/include.php');

$num_get = (int) f_igosja_request_get('num');

if (0 != $num_get)
{
    $sql = "DELETE FROM `vote`
            WHERE `vote_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    $sql = "DELETE `voteanswer`
            WHERE `voteanswer_vote_id`=$num_get";
    f_igosja_mysqli_query($sql);

    $sql = "DELETE `voteuser`
            WHERE `voteuser_vote_id`=$num_get";
    f_igosja_mysqli_query($sql);
}

redirect('/admin/vote_list.php');