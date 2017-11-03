<?php

/**
 * Порівнюємо введений пароль с тим, що є в БД
 * @param $password string пароль з форми авторизації
 * @return boolean результат перевірки (true - пароль вірний)
 */
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
        $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

        if ($user_array[0]['user_password'] == $password)
        {
            $result = true;
        }
    }

    return $result;
}