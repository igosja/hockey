<?php

/**
 * Рахуємо бонус, який користувач отримає при поповненні рахунку
 * @param $user_id integer id коистувача
 * @param $bonus_array array array(bonus => sum)
 * @return integer
 */
function f_igosja_get_user_payment_bonus($user_id, $bonus_array)
{
    $sql = "SELECT IFNULL(SUM(`payment_sum`), 0) AS `payment_sum`
            FROM `payment`
            WHERE `payment_user_id`=$user_id
            AND `payment_status`=1";
    $payment_sql = f_igosja_mysqli_query($sql);

    $payment_array = $payment_sql->fetch_all(MYSQLI_ASSOC);

    $payment = $payment_array[0]['payment_sum'];

    foreach ($bonus_array as $sum => $bonus)
    {
        if ($payment >= $sum)
        {
            return $bonus;
        }
    }

    return 0;
}