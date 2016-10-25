<?php

include (__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

$num_get = $auth_user_id;

if ($data = f_igosja_post('data'))
{
    $sql = "SELECT `user_code`,
                   `user_email`
            FROM `user`
            WHERE `user_id`='$num_get'";
    $user_sql = igosja_db_query($sql);

    $user_array = $user_sql->fetch_all(1);

    $user_birth_day     = (int) $data['user_birth_day'];
    $user_birth_month   = (int) $data['user_birth_month'];
    $user_birth_year    = (int) $data['user_birth_year'];
    $user_city          = $data['user_city'];
    $user_country_id    = (int) $data['user_country_id'];
    $user_email         = $data['user_email'];
    $user_name          = $data['user_name'];
    $user_sex_id        = (int)$data['user_sex_id'];
    $user_surname       = $data['user_surname'];

    if (isset($data['user_holiday']))
    {
        $user_holiday = 1;
    }
    else
    {
        $user_holiday = 0;
    }

    $sql = "UPDATE `user`
            SET `user_birth_day`='$user_birth_day',
                `user_birth_month`='$user_birth_month',
                `user_birth_year`='$user_birth_year',
                `user_city`=?,
                `user_country_id`='$user_country_id',
                `user_holiday`='$user_holiday',
                `user_name`=?,
                `user_sex_id`='$user_sex_id',
                `user_surname`=?
            WHERE `user_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('sss', $user_city, $user_name, $user_surname);
    $prepare->execute();

    if ($user_array[0]['user_email'] != $user_email)
    {
        $sql = "UPDATE `user`
                SET `user_email`=?,
                    `user_date_confirm`='0'
                WHERE `user_id`='$num_get'
                LIMIT 1";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('s', $user_email);
        $prepare->execute();

        $href = 'http://' . $_SERVER['HTTP_HOST'] . '/activation.php?data[code]=' . $user_array[0]['user_code'];
        $page = 'http://' . $_SERVER['HTTP_HOST'] . '/activation.php';
        $email_text =
            'Вы изменили свой основной почтовый ящик на сайте Виртуальной Хоккейной Лиги.<br>
            Подтвердите свой email по ссылке <a href="' . $href . '">' . $href . '</a>
            или введите код <strong>' . $user_array[0]['user_code'] . '</strong> на странице
            <a href="' . $page . '">' . $page . '</a>.<br/><br/>
            Администрация Виртуальной Хоккейной Лиги';

        $mail = new Mail();
        $mail->setTo($user_email);
        $mail->setSubject('Подтвержение email на сайте Виртуальной Хоккейной Лиги');
        $mail->setHtml($email_text);
        $mail->send();
    }

    $_SESSION['message']['class'] = 'success';
    $_SESSION['message']['text'] = 'Изменения сохранены.';

    refresh();
}

$sql = "SELECT `country_name`,
               `sex_name`,
               `user_birth_day`,
               `user_birth_month`,
               `user_birth_year`,
               `user_city`,
               `user_country_id`,
               `user_date_login`,
               `user_date_register`,
               `user_email`,
               `user_finance`,
               `user_holiday`,
               `user_login`,
               `user_money`,
               `user_name`,
               `user_sex_id`,
               `user_surname`
        FROM `user`
        LEFT JOIN `sex`
        ON `user_sex_id`=`sex_id`
        LEFT JOIN `country`
        ON `user_country_id`=`country_id`
        WHERE `user_id`='$num_get'";
$user_sql = igosja_db_query($sql);

$user_array = $user_sql->fetch_all(1);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        ORDER BY `country_name` ASC";
$country_sql = igosja_db_query($sql);

$country_array = $country_sql->fetch_all(1);

$sql = "SELECT `sex_id`,
               `sex_name`
        FROM `sex`
        ORDER BY `sex_id` ASC";
$sex_sql = igosja_db_query($sql);

$sex_array = $sex_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');