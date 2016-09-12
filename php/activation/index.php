<?php

if (!$data = f_igosja_post('data')) {
    $data = f_igosja_get('data');
}

if (isset($data['code'])) {
    $code = $data['code'];
    $sql = "SELECT `user_date_confirm`
            FROM `user`
            WHERE `user_code`='$code'
            LIMIT 1";
    $user_sql = db_query($sql);
    if ($user_sql->num_rows) {
        $user_array = $user_sql->fetch_all(1);
        if ($user_array[0]['user_date_confirm']) {
            $data['success']['code'] = 'Профиль уже активирован.';
        } else {
            $sql = "UPDATE `user`
                    SET `user_date_confirm`=UNIX_TIMESTAMP()
                    WHERE `user_id`='$code'
                    LIMIT 1";
            db_query($sql);
            $data['success']['code'] = 'Профиль активирован.';
        }
    } else {
        $data['error']['code'] = 'Активировать профиль не удалось.';
    }
} else {
    $data = array(
        'code' => '',
    );
}