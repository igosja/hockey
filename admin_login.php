<?php

/**
 * @var $auth_user_id integer
 * @var $auth_userrole_id integer
 */

include(__DIR__ . '/include/include.php');

if (isset($auth_user_id) && 2 == $auth_userrole_id)
{
    redirect('/admin/');
}

if ($data = f_igosja_request_post('data'))
{
    if (!isset($data['login']) || !isset($data['password']))
    {
        f_igosja_session_back_flash_set('danger', 'Неправильная комбинация логин/пароль.');

        refresh();
    }

    $login      = trim($data['login']);
    $password   = f_igosja_hash_password($data['password']);

    $sql = "SELECT `user_code`,
                   `user_id`
            FROM `user`
            WHERE `user_login`=?
            AND `user_password`=?
            AND `user_userrole_id`=" . USERROLE_ADMIN . "
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ss', $login, $password);
    $prepare->execute();

    $user_sql = $prepare->get_result();

    $prepare->close();

    if (!$user_sql->num_rows)
    {
        f_igosja_session_back_flash_set('danger', 'Неправильная комбинация логин/пароль.');

        refresh();
    }

    $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

    $_SESSION['admin_user_id'] = $user_array[0]['user_id'];

    setcookie('admin_login_code', $user_array[0]['user_code'] . '-' . f_igosja_login_code($user_array[0]['user_code']), time() + 31536000); //365 днів

    redirect('/admin/');
}

$seo_title          = 'Вход в административный раздел';
$seo_description    = 'Войти в административный раздел на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'административный раздел админка ';

include(__DIR__ . '/view/layout/admin.php');