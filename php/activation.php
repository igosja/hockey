<?php

if ($data = igosja_get_post('data')) {
    $code = explode('-', $data['code']);
    if (isset($code[0])) {
        $id = (int)$code;
    } else {
        $id = 0;
    }
    if (isset($code[1])) {
        $code = $code[1];
    } else {
        $code = '';
    }
} elseif ($data = igosja_get_get('data')) {
    $id           = (int)$data['id'];
    $code         = $data['code'];
    $data['code'] = $id . '-' . $code;
}

if (isset($id) && isset($code)) {
    $check = igosja_hash_password($id);
    if ($code != $check) {
        $data['error']['code'] = 'Активировать профиль не удалось.';
    } else {
        $sql = "UPDATE `user`
                SET `user_date_confirm`=UNIX_TIMESTAMP()
                WHERE `user_id`='$id'
                LIMIT 1";
        db_query($sql);
        $data['success']['code'] = 'Профиль активирован.';
    }
} else {
    $data = array(
        'code' => '',
    );
}