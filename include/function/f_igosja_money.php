<?php

/**
 * Запис лога про операції з реальними грошима в БД
 * @param $data array дані для запису в БД
 */
function f_igosja_money($data)
{
    global $mysqli;

    if (isset($data['money_moneytext_id']))
    {
        $money_moneytext_id = (int) $data['money_moneytext_id'];
    }
    else
    {
        $money_moneytext_id = 0;
    }

    if (isset($data['money_user_id']))
    {
        $money_user_id = (int) $data['money_user_id'];
    }
    else
    {
        $money_user_id = 0;
    }

    if (isset($data['money_value']))
    {
        $money_value = (int) $data['money_value'];
    }
    else
    {
        $money_value = 0;
    }

    if (isset($data['money_value_after']))
    {
        $money_value_after = (int) $data['money_value_after'];
    }
    else
    {
        $money_value_after = 0;
    }

    if (isset($data['money_value_before']))
    {
        $money_value_before = (int) $data['money_value_before'];
    }
    else
    {
        $money_value_before = 0;
    }

    $sql = "INSERT INTO `money`
            SET `money_date`=UNIX_TIMESTAMP(),
                `money_moneytext_id`=$money_moneytext_id,
                `money_user_id`=$money_user_id,
                `money_value`=$money_value,
                `money_value_after`=$money_value_after,
                `money_value_before`=$money_value_before";
    f_igosja_mysqli_query($sql);
}