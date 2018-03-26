<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "DELETE FROM `rentcomment`
        WHERE `rentcomment_id`=$num_get
        LIMIT 1";
f_igosja_mysqli_query($sql);

redirect('/admin/moderation_rentcomment.php');