<?php

if ($data = f_igosja_post('data')) {
    if (isset($data['email'])) {
        $email = $data['email'];

        $sql = "SELECT `user_code`,
                       `user_date_confirm`
                FROM `user`
                WHERE `user_email`=?
                LIMIT 1";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('s', $email);
        $prepare->execute();

        $user_sql = $prepare->get_result();

        $prepare->close();

        if ($user_sql->num_rows) {
            $user_array = $user_sql->fetch_all(1);

            if ($user_array[0]['user_date_confirm']) {
                $data['success']['email'] = 'Профиль уже активирован.';
            } else {
                $code = $user_array[0]['user_code'];
                $href = 'http://' . $_SERVER['HTTP_HOST'] . '/activation/?data[code]=' . $code;
                $page = 'http://' . $_SERVER['HTTP_HOST'] . '/activation/';
                $email_text =
                    'Вы запросили повтоную отправку кода активации аккаунта на сайте Виртуальной Хоккейной Лиги.<br>
                    Чтобы завершить подтвердить свой email перейдите по ссылке <a href="' . $href . '">' . $href . '</a>
                    или введите код <strong>' . $code . '</strong> на странице
                    <a href="' . $page . '">' . $page . '</a>.<br/><br/>
                    Администрация Виртуальной Хоккейной Лиги';

                $mail = new Mail();
                $mail->setTo($email);
                $mail->setSubject('Код активации аккаунта на сайте Виртуальной Хоккейной Лиги');
                $mail->setHtml($email_text);
                $mail->send();

                $data['success']['email'] = 'Код отправлен на email.';
            }
        } else {
            $data['error']['email'] = 'Пользователь не найден.';
        }
    } else {
        $data = array(
            'email' => '',
        );
    }
} else {
    $data = array(
        'email' => '',
    );
}