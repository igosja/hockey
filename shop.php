<?php

include (__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

$num_get = $auth_user_id;

$sql = "SELECT `user_date_vip`,
               `user_money`
        FROM `user`
        WHERE `user_id`=$auth_user_id
        LIMIT 1";
$user_sql = f_igosja_mysqli_query($sql);

$user_array = $user_sql->fetch_all(1);

if ($data = f_igosja_request_get('data'))
{
    if (isset($data['vip']))
    {
        if (!in_array($data['vip'], array(15, 30, 60, 180, 365)))
        {
            $data['vip'] = 15;
        }

        $vip_array = array(
            15 => 2,
            30 => 3,
            60 => 5,
            180 => 10,
            360 => 15,
        );

        $price = $vip_array[$data['vip']];

        if ($price > $user_array[0]['user_money'])
        {
            $_SESSION['message']['class']   = 'error';
            $_SESSION['message']['text']    = 'Недостаточно средств на счету.';

            redirect('/shop.php');
        }

        if (time() > $user_array[0]['user_date_vip'])
        {
            $date_vip = time() + $data['vip'] * 60 * 60 * 24;
        }
        else
        {
            $date_vip = $user_array[0]['user_date_vip'] + $data['vip'] * 60 * 60 * 24;
        }

        $sql = "UPDATE `user`
                SET `user_date_vip`=$date_vip,
                    `user_money`=`user_money`-$price
                WHERE `user_id`=$auth_user_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $_SESSION['message']['class']   = 'success';
        $_SESSION['message']['text']    = 'Ваш VIP успешно продлен.';

        redirect('/shop.php');
    }

    print '<pre>';
    print_r($data);
    exit;
}

include (__DIR__ . '/view/layout/main.php');