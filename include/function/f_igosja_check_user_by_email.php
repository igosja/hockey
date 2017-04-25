<?php

/**
 * Проверяем, есть ли пользователь с таким email
 * @param $email string email пользователя
 * @return boolean результат проверки (false - пользователь есть в системе)
 */
function f_igosja_check_user_by_email($email)
{
    global $mysqli;

    $sql = "SELECT COUNT(`user_id`) AS `count`
            FROM `user`
            WHERE `user_email`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $email);
    $prepare->execute();

    $check_sql = $prepare->get_result();

    $prepare->close();

    $check_array = $check_sql->fetch_all(1);

    $check = $check_array[0]['count'];

    if ($check)
    {
        $result = false;
    }
    else
    {
        $result = true;
    }

    return $result;
}