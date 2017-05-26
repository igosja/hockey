<?php

/**
 * Проводимо трансфери хокеїстів
 */
function f_igosja_generator_transfer()
{
    global $igosja_season_id;

    $sql = "SELECT `transfer_id`,
                   `transfer_player_id`,
                   `transfer_team_seller_id`,
                   `transfer_user_seller_id`
            FROM `transfer`
            LEFT JOIN `team`
            ON `transfer_team_seller_id`=`team_id`
            WHERE `transfer_ready`=0
            ORDER BY `transfer_id` ASC";
    $transfer_sql = f_igosja_mysqli_query($sql);

    $transfer_array = $transfer_sql->fetch_all(1);

    foreach ($transfer_array as $transfer)
    {
        $transfer_id = $transfer['transfer_id'];

        $sql = "SELECT `team_finance`,
                       `transferapplication_price`,
                       `transferapplication_team_id`,
                       `transferapplication_user_id`
                FROM `transferapplication`
                LEFT JOIN `team`
                ON `transferapplication_team_id`=`team_id`
                WHERE `transferapplication_transfer_id`=$transfer_id
                AND `transferapplication_price`<=`team_finance`
                ORDER BY `transferapplication_price` DESC, `transferapplication_date` ASC
                LIMIT 1";
        $transferaplication_sql = f_igosja_mysqli_query($sql);

        if ($transferaplication_sql->num_rows)
        {
            $transferaplication_array = $transferaplication_sql->fetch_all(1);

            $transferaplication_price   = $transferaplication_array[0]['transferapplication_price'];
            $team_buyer_id              = $transferaplication_array[0]['transferapplication_team_id'];
            $user_buyer_id              = $transferaplication_array[0]['transferapplication_user_id'];
            $team_seller_id             = $transfer['transfer_team_seller_id'];
            $player_id                  = $transfer['transfer_player_id'];

            $sql = "UPDATE `team`
                    SET `team_finance`=`team_finance`+$transferaplication_price
                    WHERE `team_id`=$team_seller_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_INCOME_TRANSFER,
                'finance_player_id' => $player_id,
                'finance_team_id' => $team_seller_id,
                'finance_value' => $transferaplication_price,
                'finance_value_after' => $transfer['team_finance'] + $transferaplication_price,
                'finance_value_before' => $transfer['team_finance'],
            );
            f_igosja_finance($finance);

            $sql = "UPDATE `team`
                    SET `team_finance`=`team_finance`-$transferaplication_price
                    WHERE `team_id`=$team_buyer_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_OUTCOME_TRANSFER,
                'finance_player_id' => $player_id,
                'finance_team_id' => $team_buyer_id,
                'finance_value' => -$transferaplication_price,
                'finance_value_after' => $transferaplication_array[0]['team_finance'] - $transferaplication_price,
                'finance_value_before' => $transferaplication_array[0]['team_finance'],
            );
            f_igosja_finance($finance);

            $sql = "UPDATE `player`
                    SET `player_team_id`=$team_buyer_id,
                        `player_transfer_on`=0
                    WHERE `player_id`=$player_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `transfer`
                    LEFT JOIN `player`
                    ON `transfer_player_id`=`player_id`
                    SET `transfer_age`=`player_age`,
                        `transfer_date`=UNIX_TIMESTAMP(),
                        `transfer_power`=`player_power_nominal`,
                        `transfer_price_buyer`=$transferaplication_price,
                        `transfer_ready`=1,
                        `transfer_season_id`=$igosja_season_id,
                        `transfer_team_buyer_id`=$team_buyer_id,
                        `transfer_user_buyer_id`=$user_buyer_id
                    WHERE `transfer_id`=$transfer_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $sql = "INSERT INTO `transferposition` (`transferposition_position_id`, `transferposition_transfer_id`)
                    SELECT `playerposition_position_id`, $transfer_id
                    FROM `playerposition`
                    WHERE `playerposition_player_id`=$player_id";
            f_igosja_mysqli_query($sql);

            $sql = "INSERT INTO `transferspecial` (`transferspecial_level`, `transferspecial_special_id`, `transferspecial_transfer_id`)
                    SELECT `playerspecial_level`, `playerspecial_special_id`, $transfer_id
                    FROM `playerspecial`
                    WHERE `playerspecial_player_id`=$player_id";
            f_igosja_mysqli_query($sql);

            $log = array(
                'history_historytext_id' => HISTORYTEXT_PLAYER_TRANSFER,
                'history_player_id' => $player_id,
                'history_team_id' => $team_seller_id,
                'history_team_2_id' => $team_buyer_id,
                'history_user_id' => $transfer['transfer_user_seller_id'],
                'history_user_2_id' => $user_buyer_id,
                'history_value' => $transferaplication_price,
            );
            f_igosja_history($log);
        }
    }

    usleep(1);

    print '.';
    flush();
}