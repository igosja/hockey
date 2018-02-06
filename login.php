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
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Неправильная комбинация логин/пароль.';

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
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Неправильная комбинация логин/пароль.';

        redirect('/');
    }

    $user_array             = $user_sql->fetch_all(MYSQLI_ASSOC);
    $_SESSION['user_id']    = $user_array[0]['user_id'];

    setcookie('login_code', $user_array[0]['user_code'] . '-' . f_igosja_login_code($user_array[0]['user_code']), time() + 31536000); //365 днів

    redirect('/team_view.php');
}

redirect('/');