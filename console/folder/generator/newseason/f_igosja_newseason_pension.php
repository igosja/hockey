<?php

/**
 * Відправляємо вікових хокеїстів на пенсію
 */
function f_igosja_newseason_pension()
{
    $sql = "SELECT `player_id`,
                   `player_price`,
                   `player_team_id`
            FROM `player`
            WHERE `player_age`>=40
            AND `player_team_id`!=0
            ORDER BY `player_id` ASC";
    $player_sql = f_igosja_mysqli_query($sql);

    $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($player_array as $item)
    {
        $log = array(
            'history_historytext_id' => HISTORYTEXT_PLAYER_PENSION_GO,
            'history_player_id' => $item['player_id'],
            'history_team_id' => $item['player_team_id'],
        );
        f_igosja_history($log);

        $team_id = $item['player_team_id'];

        $sql = "SELECT `team_finance`
                FROM `team`
                WHERE `team_id`=$team_id
                LIMIT 1";
        $team_sql = f_igosja_mysqli_query($sql);

        $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

        $price = ceil($item['player_price'] / 2);

        $sql = "UPDATE `team`
                SET `team_finance`=`team_finance`+$price
                WHERE `team_id`=$team_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $finance = array(
            'finance_financetext_id' => FINANCETEXT_INCOME_PENSION,
            'finance_team_id' => $team_id,
            'finance_value' => $price,
            'finance_value_after' => $team_array[0]['team_finance'] + $price,
            'finance_value_before' => $team_array[0]['team_finance'],
        );
        f_igosja_finance($finance);
    }

    $sql = "UPDATE `player`
            SET `player_line_id`=0,
                `player_rent_team_id`=0,
                `player_team_id`=0
            WHERE `player_age`>=40
            AND `player_team_id`!=0";
    f_igosja_mysqli_query($sql);
}