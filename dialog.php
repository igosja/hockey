<?php

/**
 * @var $auth_user_id
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
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
                        `message_text`=?,
                        `message_user_id_from`=$auth_user_id,
                        `message_user_id_to`=$num_get";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $text);
            $prepare->execute();
            $prepare->close();

            f_igosja_session_front_flash_set('success', 'Сообщение успешно отправлено.');
        }
    }

    refresh();
}

if (!$page = (int) f_igosja_request_get('page'))
{
    $page = 1;
}

$limit  = 20;
$offset = ($page - 1) * $limit;

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `message_date`,
               `message_id`,
               `message_text`,
               `user_id`,
               `user_login`
        FROM `message`
        LEFT JOIN `user`
        ON `message_user_id_from`=`user_id`
        WHERE ((`message_user_id_to`=$num_get
        AND `message_user_id_from`=$auth_user_id
        AND `message_delete_from`=0)
        OR (`message_user_id_from`=$num_get
        AND `message_user_id_to`=$auth_user_id
        AND `message_delete_to`=0))
        AND `message_support_to`=0
        AND `message_support_from`=0
        ORDER BY `message_id` DESC
        LIMIT $offset, $limit";
$message_sql = f_igosja_mysqli_query($sql);

$message_array = $message_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT FOUND_ROWS() AS `count`";
$total = f_igosja_mysqli_query($sql);
$total = $total->fetch_all(MYSQLI_ASSOC);
$total = $total[0]['count'];

$count_page = ceil($total / $limit);

$sql = "UPDATE `message`
        SET `message_read`=1
        WHERE `message_user_id_to`=$auth_user_id
        AND `message_user_id_from`=$num_get
        AND `message_support_to`=0
        AND `message_support_from`=0
        AND `message_read`=0";
f_igosja_mysqli_query($sql);

$seo_title          = 'Личная переписка';
$seo_description    = 'Личная переписка на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'личная переписка';

include(__DIR__ . '/view/layout/main.php');