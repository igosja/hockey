<?php

/**
 * @var $auth_user_id integer
 */

include(__DIR__ . '/include/include.php');

if (isset($auth_user_id))
{
    redirect('/team_view.php');
}

if ($data = f_igosja_request_post('data'))
{
    if (!isset($data['login']) || !isset($data['password']))
    {
        f_igosja_session_front_flash_set('error', 'Неправильная комбинация логин/пароль.');

        redirect('/');
    }

    $login      = trim($data['login']);
    $password   = f_igosja_hash_password($data['password']);

    $sql = "SELECT `user_code`,
                   `user_id`
            FROM `user`
            WHERE `user_login`=?
            AND `user_password`=?
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ss', $login, $password);
    $prepare->execute();

    $user_sql = $prepare->get_result();

    $prepare->close();

    if (!$user_sql->num_rows)
    {
        f_igosja_session_front_flash_set('error', 'Неправильная комбинация логин/пароль.');

        redirect('/');
    }

    $user_array             = $user_sql->fetch_all(MYSQLI_ASSOC);
    $_SESSION['user_id']    = $user_array[0]['user_id'];

    if ($user_code = f_igosja_cookie('computer_code'))
    {
        $session_user_id = $_SESSION['user_id'];

        $sql = "SELECT `user_id`
                FROM `user`
                WHERE `user_code`=?
                AND `user_id`!=$session_user_id
                LIMIT 1";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('s', $user_code);
        $prepare->execute();

        $child_sql = $prepare->get_result();

        $prepare->close();

        if (0 != $child_sql->num_rows)
        {
            $child_array = $child_sql->fetch_all(MYSQLI_ASSOC);

            $user_id = $child_array[0]['user_id'];

            $sql = "SELECT COUNT(`onecomputer_id`) AS `count`
                    FROM `onecomputer`
                    WHERE (`onecomputer_child_id`=$user_id
                    AND `onecomputer_user_id`=$session_user_id)
                    OR (`onecomputer_child_id`=$session_user_id
                    AND `onecomputer_user_id`=$user_id)";
            $check_sql = f_igosja_mysqli_query($sql);

            $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

            if (0 == $check_array[0]['count'])
            {
                $sql = "INSERT INTO `onecomputer`
                        SET `onecomputer_date`=UNIX_TIMESTAMP(),
                            `onecomputer_child_id`=$user_id,
                            `onecomputer_user_id`=$session_user_id";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $sql = "UPDATE `onecomputer`
                        SET `onecomputer_count`=`onecomputer_count`+1,
                            `onecomputer_date`=UNIX_TIMESTAMP()
                        WHERE (`onecomputer_child_id`=$user_id
                        AND `onecomputer_user_id`=$session_user_id)
                        OR (`onecomputer_child_id`=$session_user_id
                        AND `onecomputer_user_id`=$user_id)";
                f_igosja_mysqli_query($sql);
            }
        }
    }

    setcookie('login_code', $user_array[0]['user_code'] . '-' . f_igosja_login_code($user_array[0]['user_code']), time() + 31536000); //365 днів
    setcookie('computer_code', $user_array[0]['user_code'], time() + 31536000); //365 днів

    redirect('/team_view.php');
}

redirect('/');