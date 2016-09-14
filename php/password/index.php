<?php

if ($data = f_igosja_post('data')) {
    if (isset($data['login'])) {
        $login = trim($data['login']);
    } else {
        $login = '';
    }

    if (isset($data['email'])) {
        $email = trim($data['email']);
    } else {
        $email = '';
    }

    if (empty($login) && empty($email)) {
        $data['error']['login'] = 'Введите логин.';
        $data['error']['email'] = 'Введите email.';
    } else {
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

        if ($user_sql->num_rows) {
            $user_array = $user_sql->fetch_all(1);
            $code = $user_array[0]['user_code'];
            $email = $user_array[0]['user_email'];

            $href = 'http://' . $_SERVER['HTTP_HOST'] . '/password/restore/?data[code]=' . $code;
            $email_text =
                'Вы запросили восстановление пароля на сайте Виртуальной Хоккейной Лиги.<br>
                Чтобы восстановить пароль перейдите по ссылке <a href="' . $href . '">' . $href . '</a>.<br/><br/>
                Администрация Виртуальной Хоккейной Лиги';

            $mail = new Mail();
            $mail->setTo($email);
            $mail->setSubject('Регистрация на сайте Виртуальной Хоккейной Лиги');
            $mail->setHtml($email_text);
            $mail->send();

            $data['success']['login'] = '';
            $data['success']['email'] = 'Данные успешно отправлены на email.';
        } else {
            $data['error']['login'] = '';
            $data['error']['email'] = 'Пользователь не найден.';
        }
    }
} else {
    $data = array(
        'login' => '',
        'email' => ''
    );
}