<?php

/**
 * Перевіряємо трансфери хокеїстів
 */
function f_igosja_generator_transfer_check()
{
    $sql = "SELECT `player_id`,
                   `player_school_id`,
                   `transfer_id`,
                   `transfer_price_buyer`,
                   `transfer_team_buyer_id`,
                   `transfer_team_seller_id`,
                   `transfer_user_buyer_id`,
                   `transfer_user_seller_id`
            FROM `transfer`
            LEFT JOIN `player`
            ON `transfer_player_id`=`player_id`
            WHERE `transfer_ready`=1
            AND `transfer_checked`=0
            AND FROM_UNIXTIME(`transfer_date`+604800, '%Y-%m-%d')<=CURDATE()
            ORDER BY `transfer_id` ASC";
    $transfer_sql = f_igosja_mysqli_query($sql);

    $transfer_array = $transfer_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($transfer_array as $transfer)
    {
        $transfer_id = $transfer['transfer_id'];

        $sql = "SELECT SUM(`transfervote_rating`) AS `rating`
                FROM `transfervote`
                WHERE `transfervote_transfer_id`=$transfer_id";
        $transfervote_sql = f_igosja_mysqli_query($sql);

        $transfervote_array = $transfervote_sql->fetch_all(MYSQLI_ASSOC);

        if ($transfervote_array[0]['rating'] < 0)
        {
            $player_id      = $transfer['player_id'];
            $price          = $transfer['transfer_price_buyer'];
            $school_id      = $transfer['player_school_id'];
            $school_price   = round($price / 100);
            $team_buyer_id  = $transfer['transfer_team_buyer_id'];
            $team_seller_id = $transfer['transfer_team_seller_id'];

            $sql = "SELECT `team_finance`
                    FROM `team`
                    WHERE `team_id`=$school_id
                    LIMIT 1";
            $school_sql = f_igosja_mysqli_query($sql);

            $school_array = $school_sql->fetch_all(MYSQLI_ASSOC);

            $sql = "UPDATE `team`
                    SET `team_finance`=`team_finance`-$school_price
                    WHERE `team_id`=$school_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_INCOME_TRANSFER_FIRST_TEAM,
                'finance_player_id' => $player_id,
                'finance_team_id' => $school_id,
                'finance_value' => -$school_price,
                'finance_value_after' => $school_array[0]['team_finance'] - $school_price,
                'finance_value_before' => $school_array[0]['team_finance'],
            );
            f_igosja_finance($finance);

            if (0 != $team_seller_id)
            {
                $sql = "SELECT `team_finance`
                        FROM `team`
                        WHERE `team_id`=$team_seller_id
                        LIMIT 1";
                $seller_sql = f_igosja_mysqli_query($sql);

                $seller_array = $seller_sql->fetch_all(MYSQLI_ASSOC);

                $sql = "UPDATE `team`
                        SET `team_finance`=`team_finance`-$price
                        WHERE `team_id`=$team_seller_id
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $finance = array(
                    'finance_financetext_id' => FINANCETEXT_INCOME_TRANSFER,
                    'finance_player_id' => $player_id,
                    'finance_team_id' => $team_seller_id,
                    'finance_value' => -$price,
                    'finance_value_after' => $seller_array[0]['team_finance'] - $price,
                    'finance_value_before' => $seller_array[0]['team_finance'],
                );
                f_igosja_finance($finance);
            }

            if (0 != $team_buyer_id)
            {
                $sql = "SELECT `team_finance`
                        FROM `team`
                        WHERE `team_id`=$team_buyer_id
                        LIMIT 1";
                $buyer_sql = f_igosja_mysqli_query($sql);

                $buyer_array = $buyer_sql->fetch_all(MYSQLI_ASSOC);

                $sql = "UPDATE `team`
                        SET `team_finance`=`team_finance`+$price
                        WHERE `team_id`=$team_buyer_id
                        LIMIT 1";
                f_igosja_mysqli_query($sql);

                $finance = array(
                    'finance_financetext_id' => FINANCETEXT_OUTCOME_TRANSFER,
                    'finance_player_id' => $player_id,
                    'finance_team_id' => $team_buyer_id,
                    'finance_value' => $price,
                    'finance_value_after' => $buyer_array[0]['team_finance'] + $price,
                    'finance_value_before' => $buyer_array[0]['team_finance'],
                );
                f_igosja_finance($finance);
            }

            $sql = "UPDATE `player`
                    SET `player_line_id`=0,
                        `player_noaction`=0,
                        `player_nodeal`=0,
                        `player_team_id`=$team_seller_id
                    WHERE `player_id`=$player_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $log = array(
                'history_historytext_id' => HISTORYTEXT_PLAYER_TRANSFER,
                'history_player_id' => $player_id,
                'history_team_id' => $team_buyer_id,
                'history_team_2_id' => $team_seller_id,
                'history_value' => $price,
            );
            f_igosja_history($log);

            $sql = "UPDATE `transfer`
                    SET `transfer_cancel`=1
                    WHERE `transfer_id`=$transfer_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }
    }

    $sql = "UPDATE `transfer`
            SET `transfer_checked`=1
            WHERE `transfer_ready`=1
            AND `transfer_checked`=0
            AND FROM_UNIXTIME(`transfer_date`+604800, '%Y-%m-%d')=CURDATE()";
    f_igosja_mysqli_query($sql);
}