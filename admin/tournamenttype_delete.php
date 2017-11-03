<?php

include(__DIR__ . '/../include/include.php');

if ($num_get = (int) f_igosja_request_get('num'))
{
    $sql = "DELETE FROM `tournamenttype`
            WHERE `tournamenttype_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql);
}

redirect('/admin/tournamenttype_list.php');