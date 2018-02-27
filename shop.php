<?php

/**
 * @var $auth_team_id integer
 * @var $auth_user_id integer
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

if (0 == $auth_team_id)
{
    redirect('/team_ask.php');
}

$num_get = $auth_user_id;

$sql = "SELECT `user_date_vip`,
               `user_money`
        FROM `user`
        WHERE `user_id`=$auth_user_id
        LIMIT 1";
$user_sql = f_igosja_mysqli_query($sql);

$user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

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
            365 => 15,
        );

        $price = $vip_array[$data['vip']];

        if ($price > $user_array[0]['user_money'])
        {
            f_igosja_session_front_flash_set('error', 'Недостаточно средств на счету.');

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

        $money = array(
            'money_moneytext_id' => MONEYTEXT_OUTCOME_VIP,
            'money_user_id' => $auth_user_id,
            'money_value' => -$price,
            'money_value_after' => $user_array[0]['user_money'] - $price,
            'money_value_before' => $user_array[0]['user_money'],
        );
        f_igosja_money($money);

        f_igosja_session_front_flash_set('success', 'Ваш VIP успешно продлен.');

        redirect('/shop.php');
    }
    elseif (isset($data['product']))
    {
        if (!in_array($data['product'], array(SHOP_PRODUCT_POINT, SHOP_PRODUCT_MONEY, SHOP_PRODUCT_POSITION, SHOP_PRODUCT_SPECIAL)))
        {
            f_igosja_session_front_flash_set('error', 'Игровой товар выбран неправильно.');

            redirect('/shop.php');
        }

        if (SHOP_PRODUCT_POINT == $data['product'])
        {
            $price = 1;
        }
        elseif (SHOP_PRODUCT_MONEY == $data['product'])
        {
            $price = 5;
        }
        else
        {
            $price = 3;
        }

        if ($price > $user_array[0]['user_money'])
        {
            f_igosja_session_front_flash_set('error', 'Недостаточно средств на счету.');

            redirect('/shop.php');
        }

        if (SHOP_PRODUCT_POINT == $data['product'])
        {
            $sql = "UPDATE `user`
                    SET `user_money`=`user_money`-$price,
                        `user_shop_training`=`user_shop_training`+1
                    WHERE `user_id`=$auth_user_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $money = array(
                'money_moneytext_id' => MONEYTEXT_OUTCOME_POINT,
                'money_user_id' => $auth_user_id,
                'money_value' => -$price,
                'money_value_after' => $user_array[0]['user_money'] - $price,
                'money_value_before' => $user_array[0]['user_money'],
            );
            f_igosja_money($money);
        }
        elseif (SHOP_PRODUCT_MONEY == $data['product'])
        {
            $sql = "UPDATE `user`
                    SET `user_money`=`user_money`-$price
                    WHERE `user_id`=$auth_user_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $money = array(
                'money_moneytext_id' => MONEYTEXT_OUTCOME_TEAM_FINANCE,
                'money_user_id' => $auth_user_id,
                'money_value' => -$price,
                'money_value_after' => $user_array[0]['user_money'] - $price,
                'money_value_before' => $user_array[0]['user_money'],
            );
            f_igosja_money($money);

            $sql = "SELECT `team_finance`
                    FROM `team`
                    WHERE `team_id`=$auth_team_id
                    LIMIT 1";
            $team_sql = f_igosja_mysqli_query($sql);

            $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

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
        elseif (SHOP_PRODUCT_POSITION == $data['product'])
        {
            $sql = "UPDATE `user`
                    SET `user_money`=`user_money`-$price,
                        `user_shop_position`=`user_shop_position`+1
                    WHERE `user_id`=$auth_user_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $money = array(
                'money_moneytext_id' => MONEYTEXT_OUTCOME_POSITION,
                'money_user_id' => $auth_user_id,
                'money_value' => -$price,
                'money_value_after' => $user_array[0]['user_money'] - $price,
                'money_value_before' => $user_array[0]['user_money'],
            );
            f_igosja_money($money);
        }
        elseif (SHOP_PRODUCT_SPECIAL == $data['product'])
        {
            $sql = "UPDATE `user`
                    SET `user_money`=`user_money`-$price,
                        `user_shop_special`=`user_shop_special`+1
                    WHERE `user_id`=$auth_user_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $money = array(
                'money_moneytext_id' => MONEYTEXT_OUTCOME_SPECIAL,
                'money_user_id' => $auth_user_id,
                'money_value' => -$price,
                'money_value_after' => $user_array[0]['user_money'] - $price,
                'money_value_before' => $user_array[0]['user_money'],
            );
            f_igosja_money($money);
        }

        f_igosja_session_front_flash_set('success', 'Покупка совершена успешно.');

        redirect('/shop.php');
    }
}

$seo_title          = 'Виртуальный магазин';
$seo_description    = 'Виртуальный магазин на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'виртуальный магазин';

include(__DIR__ . '/view/layout/main.php');