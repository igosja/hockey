<?php

/**
 * Перевіряємо оренди хокеїстів
 */
function f_igosja_generator_rent_check()
{
    $sql = "SELECT `player_id`,
                   `rent_id`,
                   `rent_price_buyer`,
                   `rent_team_buyer_id`,
                   `rent_team_seller_id`,
                   `rent_user_buyer_id`,
                   `rent_user_seller_id`
            FROM `rent`
            LEFT JOIN `player`
            ON `rent_player_id`=`player_id`
            WHERE `rent_ready`=1
            AND `rent_checked`=0
            AND FROM_UNIXTIME(`rent_date`+604800, '%Y-%m-%d')=CURDATE()
            ORDER BY `rent_id` ASC";
    $rent_sql = f_igosja_mysqli_query($sql);

    $rent_array = $rent_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($rent_array as $rent)
    {
        $rent_id = $rent['rent_id'];

        $sql = "SELECT SUM(`rentvote_rating`) AS `rating`
                FROM `rentvote`
                WHERE `rentvote_rent_id`=$rent_id";
        $rentvote_sql = f_igosja_mysqli_query($sql);

        $rentvote_array = $rentvote_sql->fetch_all(MYSQLI_ASSOC);

        if ($rentvote_array[0]['rating'] < 0)
        {
            $player_id      = $rent['player_id'];
            $price          = $rent['rent_price_buyer'];
            $team_buyer_id  = $rent['rent_team_buyer_id'];
            $team_seller_id = $rent['rent_team_seller_id'];

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
                'finance_financetext_id' => FINANCETEXT_INCOME_RENT,
                'finance_player_id' => $player_id,
                'finance_team_id' => $team_seller_id,
                'finance_value' => -$price,
                'finance_value_after' => $seller_array[0]['team_finance'] - $price,
                'finance_value_before' => $seller_array[0]['team_finance'],
            );
            f_igosja_finance($finance);

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
                'finance_financetext_id' => FINANCETEXT_OUTCOME_RENT,
                'finance_player_id' => $player_id,
                'finance_team_id' => $team_buyer_id,
                'finance_value' => $price,
                'finance_value_after' => $buyer_array[0]['team_finance'] + $price,
                'finance_value_before' => $buyer_array[0]['team_finance'],
            );
            f_igosja_finance($finance);

            $sql = "UPDATE `rent`
                    SET `rent_cancel`=1
                    WHERE `rent_id`=$rent_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }
    }

    $sql = "UPDATE `rent`
            SET `rent_checked`=1
            WHERE `rent_ready`=1
            AND `rent_checked`=0
            AND FROM_UNIXTIME(`rent_date`+604800, '%Y-%m-%d')=CURDATE()";
    f_igosja_mysqli_query($sql);
}