<?php

include(__DIR__ . '/../include/include.php');

if ($num_get = (int) f_igosja_request_get('num'))
{
    $sql = "SELECT `logo_team_id`
            FROM `logo`
            WHERE `logo_id`=$num_get
            LIMIT 1";
    $logo_sql = f_igosja_mysqli_query($sql);

    if (0 != $logo_sql->num_rows)
    {
        $logo_array = $logo_sql->fetch_all(MYSQLI_ASSOC);

        $file = __DIR__ . '/../upload/img/team/125/' . $logo_array[0]['logo_team_id'] . '.png';

        if (file_exists($file))
        {
            unlink($file);
        }
    }

    $sql = "DELETE FROM `logo`
            WHERE `logo_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql);
}

redirect('/admin/logo_list.php');