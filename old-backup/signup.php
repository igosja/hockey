<?php

/**
 * @var $auth_user_id integer
 */

include(__DIR__ . '/include/include.php');

if (isset($auth_user_id))
{
    redirect('/');
}

if ($data = f_igosja_request_post('data'))
{
    if (!isset($data['password']) || empty($data['password']))
    {
        $check_password = false;

        f_igosja_session_front_flash_set('error', 'Введите пароль.');

        refresh();
    }
    else
    {
        $check_password = true;
    }

    if (isset($data['login']))
    {
        $login = htmlspecialchars($data['login']);
        $login = trim($login);
    }

    if (!isset($login) || empty($login))
    {
        $check_login = false;

        f_igosja_session_front_flash_set('error', 'Введите логин.');

        refresh();
    }
    else
    {
        $check_login = f_igosja_check_user_by_login($login);

        if (!$check_login)
        {
            f_igosja_session_front_flash_set('error', 'Такой логин уже занят.');

            refresh();
        }
    }

    if (isset($data['email']))
    {
        $email = htmlspecialchars($data['email']);
        $email = trim($email);
    }

    if (!isset($email) || empty($email))
    {
        $check_email = false;

        f_igosja_session_front_flash_set('error', 'Введите email.');

        refresh();
    }
    else
    {
        $check_email = f_igosja_check_user_by_email($email);

        if (!$check_email)
        {
            f_igosja_session_front_flash_set('error', 'Такой email уже занят.');

            refresh();
        }
    }

    if ($check_login && $check_email && $check_password)
    {
        $password   = f_igosja_hash_password($data['password']);
        $code       = f_igosja_generate_user_code();
        $ref_id     = f_igosja_cookie('user_referrer_id');

        if (!$ref_id)
        {
            $ref_id = 0;
        }

        $sql = "INSERT INTO `user`
                SET `user_code`='$code',
                    `user_date_register`=UNIX_TIMESTAMP(),
                    `user_email`=?,
                    `user_login`=?,
                    `user_password`='$password',
                    `user_referrer_id`=$ref_id";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('ss', $email, $login);
        $prepare->execute();

        $href = 'https://' . $_SERVER['HTTP_HOST'] . '/activation.php?data[code]=' . $code;
        $page = 'https://' . $_SERVER['HTTP_HOST'] . '/activation.php';
        $email_text =
            'Вы успешно зарегистрированы на сайте Виртуальной Хоккейной Лиги под логином
            <strong>' . $login . '</strong>.<br>
            Чтобы завершить регистрацию подтвердите свой email по ссылке <a href="' . $href . '" target="_blank">' . $href . '</a>
            или введите код <strong>' . $code . '</strong> на странице
            <a href="' . $page . '" target="_blank">' . $page . '</a>.';

        $mail = new Mail();
        $mail->setTo($email);
        $mail->setSubject('Регистрация на сайте Виртуальной Хоккейной Лиги');
        $mail->setHtml($email_text);
        $mail->send();

        f_igosja_session_front_flash_set('success', 'Регистрация прошла успешно. Осталось активировать ваш email.');

        redirect('/activation.php');
    }
}

$seo_title          = 'Регистрация';
$seo_description    = 'Регистрация на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'регистрация';

include(__DIR__ . '/view/layout/main.php');