<?php

include(__DIR__ . '/include/include.php');

$sql = "SELECT `user_id`,
               `user_money`
        FROM `user`
        WHERE `user_id`!=0
        ORDER BY `user_id` ASC";
$user_sql = f_igosja_mysqli_query($sql);

$user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

foreach ($user_array as $item)
{
    $user_id = $item['user_id'];
    $sum = 50;

    $sql = "UPDATE `user`
            SET `user_money`=`user_money`+$sum
            WHERE `user_id`=$user_id
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    $money = array(
        'money_moneytext_id' => MONEYTEXT_INCOME_ADD_FUNDS,
        'money_user_id' => $user_id,
        'money_value' => $sum,
        'money_value_after' => $item['user_money'] + $sum,
        'money_value_before' => $item['user_money'],
    );
    f_igosja_money($money);
}

print 'Ok';