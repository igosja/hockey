<?php

include(__DIR__ . '/include/include.php');

if ($data = f_igosja_request_post('data'))
{
    if (!isset($data['email']))
    {
        f_igosja_session_front_flash_set('error', 'Введите email.');

        refresh();
    }

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

    if (0 == $user_sql->num_rows)
    {
        f_igosja_session_front_flash_set('error', 'Пользователь не найден.');

        refresh();
    }

    $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

    if ($user_array[0]['user_date_confirm'])
    {
        f_igosja_session_front_flash_set('error', 'Профиль уже активирован.');

        refresh();
    }

    $code = $user_array[0]['user_code'];
    $href = 'http://' . $_SERVER['HTTP_HOST'] . '/activation.php?data[code]=' . $code;
    $page = 'http://' . $_SERVER['HTTP_HOST'] . '/activation.php';
    $email_text =
        'Вы запросили повтоную отправку кода активации аккаунта на сайте Виртуальной Хоккейной Лиги.<br>
        Чтобы завершить подтвердить свой email перейдите по ссылке <a href="' . $href . '" target="_blank">' . $href . '</a>
        или введите код <strong>' . $code . '</strong> на странице
        <a href="' . $page . '" target="_blank">' . $page . '</a>.';

    $mail = new Mail();
    $mail->setTo($email);
    $mail->setSubject('Код активации аккаунта на сайте Виртуальной Хоккейной Лиги');
    $mail->setHtml($email_text);
    $mail->send();

    f_igosja_session_front_flash_set('success', 'Код отправлен на email.');

    refresh();
}

$seo_title          = 'Повторная отправка кода активации профиля';
$seo_description    = 'Здесь вы можете запросить повторную отправлку кода активвации своего профиля на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'отправка кода активации профиля ';

include(__DIR__ . '/view/layout/main.php');