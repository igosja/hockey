<?php

/**
 * Повертаємо хокеїстів з оренди
 */
function f_igosja_generator_rent_decrease_return()
{
    $sql = "UPDATE `player`
            SET `player_rent_day`=`player_rent_day`-1
            WHERE `player_rent_day`>0
            AND `player_rent_team_id`!=0";
    f_igosja_mysqli_query($sql);

    $sql = "SELECT `buyer`.`team_id` AS `buyer_team_id`,
                   `buyer`.`team_user_id` AS `buyer_user_id`,
                   `player_id`,
                   `seller`.`team_id` AS `seller_team_id`,
                   `seller`.`team_user_id` AS `seller_user_id`
            FROM `player`
            LEFT JOIN `team` AS `seller`
            ON `player_team_id`=`seller`.`team_id`
            LEFT JOIN `team` AS `buyer`
            ON `player_rent_team_id`=`buyer`.`team_id`
            WHERE `player_rent_day`<=0
            AND `player_rent_team_id`!=0
            ORDER BY `player_id` ASC";
    $player_sql = f_igosja_mysqli_query($sql);

    $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($player_array as $item)
    {
        $player_id = $item['player_id'];

        $sql = "UPDATE `player`
                SET `player_rent_team_id`=0
                WHERE `player_id`=$player_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $log = array(
            'history_historytext_id' => HISTORYTEXT_PLAYER_RENT_BACK,
            'history_player_id' => $player_id,
            'history_team_id' => $item['seller_team_id'],
            'history_team_2_id' => $item['buyer_team_id'],
        );
        f_igosja_history($log);
    }
}