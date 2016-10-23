<?php

include (__DIR__ . '/include/include.php');

if (isset($auth_user_id))
{
    redirect('/');
}

if (!$code = f_igosja_get('data'))
{
    $_SESSION['message']['class'] = 'error';
    $_SESSION['message']['text'] = 'Пользователь не найден.';

    redirect('/password.php');
}

if (!isset($code['code']))
{
    $_SESSION['message']['class'] = 'error';
    $_SESSION['message']['text'] = 'Пользователь не найден.';

    redirect('/password.php');
}

$code = $code['code'];

$sql = "SELECT COUNT(`user_id`) AS `count`
        FROM `user`
        WHERE `user_code`=?";
$prepare = $mysqli->prepare($sql);
$prepare->bind_param('s', $code);
$prepare->execute();

$user_sql = $prepare->get_result();

$prepare->close();

$user_array = $user_sql->fetch_all(1);

if (!$user_array[0]['count'])
{
    $_SESSION['message']['class'] = 'error';
    $_SESSION['message']['text'] = 'Пользователь не найден.';

    redirect('/password.php');
}

if ($data = f_igosja_post('data'))
{
    if (!isset($data['password']))
    {
        $_SESSION['message']['class'] = 'error';
        $_SESSION['message']['text'] = 'Введите пароль.';

        refresh();
    }

    if (empty($data['password']))
    {
        $_SESSION['message']['class'] = 'error';
        $_SESSION['message']['text'] = 'Введите пароль.';

        refresh();
    }

    $password = f_igosja_hash_password($data['password']);

    $sql = "UPDATE `user`
            SET `user_password`=?
            WHERE `user_code`=?
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ss', $password, $code);
    $prepare->execute();

    $_SESSION['message']['class'] = 'success';
    $_SESSION['message']['text'] = 'Пароль успешно изменен.';

    redirect('/');
}

include (__DIR__ . '/view/layout/main.php');