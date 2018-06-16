<?php

/**
 * @var $auth_user_id integer
 */

include(__DIR__ . '/../include/include.php');

$result = ['class' => 'error', 'message' => 'Не удалось сохранить вашу жалобу.'];

if (($url = f_igosja_request_post('url')) && (isset($auth_user_id)))
{

    $sql = "SELECT COUNT(`complain_id`) AS `count`
            FROM `complain`
            WHERE `complain_url`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $url);
    $prepare->execute();

    $check_sql = $prepare->get_result();

    $prepare->close();

    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

    if (0 == $check_array[0]['count'])
    {
        $sql = "INSERT INTO `complain`
                SET `complain_date`=UNIX_TIMESTAMP(),
                    `complain_url`=?,
                    `complain_user_id`=$auth_user_id";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('s', $url);
        $prepare->execute();
    }

    $result['class']    = 'success';
    $result['text']     = 'Жалоба успешно сохранена.';
}

print json_encode($result);
exit;