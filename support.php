<?php

/**
 * @var $auth_user_id
 */

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    if (!isset($auth_user_id))
    {
        redirect('/wrong_page.php');
    }

    $num_get = $auth_user_id;
}

include(__DIR__ . '/include/sql/user_view.php');

if ($data = f_igosja_request_post('data'))
{
    if (isset($data['text']) &&!empty($data['text']))
    {
        $text = trim($data['text']);

        if (!empty($text))
        {
            $sql = "INSERT INTO `message`
                    SET `message_date`=UNIX_TIMESTAMP(),
                        `message_support_to`=1,
                        `message_text`=?,
                        `message_user_id_from`=$auth_user_id";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $text);
            $prepare->execute();
            $prepare->close();

            f_igosja_session_front_flash_set('success', 'Сообщение успешно отправлено.');
        }
    }

    refresh();
}

$limit  = 20;

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `message_date`,
               `message_id`,
               `message_text`,
               `user_id`,
               `user_login`
        FROM `message`
        LEFT JOIN `user`
        ON `message_user_id_from`=`user_id`
        WHERE (`message_support_to`=1
        AND `message_user_id_from`=$auth_user_id)
        OR (`message_support_from`=1
        AND `message_user_id_to`=$auth_user_id)
        ORDER BY `message_id` DESCs
        LIMIT $limit";
$message_sql = f_igosja_mysqli_query($sql);

$message_array = $message_sql->fetch_all(MYSQLI_ASSOC);

$sql = "UPDATE `message`
        SET `message_read`=1
        WHERE `message_user_id_to`=$auth_user_id
        AND `message_support_from`=1
        AND `message_read`=0";
f_igosja_mysqli_query($sql);

$seo_title          = 'Техническая поддержка';
$seo_description    = 'Техническая поддержка на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'техническая поддержка';

include(__DIR__ . '/view/layout/main.php');