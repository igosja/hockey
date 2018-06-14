<?php

/**
 * Продовження vip президентам на 30 днів, якщо залишилось менше 7 днів
 */
function f_igosja_generator_president_vip()
{
    $sql = "UPDATE `user`
            SET `user_date_vip`=UNIX_TIMESTAMP()+2592000
            WHERE `user_id` IN
            (
                SELECT `user_id`
                FROM (
                    SELECT `user_id`
                    FROM `country`
                    LEFT JOIN `user`
                    ON `country_president_id`=`user_id`
                    WHERE `user_date_vip`<UNIX_TIMESTAMP()+604800
                    AND `user_id`!=0
                ) AS `t1`
            )
            OR `user_id` IN
            (
                SELECT `user_id`
                FROM (
                    SELECT `user_id`
                    FROM `country`
                    LEFT JOIN `user`
                    ON `country_vice_id`=`user_id`
                    WHERE `user_date_vip`<UNIX_TIMESTAMP()+604800
                    AND `user_id`!=0
                ) AS `t2`
            )";
    f_igosja_mysqli_query($sql);
}