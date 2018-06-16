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
            $publish = true;

            $text = htmlspecialchars($text);

            $sql = "SELECT `message_text`,
                           `message_user_id_from`
                    FROM `message`
                    WHERE (`message_user_id_from`=$auth_user_id
                    AND `message_user_id_to`=$num_get)
                    OR (`message_user_id_from`=$num_get
                    AND `message_user_id_to`=$auth_user_id)
                    ORDER BY `message_id` DESC
                    LIMIT 1";
            $check_sql = f_igosja_mysqli_query($sql);

            if (0 != $check_sql->num_rows)
            {
                $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

                if ($auth_user_id == $check_array[0]['message_user_id_from'] && $text == $check_array[0]['message_text'])
                {
                    $publish = false;
                }
            }

            if ($publish)
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
            else
            {
                f_igosja_session_front_flash_set('error', 'Нельзя писать подряд два одинаковых сообщения.');
            }
        }
    }

    refresh();
}

$limit = 50;

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
        LIMIT $limit";
$message_sql = f_igosja_mysqli_query($sql);

$message_array = $message_sql->fetch_all(MYSQLI_ASSOC);
$message_array = array_reverse($message_array);

$sql = "SELECT FOUND_ROWS() AS `count`";
$total = f_igosja_mysqli_query($sql);
$total = $total->fetch_all(MYSQLI_ASSOC);
$total = $total[0]['count'];

if ($total > $message_sql->num_rows)
{
    $lazy = 1;
}
else
{
    $lazy = 0;
}

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