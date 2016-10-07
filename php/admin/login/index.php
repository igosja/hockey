<?php

if ($data = f_igosja_post('data')) {
    if (isset($data['login']) && isset($data['password'])) {
        $login = trim($data['login']);
        $password = f_igosja_hash_password($data['password']);

        $sql = "SELECT `user_id`
                FROM `user`
                WHERE `user_login`=?
                AND `user_password`=?
                LIMIT 1";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('ss', $login, $password);
        $prepare->execute();

        $user_sql = $prepare->get_result();

        $prepare->close();

        if ($user_sql->num_rows) {
            $user_array = $user_sql->fetch_all(1);
            $_SESSION['user_id'] = $user_array[0]['user_id'];

            redirect('/admin');
        } else {
            $_SESSION['error_auth'] = 'Неправильная комбинация логин/пароль';
        }
    }
}