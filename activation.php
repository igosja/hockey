<?php

include(__DIR__ . '/include/include.php');

$data = f_igosja_request('data');

if (isset($data['code']))
{
    $code = $data['code'];

    $sql = "SELECT `user_date_confirm`
            FROM `user`
            WHERE `user_code`=?
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $code);
    $prepare->execute();

    $user_sql = $prepare->get_result();

    $prepare->close();

    if (!$user_sql->num_rows)
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Активировать профиль не удалось.';

        refresh();
    }

    $user_array = $user_sql->fetch_all(1);

    if ($user_array[0]['user_date_confirm'])
    {
        $_SESSION['message']['class']   = 'info';
        $_SESSION['message']['text']    = 'Профиль уже активирован.';

        refresh();
    }

    $sql = "UPDATE `user`
            SET `user_date_confirm`=UNIX_TIMESTAMP()
            WHERE `user_code`='$code'
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    $_SESSION['message']['class']   = 'success';
    $_SESSION['message']['text']    = 'Профиль активирован.';

    refresh();
}

$seo_title          = 'Активация профиля';
$seo_description    = 'Здесь вы можете активировать свой профиль на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'активация профиля ';

include(__DIR__ . '/view/layout/main.php');