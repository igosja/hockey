<?php

include (__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

if ($data = f_igosja_post('data'))
{
    if (isset($data['text']) && !empty(trim($data['text'])))
    {
        $text = trim($data['text']);

        $sql = "INSERT INTO `message`
                SET `message_date`=UNIX_TIMESTAMP(),
                    `message_support_to`='1',
                    `message_text`=?,
                    `message_user_id_from`='$auth_user_id'";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('s', $text);
        $prepare->execute();
        $prepare->close();

        $_SESSION['message']['class']   = 'success';
        $_SESSION['message']['text']    = 'Сообщение успешно отправлено.';
    }

    refresh();
}

$sql = "SELECT `country_name`,
               `sex_name`,
               `user_birth_day`,
               `user_birth_month`,
               `user_birth_year`,
               `user_city`,
               `user_date_login`,
               `user_date_register`,
               `user_finance`,
               `user_login`,
               `user_money`
        FROM `user`
        LEFT JOIN `sex`
        ON `user_sex_id`=`sex_id`
        LEFT JOIN `country`
        ON `user_country_id`=`country_id`
        WHERE `user_id`='$auth_user_id'
        LIMIT 1";
$user_sql = igosja_db_query($sql);

if (0 == $user_sql->num_rows)
{
    redirect('/wrong_page');
}

$user_array = $user_sql->fetch_all(1);

$sql = "SELECT `message_date`,
               `message_id`,
               `message_text`,
               `user_id`,
               `user_login`
        FROM `message`
        LEFT JOIN `user`
        ON `message_user_id_from`=`user_id`
        WHERE (`message_support_to`='1'
        AND `message_user_id_from`='$auth_user_id')
        OR (`message_support_from`='1'
        AND `message_user_id_to`='$auth_user_id')
        ORDER BY `message_id` DESC";
$message_sql = igosja_db_query($sql);

$message_array = $message_sql->fetch_all(1);

$sql = "UPDATE `message`
        SET `message_read`='1'
        WHERE `message_user_id_to`='$auth_user_id'
        AND `message_support_from`='1'
        AND `message_read`='0'";
igosja_db_query($sql);

include (__DIR__ . '/view/layout/main.php');