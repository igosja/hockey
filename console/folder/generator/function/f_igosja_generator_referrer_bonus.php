<?php

/**
 * Виплата реферального бонуса після 30 днів у грі
 */
function f_igosja_generator_referrer_bonus()
{
    $sql = "SELECT `user_id`,
                   `user_referrer_id`
            FROM `user`
            LEFT JOIN `team`
            ON `user_id`=`team_user_id`
            WHERE `user_referrer_id`!=0
            AND `user_referrer_done`=0
            AND `user_date_login`>`user_date_register`+2592000
            AND `team_user_id` IS NOT NULL";
    $user_sql = f_igosja_mysqli_query($sql);

    $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($user_array as $item)
    {
        $referrer_id = $item['user_referrer_id'];

        $sql = "SELECT `user_finance`
                FROM `user`
                WHERE `user_id`=$referrer_id
                LIMIT 1";
        $referrer_sql = f_igosja_mysqli_query($sql);

        $referrer_array = $referrer_sql->fetch_all(MYSQLI_ASSOC);

        $sum = 1000000;

        $sql = "UPDATE `user`
                SET `user_finance`=`user_finance`+$sum
                WHERE `user_id`=$referrer_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $data = array(
            'finance_financetext_id' => FINANCETEXT_INCOME_REFERRAL,
            'finance_user_id' => $referrer_id,
            'finance_value' => +$sum,
            'finance_value_after' => $referrer_array[0]['user_finance'] + $sum,
            'finance_value_before' => $referrer_array[0]['user_finance'],
        );
        f_igosja_finance($data);

        $user_id = $item['user_id'];

        $sql = "UPDATE `user`
                SET `user_referrer_done`=1
                WHERE `user_id`=$user_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }
}