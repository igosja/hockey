<?php

if ($code = f_igosja_get('data')) {
    if (isset($code['code'])) {
        $code = $code['code'];

        $sql = "SELECT COUNT(`user_id`) AS `count`
                FROM `user`
                WHERE `user_code`=?";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('s', $code);
        $prepare->execute();

        $user_sql = $prepare->get_result();

        $prepare->close();

        $user_array = $user_sql->fetch_all(1);
        if ($user_array[0]['count']) {
            if ($data = f_igosja_post('data')) {
                if (isset($data['password'])) {
                    if (!empty($data['password'])) {
                        $password = f_igosja_hash_password($data['password']);

                        $sql = "UPDATE `user`
                                SET `user_password`=?
                                WHERE `user_code`=?
                                LIMIT 1";
                        $prepare = $mysqli->prepare($sql);
                        $prepare->bind_param('ss', $password, $code);
                        $prepare->execute();

                        $data['success']['password'] = 'Пароль успешно изменен.';
                    } else {
                        $data['error']['password'] = 'Введите пароль.';
                    }
                } else {
                    $data['error']['password'] = 'Пользователь не найден.';
                }
            } else {
                $data = array();
            }
        } else {
            $data['error']['password'] = 'Пользователь не найден.';
        }
    } else {
        $data['error']['password'] = 'Пользователь не найден.';
    }
} else {
    $data = array(
        'error' => array(
            'password' => 'Пользователь не найден.'
        ),
    );
}