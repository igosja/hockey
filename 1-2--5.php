<?php

include(__DIR__ . '/include/include.php');

$sql = "SELECT `user_id`,
                `user_money`
        FROM `user`
        WHERE `user_date_login`+7*60*60*24>UNIX_TIMESTAMP()
        ORDER BY `user_id` ASC";
$user_sql = f_igosja_mysqli_query($sql);

$user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

foreach ($user_array as $item)
{
    $user_id    = $item['user_id'];
    $user_money = $item['user_money'];
    $sum = 10;

    $money = array(
        'money_moneytext_id' => MONEYTEXT_INCOME_ADD_FUNDS,
        'money_user_id' => $user_id,
        'money_value' => $sum,
        'money_value_after' => $user_money + $sum,
        'money_value_before' => $user_money,
    );
    f_igosja_money($money);
}

$sql = "UPDATE `user`
        SET `user_money`=`user_money`+$sum
        WHERE `user_date_login`+7*60*60*24>UNIX_TIMESTAMP()
        ORDER BY `user_id` ASC";
$user_sql = f_igosja_mysqli_query($sql);