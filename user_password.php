<?php

/**
 * @var $auth_user_id integer
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

$num_get = $auth_user_id;

include(__DIR__ . '/include/sql/user_view.php');

if ($data = f_igosja_request_post('data'))
{
    if (!isset($data['password_old']) || empty($data['password_old']))
    {
        $check_password_old = false;

        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Введите текущий пароль.';

        refresh();
    }
    else
    {
        if (!f_igosja_check_user_password($data['password_old']))
        {
            $check_password_old = false;

            $_SESSION['message']['class']   = 'error';
            $_SESSION['message']['text']    = 'Текущий пароль неверен.';

            refresh();
        }

        $check_password_old = true;
    }

    if (!isset($data['password_new']) || empty($data['password_new']))
    {
        $check_password_new = false;

        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Введите новый пароль.';

        refresh();
    }
    else
    {
        $check_password_new = true;
    }

    if (!isset($data['password_confirm']) || empty($data['password_confirm']))
    {
        $check_password_confirm = false;

        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Повторите новый пароль.';

        refresh();
    }
    else
    {
        if ($data['password_new'] != $data['password_confirm'])
        {
            $check_password_confirm = false;

            $_SESSION['message']['class']   = 'error';
            $_SESSION['message']['text']    = 'Новые пароли не совпадают.';

            refresh();
        }

        $check_password_confirm = true;
    }

    if ($check_password_old && $check_password_new && $check_password_confirm)
    {
        $password = f_igosja_hash_password($data['password_new']);

        $sql = "UPDATE `user`
                SET `user_password`='$password'
                WHERE `user_id`=$auth_user_id
                LIMIT 1";
        f_igosja_mysqli_query($sql, false);

        $_SESSION['message']['class']   = 'success';
        $_SESSION['message']['text']    = 'Пароль успешно изменен.';

        refresh();
    }
}

$seo_title          = $user_array[0]['user_login'] . '. Смена пароля';
$seo_description    = $user_array[0]['user_login'] . '. Смена пароля на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $user_array[0]['user_login'] . ' Смена пароля';

include(__DIR__ . '/view/layout/main.php');