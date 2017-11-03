<?php

/**
 * @var $auth_user_id integer
 */

include(__DIR__ . '/include/include.php');

if (isset($auth_user_id))
{
    redirect('/');
}

if (!$data = f_igosja_request_get('data'))
{
    $_SESSION['message']['class']   = 'error';
    $_SESSION['message']['text']    = 'Пользователь не найден.';

    redirect('/password.php');
}

if (!isset($data['code']))
{
    $_SESSION['message']['class']   = 'error';
    $_SESSION['message']['text']    = 'Пользователь не найден.';

    redirect('/password.php');
}

$code = $data['code'];

$sql = "SELECT COUNT(`user_id`) AS `count`
        FROM `user`
        WHERE `user_code`=?";
$prepare = $mysqli->prepare($sql);
$prepare->bind_param('s', $code);
$prepare->execute();

$user_sql = $prepare->get_result();

$prepare->close();

$user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

if (!$user_array[0]['count'])
{
    $_SESSION['message']['class']   = 'error';
    $_SESSION['message']['text']    = 'Пользователь не найден.';

    redirect('/password.php');
}

if ($data = f_igosja_request_post('data'))
{
    if (!isset($data['password']) || empty($data['password']))
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Введите пароль.';

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

    $_SESSION['message']['class']   = 'success';
    $_SESSION['message']['text']    = 'Пароль успешно изменен.';

    redirect('/password.php');
}

$seo_title          = 'Восстановление пароля';
$seo_description    = 'Восстановление пароля на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'восстановление пароля';

include(__DIR__ . '/view/layout/main.php');