<?php

include(__DIR__ . '/include/include.php');

if (isset($_SERVER['HTTP_X_REAL_IP']))
{
    $ip = $_SERVER['HTTP_X_REAL_IP'];
}
else
{
    $ip = $_SERVER['REMOTE_ADDR'];
}

if (!in_array($ip, array('136.243.38.147', '136.243.38.149', '136.243.38.150', '136.243.38.151', '136.243.38.189', '88.198.88.98')))
{
    die('HACKING ATTEMPT');
}

if (!isset($_REQUEST['MERCHANT_ID']) ||
    !isset($_REQUEST['AMOUNT']) ||
    !isset($_REQUEST['MERCHANT_ORDER_ID']) ||
    !isset($_REQUEST['SIGN']))
{
    die('WRONG POST');
}

$merchant_id    = 27937;
$secret         = 'h8lzyqfr';
$sign           = $_REQUEST['SIGN'];
$payment_id     = $_REQUEST['MERCHANT_ORDER_ID'];
$sum            = $_REQUEST['AMOUNT'];
$sign_check     = md5($merchant_id . ':' . $_REQUEST['AMOUNT'] . ':' . $secret . ':' . $payment_id);

if ($sign_check != $sign)
{
    die('NO. WRONG SIGN');
}

$sql = "SELECT `payment_status`,
               `payment_sum`,
               `payment_user_id`
        FROM `payment`
        WHERE `payment_id`=$payment_id
        LIMIT 1";
$payment_sql = f_igosja_mysqli_query($sql);

$count_payment = $payment_sql->num_rows;

if (0 == $count_payment)
{
    die('NO. WRONG PAYMENT ID');
}

$payment_array = $payment_sql->fetch_all(MYSQLI_ASSOC);

$status = $payment_array[0]['payment_status'];

if (1 == $status)
{
    die('NO. WRONG PAYMENT STATUS');
}

$user_id    = $payment_array[0]['payment_user_id'];
$sum        = $payment_array[0]['payment_sum'];
$bonus      = f_igosja_get_user_payment_bonus($user_id, $bonus_array);

if ($sum >= 100)
{
    $bonus = $bonus + 10;
}

$sum = round($sum * ( 100 + $bonus ) / 100, 2);

$sql = "UPDATE `payment`
        SET `payment_status`=1
        WHERE `payment_id`=$payment_id
        LIMIT 1";
f_igosja_mysqli_query($sql);

$sql = "SELECT `user_money`,
               `user_referrer_id`
        FROM `user`
        WHERE `user_id`=$user_id
        LIMIT 1";
$user_sql = f_igosja_mysqli_query($sql);

$user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

$sql = "UPDATE `user`
        SET `user_money`=`user_money`+$sum
        WHERE `user_id`=$user_id
        LIMIT 1";
f_igosja_mysqli_query($sql);

$money = array(
    'money_moneytext_id' => MONEYTEXT_INCOME_ADD_FUNDS,
    'money_user_id' => $user_id,
    'money_value' => $sum,
    'money_value_after' => $user_array[0]['user_money'] + $sum,
    'money_value_before' => $user_array[0]['user_money'],
);
f_igosja_money($money);

if ($user_array[0]['user_referrer_id'])
{
    $referrer_id = $user_array[0]['user_referrer_id'];

    $sum = round($sum / 10, 2);

    $sql = "SELECT `user_money`,
                   `user_referrer_id`
            FROM `user`
            WHERE `user_id`=$referrer_id
            LIMIT 1";
    $user_sql = f_igosja_mysqli_query($sql);

    if ($user_sql->num_rows)
    {
        $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

        $sql = "UPDATE `user`
                SET `user_money`=`user_money`+$sum
                WHERE `user_id`=$referrer_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $money = array(
            'money_moneytext_id' => MONEYTEXT_INCOME_REFERRAL,
            'money_user_id' => $referrer_id,
            'money_value' => $sum,
            'money_value_after' => $user_array[0]['user_money'] + $sum,
            'money_value_before' => $user_array[0]['user_money'],
        );
        f_igosja_money($money);
    }
}

die('YES');