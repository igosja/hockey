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

if (!isset($_POST['MERCHANT_ID']) ||
    !isset($_POST['AMOUNT']) ||
    !isset($_POST['MERCHANT_ORDER_ID']) ||
    !isset($_POST['SIGN']))
{
    die('WRONG POST');
}

$merchant_id    = 27937;
$secret         = 'h8lzyqfr';
$sign           = $_POST['SIGN'];
$payment_id     = $_POST['MERCHANT_ORDER_ID'];
$sum            = $_POST['AMOUNT'];
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

$payment_array = $payment_sql->fetch_all(1);

$status = $payment_array[0]['payment_status'];

if (1 == $status)
{
    die('NO. WRONG PAYMENT STATUS');
}

$user_id    = $payment_array[0]['payment_user_id'];
$sum        = $payment_array[0]['payment_sum'];

$sql = "UPDATE `payment`
        SET `payment_status`=1
        WHERE `payment_id`=$payment_id
        LIMIT 1";
f_igosja_mysqli_query($sql);

$sql = "UPDATE `user`
        SET `user_money`=`user_money`+$sum
        WHERE `user_id`=$user_id
        LIMIT 1";
f_igosja_mysqli_query($sql);

die('YES');