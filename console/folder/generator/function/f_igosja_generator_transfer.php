<?php

/**
 * Проводимо трансфери хокеїстів
 */
function f_igosja_generator_transfer()
{
    global $igosja_season_id;

    $sql = "SELECT `player_id`,
                   `player_price`,
                   `player_school_id`,
                   `team_finance`,
                   `transfer_id`,
                   `transfer_team_seller_id`,
                   `transfer_to_league`,
                   `transfer_user_seller_id`
            FROM `transfer`
            LEFT JOIN `team`
            ON `transfer_team_seller_id`=`team_id`
            LEFT JOIN `player`
            ON `transfer_player_id`=`player_id`
            WHERE `transfer_ready`=0
            AND `transfer_date`<=UNIX_TIMESTAMP()-86400
            ORDER BY `player_price` DESC, `transfer_id` ASC";
    $transfer_sql = f_igosja_mysqli_query($sql);

    $transfer_array = $transfer_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($transfer_array as $transfer)
    {
        $transfer_id    = $transfer['transfer_id'];
        $team_id        = $transfer['transfer_team_seller_id'];
        $user_id        = $transfer['transfer_user_seller_id'];

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
                       `transferapplication_only_one`,
                       `transferapplication_price`,
                       `transferapplication_team_id`,
                       `transferapplication_user_id`
                FROM `transferapplication`
                LEFT JOIN `team`
                ON `transferapplication_team_id`=`team_id`
                WHERE `transferapplication_transfer_id`=$transfer_id
                AND `transferapplication_price`<=`team_finance`
                AND `transferapplication_team_id` NOT IN ($team_array)
                AND `transferapplication_user_id` NOT IN ($user_array)
                ORDER BY `transferapplication_price` DESC, `transferapplication_date` ASC
                LIMIT 1";
        $transferaplication_sql = f_igosja_mysqli_query($sql);

        if ($transferaplication_sql->num_rows)
        {
            $transferaplication_array = $transferaplication_sql->fetch_all(MYSQLI_ASSOC);

            $transferaplication_price   = $transferaplication_array[0]['transferapplication_price'];
            $school_price               = round($transferaplication_price / 100);
            $team_buyer_id              = $transferaplication_array[0]['transferapplication_team_id'];
            $user_buyer_id              = $transferaplication_array[0]['transferapplication_user_id'];
            $team_seller_id             = $transfer['transfer_team_seller_id'];
            $player_id                  = $transfer['player_id'];
            $school_id                  = $transfer['player_school_id'];

            if (0 != $team_seller_id)
            {
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
            }

            $sql = "SELECT `team_finance`
                    FROM `team`
                    WHERE `team_id`=$school_id
                    LIMIT 1";
            $school_sql = f_igosja_mysqli_query($sql);

            $school_array = $school_sql->fetch_all(MYSQLI_ASSOC);

            $sql = "UPDATE `team`
                    SET `team_finance`=`team_finance`+$school_price
                    WHERE `team_id`=$school_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_INCOME_TRANSFER_FIRST_TEAM,
                'finance_player_id' => $player_id,
                'finance_team_id' => $school_id,
                'finance_value' => $school_price,
                'finance_value_after' => $school_array[0]['team_finance'] + $school_price,
                'finance_value_before' => $school_array[0]['team_finance'],
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
                    SET `player_line_id`=0,
                        `player_noaction`=UNIX_TIMESTAMP()+604800,
                        `player_nodeal`=1,
                        `player_order`=0,
                        `player_team_id`=$team_buyer_id,
                        `player_transfer_on`=0
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

            $sql = "UPDATE `transfer`
                    LEFT JOIN `player`
                    ON `transfer_player_id`=`player_id`
                    SET `transfer_age`=`player_age`,
                        `transfer_date`=UNIX_TIMESTAMP(),
                        `transfer_player_price`=`player_price`,
                        `transfer_power`=`player_power_nominal`,
                        `transfer_price_buyer`=$transferaplication_price,
                        `transfer_ready`=1,
                        `transfer_season_id`=$igosja_season_id,
                        `transfer_team_buyer_id`=$team_buyer_id,
                        `transfer_user_buyer_id`=$user_buyer_id
                    WHERE `transfer_id`=$transfer_id";
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
                'history_value' => $transferaplication_price,
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

            if (1 == $transferaplication_array[0]['transferapplication_only_one'])
            {
                $sql = "DELETE FROM `transferapplication`
                        WHERE `transferapplication_team_id`=$team_buyer_id
                        AND `transferapplication_transfer_id` IN
                        (
                            SELECT `transfer_id`
                            FROM `transfer`
                            WHERE `transfer_ready`=0
                        )";
                f_igosja_mysqli_query($sql);
            }
        }
        elseif (1 == $transfer['transfer_to_league'])
        {
            $transferaplication_price   = round($transfer['player_price'] / 2);
            $school_price               = round($transferaplication_price / 100);
            $team_buyer_id              = 0;
            $user_buyer_id              = 0;
            $team_seller_id             = $transfer['transfer_team_seller_id'];
            $player_id                  = $transfer['player_id'];
            $school_id                  = $transfer['player_school_id'];

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

            $sql = "SELECT `team_finance`
                    FROM `team`
                    WHERE `team_id`=$school_id
                    LIMIT 1";
            $school_sql = f_igosja_mysqli_query($sql);

            $school_array = $school_sql->fetch_all(MYSQLI_ASSOC);

            $sql = "UPDATE `team`
                    SET `team_finance`=`team_finance`+$school_price
                    WHERE `team_id`=$school_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_INCOME_TRANSFER_FIRST_TEAM,
                'finance_player_id' => $player_id,
                'finance_team_id' => $school_id,
                'finance_value' => $school_price,
                'finance_value_after' => $school_array[0]['team_finance'] + $school_price,
                'finance_value_before' => $school_array[0]['team_finance'],
            );
            f_igosja_finance($finance);

            $sql = "UPDATE `player`
                    SET `player_line_id`=0,
                        `player_noaction`=UNIX_TIMESTAMP()+604800,
                        `player_team_id`=$team_buyer_id,
                        `player_transfer_on`=0
                    WHERE `player_id`=$player_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `transfer`
                    LEFT JOIN `player`
                    ON `transfer_player_id`=`player_id`
                    SET `transfer_age`=`player_age`,
                        `transfer_date`=UNIX_TIMESTAMP(),
                        `transfer_player_price`=`player_price`,
                        `transfer_power`=`player_power_nominal`,
                        `transfer_price_buyer`=$transferaplication_price,
                        `transfer_ready`=1,
                        `transfer_season_id`=$igosja_season_id,
                        `transfer_team_buyer_id`=$team_buyer_id,
                        `transfer_user_buyer_id`=$user_buyer_id
                    WHERE `transfer_id`=$transfer_id";
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
                'history_historytext_id' => HISTORYTEXT_PLAYER_FREE,
                'history_player_id' => $player_id,
                'history_team_id' => $team_seller_id,
                'history_team_2_id' => $team_buyer_id,
                'history_value' => $transferaplication_price,
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
        }
    }
}