<?php

/**
 * Ставим ціну за квиток 20, де її немає
 */
function f_igosja_generator_set_ticket_price()
{
    $sql = "UPDATE `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            SET `game_ticket`=" . GAME_TICKET_DEFAULT_PRICE . "
            WHERE `game_played`=0
            AND FROM_UNIXTIME(`shedule_date`, '%Y-%m-%d')=CURDATE()
            AND `game_ticket`=0";
    f_igosja_mysqli_query($sql);
}