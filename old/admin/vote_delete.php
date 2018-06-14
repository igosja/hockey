<?php

include(__DIR__ . '/../include/include.php');

if ($num_get = (int) f_igosja_request_get('num'))
{
    $sql = "DELETE FROM `vote`
            WHERE `vote_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    $sql = "DELETE FROM `voteanswer`
            WHERE `voteanswer_vote_id`=$num_get";
    f_igosja_mysqli_query($sql);

    $sql = "DELETE FROM `voteuser`
            WHERE `voteuser_vote_id`=$num_get";
    f_igosja_mysqli_query($sql);
}

redirect('/admin/vote_list.php');