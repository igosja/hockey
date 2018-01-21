<?php

include(__DIR__ . '/include/include.php');

$array = (
    array(
        'team_seller_id' => 96,
        'transfer_user_seller_id' => 46,
        'team_buyer_id' => 209,
        'transfer_user_buyer_id' => 183,
        'price' => 2300000,
        'player_id' => 4090,
    ),
    array(
        'team_seller_id' => 96,
        'transfer_user_seller_id' => 46,
        'team_buyer_id' => 241,
        'transfer_user_buyer_id' => 184,
        'price' => 2200000,
        'player_id' => 4109,
    ),
    array(
        'team_seller_id' => 278,
        'transfer_user_seller_id' => 129,
        'team_buyer_id' => 0,
        'transfer_user_buyer_id' => 0,
        'price' => 403280,
        'player_id' => 11915,
    ),
    array(
        'team_seller_id' => 37,
        'transfer_user_seller_id' => 137,
        'team_buyer_id' => ,
        'transfer_user_buyer_id' => 0,
        'price' => 954010,
        'player_id' => 1570,
    ),
);

$team_array = array();

foreach ($array as $item)
{
    $team_seller_id = $item['team_seller_id'];
    $player_id = $item['player_id'];

    $sql = "UPDATE `player`
            SET `player_line_id`=0,
                `player_noaction`=0,
                `player_team_id`=$team_seller_id
            WHERE `player_id`=$player_id
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    $log = array(
        'history_historytext_id' => HISTORYTEXT_PLAYER_TRANSFER,
        'history_player_id' => $player_id,
        'history_team_id' => $item['team_buyer_id'],
        'history_team_2_id' => $team_seller_id,
        'history_user_id' => $item['transfer_user_buyer_id'],
        'history_user_2_id' => $item['transfer_user_seller_id'],
        'history_value' => $item['price'],
    );
    f_igosja_history($log);
    
    $team_array[] = $item['team_buyer_id'];
}

foreach ($team_array as $team_id)
{
    $sql = "SELECT `finance_id`,
                   `finance_value`,
                   `finance_value_before`
            FROM `finance`
            WHERE `finance_team_id`=$team_id
            AND FROM_UNIXTIME(`finance_date`, '%Y-%m-%d')=CURDATE()
            ORDER BY `finance_id` ASC";
    $finance_array = f_igosja_mysqli_query($sql);

    $before = 0;

    foreach ($finance_array as $item)
    {
        if (0 == $before)
        {
            $before = $item['finance_value_before'];
        }

        $value = $item['finance_value'];
        $after = $before + $value;
        $finance_id = $item['finance_id'];

        $sql = "UPDATE `finance`
                SET `finance_value`=$value,
                    `finance_value_before`=$before,
                    `finance_value_after`=$after
                WHERE `finance_id`=$finance_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $before = $after;
    }
}