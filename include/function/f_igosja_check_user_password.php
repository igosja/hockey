<?php

function f_igosja_check_user_password($password)
{
    global $auth_user_id;

    $result = false;

    $password = f_igosja_hash_password($password);

    $sql = "SELECT `user_password`
            FROM `user`
            WHERE `user_id`=$auth_user_id
            LIMIT 1";
    $user_sql = f_igosja_mysqli_query($sql);

    if ($user_sql->num_rows)
    {
        $user_array = $user_sql->fetch_all(1);

        if ($user_array[0]['user_password'] == $password)
        {
            $result = true;
        }
    }

    return $result;
}