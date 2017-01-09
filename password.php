<?php

include (__DIR__ . '/include/include.php');

if (isset($auth_user_id))
{
    redirect('/');
}

if ($data = f_igosja_request_post('data'))
{
    if (isset($data['login']))
    {
        $login = trim($data['login']);
    }
    else
    {
        $login = '';
    }

    if (isset($data['email']))
    {
        $email = trim($data['email']);
    }
    else
    {
        $email = '';
    }

    if (empty($login) && empty($email))
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Введите логин/email.';

        refresh();
    }

    $sql = "SELECT `user_code`,
                   `user_email`
            FROM `user`
            WHERE `user_email`=?
            OR `user_login`=?
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ss', $email, $login);
    $prepare->execute();

    $user_sql = $prepare->get_result();

    $prepare->close();

    if (0 == $user_sql->num_rows)
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Пользователь не найден.';

        refresh();
    }

    $user_array = $user_sql->fetch_all(1);
    $code       = $user_array[0]['user_code'];
    $email      = $user_array[0]['user_email'];

    $href = 'http://' . $_SERVER['HTTP_HOST'] . '/password_restore.php?data[code]=' . $code;
    $email_text =
        'Вы запросили восстановление пароля на сайте Виртуальной Хоккейной Лиги.<br>
        Чтобы восстановить пароль перейдите по ссылке <a href="' . $href . '">' . $href . '</a>.<br/><br/>
        Администрация Виртуальной Хоккейной Лиги';

    $mail = new Mail();
    $mail->setTo($email);
    $mail->setSubject('Восстановление пароля на сайте Виртуальной Хоккейной Лиги');
    $mail->setHtml($email_text);
    $mail->send();

    $_SESSION['message']['class']   = 'success';
    $_SESSION['message']['text']    = 'Данные успешно отправлены на email.';

    refresh();
}

include (__DIR__ . '/view/layout/main.php');