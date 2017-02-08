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
    elseif (isset($data['product']))
    {
        if (!in_array($data['product'], array(1, 2, 3, 4)))
        {
            $_SESSION['message']['class']   = 'success';
            $_SESSION['message']['text']    = 'Игровой товар выбран неправильно.';

            redirect('/shop.php');
        }

        if (1 == $data['product'])
        {
            $price = 1;
        }
        elseif (2 == $data['product'])
        {
            $price = 5;
        }
        else
        {
            $price = 3;
        }

        if ($price > $user_array[0]['user_money'])
        {
            $_SESSION['message']['class']   = 'error';
            $_SESSION['message']['text']    = 'Недостаточно средств на счету.';

            redirect('/shop.php');
        }

        if (1 == $data['product'])
        {
            $sql = "UPDATE `user`
                    SET `user_money`=`user_money`-$price,
                        `user_shop_training`=`user_shop_training`+1
                    WHERE `user_id`=$auth_user_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }
        elseif(2 == $data['product'])
        {
            $sql = "UPDATE `user`
                    SET `user_money`=`user_money`-$price
                    WHERE `user_id`=$auth_user_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $sql = "SELECT `team_finance`
                    FROM `team`
                    WHERE `team_id`=$auth_team_id
                    LIMIT 1";
            $team_sql = f_igosja_mysqli_query($sql);

            $team_array = $team_sql->fetch_all(1);

            $sql = "UPDATE `team`
                    SET `team_finance`=`team_finance`+1000000
                    WHERE `team_id`=$auth_team_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_INCOME_PRIZE_VIP,
                'finance_team_id' => $auth_team_id,
                'finance_value' => 1000000,
                'finance_value_after' => $team_array[0]['team_finance'] + 1000000,
                'finance_value_before' => $team_array[0]['team_finance'],
            );
            f_igosja_finance($finance);
        }
        elseif(3 == $data['product'])
        {
            $sql = "UPDATE `user`
                    SET `user_money`=`user_money`-$price,
                        `user_shop_position`=`user_shop_position`+1
                    WHERE `user_id`=$auth_user_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }
        elseif(4 == $data['product'])
        {
            $sql = "UPDATE `user`
                    SET `user_money`=`user_money`-$price,
                        `user_shop_special`=`user_shop_special`+1
                    WHERE `user_id`=$auth_user_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }

        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Покупка совершена успешно.';

        redirect('/shop.php');
    }
}

include (__DIR__ . '/view/layout/main.php');