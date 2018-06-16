<?php

/**
 * Перевіряемо наявніть користувача в БД за логіном
 * @param $login string логіном користувача
 * @return boolean результат перевірки (false - користувач присутній в БД)
 */
function f_igosja_check_user_by_login($login)
{
    global $mysqli;

    $sql = "SELECT COUNT(`user_id`) AS `count`
            FROM `user`
            WHERE `user_login`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $login);
    $prepare->execute();

    $check_sql = $prepare->get_result();

    $prepare->close();

    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

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