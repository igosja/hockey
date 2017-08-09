<?php

include(__DIR__ . '/include/include.php');

if ($data = f_igosja_request_post('data'))
{
    if (!isset($data['email']))
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Введите email.';

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
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Пользователь не найден.';

        refresh();
    }

    $user_array = $user_sql->fetch_all(1);

    if ($user_array[0]['user_date_confirm'])
    {
        $_SESSION['message']['class']   = 'info';
        $_SESSION['message']['text']    = 'Профиль уже активирован.';

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

    $_SESSION['message']['class']   = 'success';
    $_SESSION['message']['text']    = 'Код отправлен на email.';

    refresh();
}

$seo_title          = 'Повторная отправка кода активации профиля';
$seo_description    = 'Здесь вы можете запросить повторную отправлку кода активвации своего профиля на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'отправка кода активации профиля ';

include(__DIR__ . '/view/layout/main.php');