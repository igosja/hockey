<?php

/**
 * @var $auth_user_id integer
 * @var $user_array array
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

$num_get = $auth_user_id;

include(__DIR__ . '/include/sql/user_view.php');

if ($data = f_igosja_request_post('data'))
{
    $sql = "SELECT `user_code`,
                   `user_email`
            FROM `user`
            WHERE `user_id`=$num_get
            LIMIT 1";
    $user_sql = f_igosja_mysqli_query($sql);

    $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

    if (!isset($data['user_email']) || empty($data['user_email']))
    {
        $check_password_new = false;

        f_igosja_session_front_flash_set('error', 'Введите email.');

        refresh();
    }

    $user_birth_day     = (int) $data['user_birth_day'];
    $user_birth_month   = (int) $data['user_birth_month'];
    $user_birth_year    = (int) $data['user_birth_year'];
    $user_city          = $data['user_city'];
    $user_country_id    = (int) $data['user_country_id'];
    $user_email         = $data['user_email'];
    $user_name          = $data['user_name'];
    $user_sex_id        = (int) $data['user_sex_id'];
    $user_surname       = $data['user_surname'];
    $user_use_bb        = (int) $data['user_use_bb'];

    $sql = "UPDATE `user`
            SET `user_birth_day`=$user_birth_day,
                `user_birth_month`=$user_birth_month,
                `user_birth_year`=$user_birth_year,
                `user_city`=?,
                `user_country_id`=$user_country_id,
                `user_name`=?,
                `user_sex_id`=$user_sex_id,
                `user_surname`=?,
                `user_use_bb`=$user_use_bb
            WHERE `user_id`=$auth_user_id
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('sss', $user_city, $user_name, $user_surname);
    $prepare->execute();

    if ($user_array[0]['user_email'] != $user_email)
    {
        $sql = "UPDATE `user`
                SET `user_email`=?,
                    `user_date_confirm`=0
                WHERE `user_id`=$num_get
                LIMIT 1";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('s', $user_email);
        $prepare->execute();

        $href = 'https://' . $_SERVER['HTTP_HOST'] . '/activation.php?data[code]=' . $user_array[0]['user_code'];
        $page = 'https://' . $_SERVER['HTTP_HOST'] . '/activation.php';
        $email_text =
            'Вы изменили свой основной почтовый ящик на сайте Виртуальной Хоккейной Лиги.<br>
            Подтвердите свой email по ссылке <a href="' . $href . '" target="_blank">' . $href . '</a>
            или введите код <strong>' . $user_array[0]['user_code'] . '</strong> на странице
            <a href="' . $page . '" target="_blank">' . $page . '</a>.';

        $mail = new Mail();
        $mail->setTo($user_email);
        $mail->setSubject('Подтвержение email на сайте Виртуальной Хоккейной Лиги');
        $mail->setHtml($email_text);
        $mail->send();
    }

    f_igosja_session_front_flash_set('success', 'Изменения успшено сохранены.');

    refresh();
}

$sql = "SELECT `user_birth_day`,
               `user_birth_month`,
               `user_birth_year`,
               `user_city`,
               `user_country_id`,
               `user_email`,
               `user_finance`,
               `user_login`,
               `user_name`,
               `user_sex_id`,
               `user_surname`,
               `user_use_bb`
        FROM `user`
        LEFT JOIN `sex`
        ON `user_sex_id`=`sex_id`
        LEFT JOIN `country`
        ON `user_country_id`=`country_id`
        WHERE `user_id`=$num_get
        LIMIT 1";
$questionnaire_sql = f_igosja_mysqli_query($sql);

$questionnaire_array = $questionnaire_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        WHERE `country_id`!=0
        ORDER BY `country_name` ASC";
$country_sql = f_igosja_mysqli_query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `sex_id`,
               `sex_name`
        FROM `sex`
        ORDER BY `sex_id` ASC";
$sex_sql = f_igosja_mysqli_query($sql);

$sex_array = $sex_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = $user_array[0]['user_login'] . '. Анкета менеджера';
$seo_description    = $user_array[0]['user_login'] . '. Анкета менеджера на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $user_array[0]['user_login'] . ' анкета менеджера';

include(__DIR__ . '/view/layout/main.php');