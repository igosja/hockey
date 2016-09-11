<?php

if ($data = igosja_get_post('data')) {
    if (empty($data['password'])) {
        $check_password         = false;
        $data['error_password'] = 'Введите пароль.';
    } else {
        $check_password = true;
    }
    $login = trim($data['login']);
    if (empty($login)) {
        $check_login         = false;
        $data['error_login'] = 'Введите логин.';
    } else {
        $check_login = igosja_check_user_by_login($login);
        if (!$check_login) {
            $data['error_login'] = 'Такой логин уже занят.';
        }
    }
    $email = trim($data['email']);
    if (empty($email)) {
        $check_email         = false;
        $data['error_email'] = 'Введите email.';
    } else {
        $check_email = igosja_check_user_by_email($email);
        if (!$check_email) {
            $data['error_email'] = 'Такой email уже занят.';
        }
    }
    if ($check_login && $check_email && $check_password) {
        $password = igosja_hash_password($data['password']);

        $sql = "INSERT INTO `user`
                SET `user_date_register`=UNIX_TIMESTAMP(),
                    `user_email`=?,
                    `user_login`=?,
                    `user_password`='$password'";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('ss', $email, $login);
        $prepare->execute();

        $user_id    = $mysqli->insert_id;
        $code       = igosja_hash_password($user_id);
        $href       = 'http://' . $_SERVER['HTTP_HOST'] . '/activation/?id=' . $user_id . '&code=' . $code;
        $page       = 'http://' . $_SERVER['HTTP_HOST'] . '/activation/';
        $email_text =
            'Вы успешно зарегистрированы на сайте Виртуальной Хоккейной Лиги под логином
            <strong>' . $login . '</strong>.<br>
            Чтобы завершить регистрацию подтвердите свой email по ссылке <a href="' . $href . '">' . $href . '</a>
            или введите код <strong>' . $user_id . '-' . $code . '</strong> на странице
            <a href="' . $page . '">' . $page . '</a>.<br/><br/>
            Администрация Виртуальной Хоккейной Лиги';

        $mail = new Mail();
        $mail->setTo($email);
        $mail->setSubject('Регистрация на сайте Виртуальной Хоккейной Лиги');
        $mail->setHtml($email_text);
        $mail->send();
        redirect('activation');
    }
} else {
    $data = array(
        'login' => '',
        'email' => ''
    );
}