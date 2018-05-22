<?php

/**
 * Проводимо оренди хокеїстів
 */
function f_igosja_generator_rent()
{
    global $igosja_season_id;

    $sql = "SELECT `player_price`,
                   `rent_id`,
                   `rent_player_id`,
                   `rent_team_seller_id`,
                   `rent_user_seller_id`,
                   `team_finance`
            FROM `rent`
            LEFT JOIN `team`
            ON `rent_team_seller_id`=`team_id`
            LEFT JOIN `player`
            ON `rent_player_id`=`player_id`
            WHERE `rent_ready`=0
            AND `rent_date`<UNIX_TIMESTAMP()-86400
            ORDER BY `player_price` DESC, `rent_id` ASC";
    $rent_sql = f_igosja_mysqli_query($sql);

    $rent_array = $rent_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($rent_array as $rent)
    {
        $rent_id = $rent['rent_id'];
        $team_id = $rent['rent_team_seller_id'];
        $user_id = $rent['rent_user_seller_id'];

        $team_array = array($team_id);
        $user_array = array($user_id);

        $sql = "SELECT `transfer_team_buyer_id`,
                       `transfer_team_seller_id`
                FROM `transfer`
                WHERE `transfer_ready`=1
                AND (`transfer_team_buyer_id`=$team_id
                OR `transfer_team_seller_id`=$team_id)
                AND `transfer_team_buyer_id`!=0
                AND `transfer_team_seller_id`!=0
                AND `transfer_season_id`=$igosja_season_id
                ORDER BY `transfer_id` ASC";
        $history_sql = f_igosja_mysqli_query($sql);

        $history_array = $history_sql->fetch_all(MYSQLI_ASSOC);

        foreach ($history_array as $item)
        {
            if (!in_array($item['transfer_team_buyer_id'], array(0, $team_id)))
            {
                $team_array[] = $item['transfer_team_buyer_id'];
            }

            if (!in_array($item['transfer_team_seller_id'], array(0, $team_id)))
            {
                $team_array[] = $item['transfer_team_seller_id'];
            }
        }

        $sql = "SELECT `transfer_user_buyer_id`,
                       `transfer_user_seller_id`
                FROM `transfer`
                WHERE `transfer_ready`=1
                AND (`transfer_user_buyer_id`=$user_id
                OR `transfer_user_seller_id`=$user_id)
                AND `transfer_user_buyer_id`!=0
                AND `transfer_user_seller_id`!=0
                AND `transfer_season_id`=$igosja_season_id
                ORDER BY `transfer_id` ASC";
        $history_sql = f_igosja_mysqli_query($sql);

        $history_array = $history_sql->fetch_all(MYSQLI_ASSOC);

        foreach ($history_array as $item)
        {
            if (!in_array($item['transfer_user_buyer_id'], array(0, $user_id)))
            {
                $user_array[] = $item['transfer_user_buyer_id'];
            }

            if (!in_array($item['transfer_user_seller_id'], array(0, $user_id)))
            {
                $user_array[] = $item['transfer_user_seller_id'];
            }
        }

        $sql = "SELECT `rent_team_buyer_id`,
                       `rent_team_seller_id`
                FROM `rent`
                WHERE `rent_ready`=1
                AND (`rent_team_buyer_id`=$team_id
                OR `rent_team_seller_id`=$team_id)
                AND `rent_team_buyer_id`!=0
                AND `rent_team_seller_id`!=0
                AND `rent_season_id`=$igosja_season_id
                ORDER BY `rent_id` ASC";
        $history_sql = f_igosja_mysqli_query($sql);

        $history_array = $history_sql->fetch_all(MYSQLI_ASSOC);

        foreach ($history_array as $item)
        {
            if (!in_array($item['rent_team_buyer_id'], array(0, $team_id)))
            {
                $team_array[] = $item['rent_team_buyer_id'];
            }

            if (!in_array($item['rent_team_seller_id'], array(0, $team_id)))
            {
                $team_array[] = $item['rent_team_seller_id'];
            }
        }

        $sql = "SELECT `rent_user_buyer_id`,
                       `rent_user_seller_id`
                FROM `rent`
                WHERE `rent_ready`=1
                AND (`rent_user_buyer_id`=$user_id
                OR `rent_user_seller_id`=$user_id)
                AND `rent_user_buyer_id`!=0
                AND `rent_user_seller_id`!=0
                AND `rent_season_id`=$igosja_season_id
                ORDER BY `rent_id` ASC";
        $history_sql = f_igosja_mysqli_query($sql);

        $history_array = $history_sql->fetch_all(MYSQLI_ASSOC);

        foreach ($history_array as $item)
        {
            if (!in_array($item['rent_user_buyer_id'], array(0, $user_id)))
            {
                $user_array[] = $item['rent_user_buyer_id'];
            }

            if (!in_array($item['rent_user_seller_id'], array(0, $user_id)))
            {
                $user_array[] = $item['rent_user_seller_id'];
            }
        }

        $team_array = implode(',', $team_array);
        $user_array = implode(',', $user_array);

        $sql = "SELECT `team_finance`,
                       `rentapplication_day`,
                       `rentapplication_only_one`,
                       `rentapplication_price`,
                       `rentapplication_team_id`,
                       `rentapplication_user_id`
                FROM `rentapplication`
                LEFT JOIN `team`
                ON `rentapplication_team_id`=`team_id`
                WHERE `rentapplication_rent_id`=$rent_id
                AND `rentapplication_price`*`rentapplication_day`<=`team_finance`
                AND `rentapplication_team_id` NOT IN ($team_array)
                AND `rentapplication_user_id` NOT IN ($user_array)
                ORDER BY `rentapplication_price`*`rentapplication_day` DESC, `rentapplication_date` ASC
                LIMIT 1";
        $rentaplication_sql = f_igosja_mysqli_query($sql);

        if ($rentaplication_sql->num_rows)
        {
            $rentaplication_array = $rentaplication_sql->fetch_all(MYSQLI_ASSOC);

            $rentaplication_day     = $rentaplication_array[0]['rentapplication_day'];
            $rentaplication_price   = $rentaplication_array[0]['rentapplication_price'] * $rentaplication_array[0]['rentapplication_day'];
            $team_buyer_id          = $rentaplication_array[0]['rentapplication_team_id'];
            $user_buyer_id          = $rentaplication_array[0]['rentapplication_user_id'];
            $team_seller_id         = $rent['rent_team_seller_id'];
            $player_id              = $rent['rent_player_id'];

            $sql = "UPDATE `team`
                    SET `team_finance`=`team_finance`+$rentaplication_price
                    WHERE `team_id`=$team_seller_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_INCOME_RENT,
                'finance_player_id' => $player_id,
                'finance_team_id' => $team_seller_id,
                'finance_value' => $rentaplication_price,
                'finance_value_after' => $rent['team_finance'] + $rentaplication_price,
                'finance_value_before' => $rent['team_finance'],
            );
            f_igosja_finance($finance);

            $sql = "UPDATE `team`
                    SET `team_finance`=`team_finance`-$rentaplication_price
                    WHERE `team_id`=$team_buyer_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_OUTCOME_RENT,
                'finance_player_id' => $player_id,
                'finance_team_id' => $team_buyer_id,
                'finance_value' => -$rentaplication_price,
                'finance_value_after' => $rentaplication_array[0]['team_finance'] - $rentaplication_price,
                'finance_value_before' => $rentaplication_array[0]['team_finance'],
            );
            f_igosja_finance($finance);

            $sql = "UPDATE `player`
                    SET `player_line_id`=0,
                        `player_noaction`=UNIX_TIMESTAMP()+604800,
                        `player_rent_on`=0,
                        `player_rent_day`=$rentaplication_day,
                        `player_rent_team_id`=$team_buyer_id
                    WHERE `player_id`=$player_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $sql = "DELETE FROM `phisicalchange`
                    WHERE `phisicalchange_player_id`=$player_id
                    AND `phisicalchange_schedule_id`>
                    (
                        SELECT `schedule_id`
                        FROM `schedule`
                        WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
                        LIMIT 1
                    )";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `rent`
                    LEFT JOIN `player`
                    ON `rent_player_id`=`player_id`
                    SET `rent_age`=`player_age`,
                        `rent_date`=UNIX_TIMESTAMP(),
                        `rent_day`=$rentaplication_day,
                        `rent_player_price`=`player_price`,
                        `rent_power`=`player_power_nominal`,
                        `rent_price_buyer`=$rentaplication_price,
                        `rent_ready`=1,
                        `rent_season_id`=$igosja_season_id,
                        `rent_team_buyer_id`=$team_buyer_id,
                        `rent_user_buyer_id`=$user_buyer_id
                    WHERE `rent_id`=$rent_id";
            f_igosja_mysqli_query($sql);

            $sql = "INSERT INTO `rentposition` (`rentposition_position_id`, `rentposition_rent_id`)
                    SELECT `playerposition_position_id`, $rent_id
                    FROM `playerposition`
                    WHERE `playerposition_player_id`=$player_id";
            f_igosja_mysqli_query($sql);

            $sql = "INSERT INTO `rentspecial` (`rentspecial_level`, `rentspecial_special_id`, `rentspecial_rent_id`)
                    SELECT `playerspecial_level`, `playerspecial_special_id`, $rent_id
                    FROM `playerspecial`
                    WHERE `playerspecial_player_id`=$player_id";
            f_igosja_mysqli_query($sql);

            $log = array(
                'history_historytext_id' => HISTORYTEXT_PLAYER_RENT,
                'history_player_id' => $player_id,
                'history_team_id' => $team_seller_id,
                'history_team_2_id' => $team_buyer_id,
                'history_value' => $rentaplication_price,
            );
            f_igosja_history($log);

            $sql = "DELETE FROM `transfer`
                    WHERE `transfer_player_id`=$player_id
                    AND `transfer_ready`=0";
            f_igosja_mysqli_query($sql);

            $sql = "DELETE FROM `rent`
                    WHERE `rent_player_id`=$player_id
                    AND `rent_ready`=0";
            f_igosja_mysqli_query($sql);

            if (1 == $rentaplication_array[0]['rentapplication_only_one'])
            {
                $sql = "DELETE FROM `rentapplication`
                        WHERE `rentapplication_team_id`=$team_buyer_id
                        AND `rentapplication_rent_id` IN
                        (
                            SELECT `rent_id`
                            FROM `rent`
                            WHERE `rent_ready`=0
                        )";
                f_igosja_mysqli_query($sql);
            }
        }
    }
}