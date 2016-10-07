<?php

if ($data = f_igosja_post('data')) {
    if (!isset($data['password']) || empty($data['password'])) {
        $check_password = false;
        $data['error_password'] = 'Введите пароль.';
    } else {
        $check_password = true;
    }

    if (isset($data['login'])) {
        $login = trim($data['login']);
    }

    if (!isset($login) || empty($login)) {
        $check_login = false;
        $data['error']['login'] = 'Введите логин.';
    } else {
        $check_login = f_igosja_check_user_by_login($login);
        if (!$check_login) {
            $data['error']['login'] = 'Такой логин уже занят.';
        }
    }

    if (isset($data['email'])) {
        $email = trim($data['email']);
    }

    if (!isset($email) || empty($email)) {
        $check_email = false;
        $data['error']['email'] = 'Введите email.';
    } else {
        $check_email = f_igosja_check_user_by_email($email);
        if (!$check_email) {
            $data['error']['email'] = 'Такой email уже занят.';
        }
    }

    if ($check_login && $check_email && $check_password) {
        $password = f_igosja_hash_password($data['password']);
        $code = f_igosja_generate_user_code();

        $sql = "INSERT INTO `user`
                SET `user_code`='$code',
                    `user_date_register`=UNIX_TIMESTAMP(),
                    `user_email`=?,
                    `user_login`=?,
                    `user_password`='$password'";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('ss', $email, $login);
        $prepare->execute();

        $href = 'http://' . $_SERVER['HTTP_HOST'] . '/activation/?data[code]=' . $code;
        $page = 'http://' . $_SERVER['HTTP_HOST'] . '/activation/';
        $email_text =
            'Вы успешно зарегистрированы на сайте Виртуальной Хоккейной Лиги под логином
            <strong>' . $login . '</strong>.<br>
            Чтобы завершить регистрацию подтвердите свой email по ссылке <a href="' . $href . '">' . $href . '</a>
            или введите код <strong>' . $code . '</strong> на странице
            <a href="' . $page . '">' . $page . '</a>.<br/><br/>
            Администрация Виртуальной Хоккейной Лиги';

        $mail = new Mail();
        $mail->setTo($email);
        $mail->setSubject('Регистрация на сайте Виртуальной Хоккейной Лиги');
        $mail->setHtml($email_text);
        $mail->send();

        redirect('/activation');
    }
} else {
    $data = array(
        'login' => '',
        'email' => ''
    );
}