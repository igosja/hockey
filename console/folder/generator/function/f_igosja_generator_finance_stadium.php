<?php

/**
 * Додаємо в каси команд гроші зі стадіонів
 */
function f_igosja_generator_finance_stadium()
{
    $sql = "SELECT `game_guest_team_id`,
                   `game_home_team_id`,
                   `game_ticket`,
                   `game_visitor`,
                   `shedule_stage_id`,
                   `shedule_tournamenttype_id`,
                   `stadium_capacity`,
                   `stadium_maintenance`,
                   `team_id` AS `stadium_team_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `stadium`
            ON `game_stadium_id`=`stadium_id`
            LEFT JOIN `team` AS `team_stadium`
            ON `stadium_id`=`team_stadium_id`
            WHERE `game_played`=0
            AND FROM_UNIXTIME(`shedule_date`, '%Y-%m-%d')=CURDATE()
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $game_array = $game_sql->fetch_all(1);

    foreach ($game_array as $game)
    {
        $home_team_id       = $game['game_home_team_id'];
        $guest_team_id      = $game['game_guest_team_id'];
        $stadium_team_id    = $game['stadium_team_id'];
        $outcome            = $game['stadium_maintenance'];
        $income             = $game['game_ticket'] * $game['game_visitor'];

        if (TOURNAMENTTYPE_FRIENDLY == $game['shedule_tournamenttype_id'])
        {
            $sql = "SELECT `team_finance`
                    FROM `team`
                    WHERE `team_id`=$home_team_id
                    LIMIT 1";
            $finance_sql = f_igosja_mysqli_query($sql);

            $finance_array = $finance_sql->fetch_all(1);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_INCOME_TICKET,
                'finance_team_id' => $home_team_id,
                'finance_value' => $income / 2,
                'finance_value_after' => $finance_array[0]['team_finance'] + $income / 2,
                'finance_value_before' => $finance_array[0]['team_finance'],
            );
            f_igosja_finance($finance);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_OUTCOME_GAME,
                'finance_team_id' => $home_team_id,
                'finance_value' => -$outcome / 2,
                'finance_value_after' => $finance_array[0]['team_finance'] + $income / 2 - $outcome / 2,
                'finance_value_before' => $finance_array[0]['team_finance'] + $income / 2,
            );
            f_igosja_finance($finance);

            $sql = "SELECT `team_finance`
                    FROM `team`
                    WHERE `team_id`'$guest_team_id
                    LIMIT 1";
            $finance_sql = f_igosja_mysqli_query($sql);

            $finance_array = $finance_sql->fetch_all(1);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_INCOME_TICKET,
                'finance_team_id' => $guest_team_id,
                'finance_value' => $income / 2,
                'finance_value_after' => $finance_array[0]['team_finance'] + $income / 2,
                'finance_value_before' => $finance_array[0]['team_finance'],
            );
            f_igosja_finance($finance);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_OUTCOME_GAME,
                'finance_team_id' => $guest_team_id,
                'finance_value' => -$outcome / 2,
                'finance_value_after' => $finance_array[0]['team_finance'] + $income / 2 - $outcome / 2,
                'finance_value_before' => $finance_array[0]['team_finance'] + $income / 2,
            );
            f_igosja_finance($finance);

            $sql = "UPDATE `team`
                    SET `team_finance`=`team_finance`+$income/2-$outcome/2
                    WHERE `team_id` IN ('$home_team_id', '$guest_team_id')";
            f_igosja_mysqli_query($sql);
        }
        elseif (TOURNAMENTTYPE_LEAGUE == $game['shedule_tournamenttype_id'] && STAGE_FINAL == $game['shedule_stage_id'])
        {
            $sql = "SELECT `team_finance`
                    FROM `team`
                    WHERE `team_id`=$home_team_id
                    LIMIT 1";
            $finance_sql = f_igosja_mysqli_query($sql);

            $finance_array = $finance_sql->fetch_all(1);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_INCOME_TICKET,
                'finance_team_id' => $home_team_id,
                'finance_value' => $income / 3,
                'finance_value_after' => $finance_array[0]['team_finance'] + $income / 3,
                'finance_value_before' => $finance_array[0]['team_finance'],
            );
            f_igosja_finance($finance);

            $sql = "SELECT `team_finance`
                    FROM `team`
                    WHERE `team_id`=$guest_team_id
                    LIMIT 1";
            $finance_sql = f_igosja_mysqli_query($sql);

            $finance_array = $finance_sql->fetch_all(1);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_INCOME_TICKET,
                'finance_team_id' => $guest_team_id,
                'finance_value' => $income / 3,
                'finance_value_after' => $finance_array[0]['team_finance'] + $income / 3,
                'finance_value_before' => $finance_array[0]['team_finance'],
            );
            f_igosja_finance($finance);

            $sql = "SELECT `team_finance`
                    FROM `team`
                    WHERE `team_id`=$stadium_team_id
                    LIMIT 1";
            $finance_sql = f_igosja_mysqli_query($sql);

            $finance_array = $finance_sql->fetch_all(1);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_INCOME_TICKET,
                'finance_team_id' => $stadium_team_id,
                'finance_value' => $income / 3,
                'finance_value_after' => $finance_array[0]['team_finance'] + $income / 3,
                'finance_value_before' => $finance_array[0]['team_finance'],
            );
            f_igosja_finance($finance);

            $sql = "UPDATE `team`
                    SET `team_finance`=`team_finance`+$income/3
                    WHERE `team_id` IN ('$home_team_id', '$guest_team_id', '$stadium_team_id')";
            f_igosja_mysqli_query($sql);
        }
        else
        {
            $sql = "SELECT `team_finance`
                    FROM `team`
                    WHERE `team_id`=$home_team_id
                    LIMIT 1";
            $finance_sql = f_igosja_mysqli_query($sql);

            $finance_array = $finance_sql->fetch_all(1);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_INCOME_TICKET,
                'finance_team_id' => $home_team_id,
                'finance_value' => $income,
                'finance_value_after' => $finance_array[0]['team_finance'] + $income,
                'finance_value_before' => $finance_array[0]['team_finance'],
            );
            f_igosja_finance($finance);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_OUTCOME_GAME,
                'finance_team_id' => $home_team_id,
                'finance_value' => -$outcome,
                'finance_value_after' => $finance_array[0]['team_finance'] + $income - $outcome,
                'finance_value_before' => $finance_array[0]['team_finance'] + $income,
            );
            f_igosja_finance($finance);

            $sql = "UPDATE `team`
                    SET `team_finance`=`team_finance`+$income-$outcome
                    WHERE `team_id`=$home_team_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }
    }
}