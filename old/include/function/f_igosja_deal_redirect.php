<?php

/**
 * Перенаправляемо менеджера на наступний трансфер після його голосування
 * @param $auth_user_id integer
 */
function f_igosja_deal_redirect($auth_user_id)
{
    $sql = "SELECT `transfer_id`
            FROM `transfer`
            LEFT JOIN
            (
                SELECT `transfervote_transfer_id`
                FROM `transfervote`
                WHERE `transfervote_transfer_id` IN
                (
                    SELECT `transfer_id`
                    FROM `transfer`
                    WHERE `transfer_ready`=1
                    AND `transfer_checked`=0
                )
                AND `transfervote_user_id`=$auth_user_id
            ) AS `t1`
            ON `transfer_id`=`transfervote_transfer_id`
            WHERE `transfer_ready`=1
            AND `transfer_checked`=0
            AND `transfervote_transfer_id` IS NULL
            ORDER BY `transfer_id` ASC
            LIMIT 1";
    $transfer_sql = f_igosja_mysqli_query($sql);

    if (0 != $transfer_sql->num_rows)
    {
        $transfer_array = $transfer_sql->fetch_all(MYSQLI_ASSOC);

        redirect('/transfer_view.php?num=' . $transfer_array[0]['transfer_id']);
    }

    $sql = "SELECT `rent_id`
            FROM `rent`
            LEFT JOIN
            (
                SELECT `rentvote_rent_id`
                FROM `rentvote`
                WHERE `rentvote_rent_id` IN
                (
                    SELECT `rent_id`
                    FROM `rent`
                    WHERE `rent_ready`=1
                    AND `rent_checked`=0
                )
                AND `rentvote_user_id`=$auth_user_id
            ) AS `t1`
            ON `rent_id`=`rentvote_rent_id`
            WHERE `rent_ready`=1
            AND `rent_checked`=0
            AND `rentvote_rent_id` IS NULL
            ORDER BY `rent_id` ASC
            LIMIT 1";
    $rent_sql = f_igosja_mysqli_query($sql);

    if (0 != $rent_sql->num_rows)
    {
        $rent_array = $rent_sql->fetch_all(MYSQLI_ASSOC);

        redirect('/rent_view.php?num=' . $rent_array[0]['rent_id']);
    }
}