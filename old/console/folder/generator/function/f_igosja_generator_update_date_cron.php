<?php

/**
 * Оновлюємо дату останнього запуску cron
 */
function f_igosja_generator_update_date_cron()
{
    $sql = "UPDATE `site`
            SET `site_date_cron`=UNIX_TIMESTAMP()
            WHERE `site_id`=1
            LIMIT 1";
    f_igosja_mysqli_query($sql);
}