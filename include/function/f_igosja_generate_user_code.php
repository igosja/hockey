<?php

/**
 * Генерація ключа, по котрому користувач может авторизоватися або підтвержити email
 * @return string код
 */
function f_igosja_generate_user_code()
{
    $code = md5(uniqid(rand(), 1));

    $sql = "SELECT COUNT(`user_id`) AS `count`
            FROM `user`
            WHERE `user_code`='$code'";
    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

    $check = $check_array[0]['count'];

    if ($check)
    {
        $code = f_igosja_generate_user_code();
    }

    return $code;
}