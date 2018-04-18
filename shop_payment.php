<?php

/**
 * @var $auth_user_id integer
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

$num_get = $auth_user_id;

if ($data = f_igosja_request('data'))
{
    $sum = (int) $data['sum'];

    if ($sum < 1)
    {
        $sum = 1;
    }

    if (!f_igosja_request_get('ok'))
    {
        $payment_accept = 'Вы собираетесь пополнить свой счёт на <span class="strong">' . $sum
            . '</span> ' . f_igosja_count_case($sum, 'единицу', 'единицы', 'единиц') . '.';
    }
    else
    {
        $sql = "DELETE FROM `payment`
                WHERE `payment_date`<UNIX_TIMESTAMP()-2592000
                AND `payment_status`=0";
        f_igosja_mysqli_query($sql);

        $sql = "INSERT INTO `payment`
                SET `payment_date`=UNIX_TIMESTAMP(),
                    `payment_sum`=$sum,
                    `payment_user_id`=$auth_user_id";
        f_igosja_mysqli_query($sql);

        $merchant_id    = 27937;
        $secret_key     = 's3lyp66r';
        $order_id       = $mysqli->insert_id;

        $params = array (
            'm'     => $merchant_id,
            'oa'    => $sum * 50,
            'o'     => $order_id,
            's'     => md5($merchant_id . ':' . $sum * 50 . ':' . $secret_key . ':' . $order_id),
            'lang'  => 'ru',
        );

        $url = 'http://www.free-kassa.ru/merchant/cash.php?' . http_build_query($params);

        redirect($url);
    }
}

$sql = "SELECT `user_money`
        FROM `user`
        WHERE `user_id`=$auth_user_id
        LIMIT 1";
$user_sql = f_igosja_mysqli_query($sql);

$user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = 'Пополнение денежного счета';
$seo_description    = 'Пополнение денежного счета на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'пополнение денежного счета';

include(__DIR__ . '/view/layout/main.php');