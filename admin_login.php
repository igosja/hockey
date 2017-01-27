<?php

include (__DIR__ . '/include/include.php');

if (isset($auth_user_id) && 2 == $auth_userrole_id)
{
    redirect('/admin');
}

if ($data = f_igosja_request_post('data'))
{
    if (!isset($data['login']) || !isset($data['password']))
    {
        $_SESSION['message']['class']   = 'danger';
        $_SESSION['message']['text']    = 'Неправильная комбинация логин/пароль.';

        refresh();
    }

    $login      = trim($data['login']);
    $password   = f_igosja_hash_password($data['password']);

    $sql = "SELECT `user_id`,
                   `user_userrole_id`
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
        $_SESSION['message']['class']   = 'danger';
        $_SESSION['message']['text']    = 'Неправильная комбинация логин/пароль.';

        refresh();
    }

    $user_array = $user_sql->fetch_all(1);

    if (2 > $user_array[0]['user_userrole_id'])
    {
        $_SESSION['message']['class']   = 'danger';
        $_SESSION['message']['text']    = 'Неправильная комбинация логин/пароль.';

        refresh();
    }

    $_SESSION['user_id'] = $user_array[0]['user_id'];

    redirect('/admin');
}

include (__DIR__ . '/view/layout/admin.php');